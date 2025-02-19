<?php


declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Connection;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;
use Symfony\Component\HttpFoundation\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Регистрация Telescope для локальной среды
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        // Глобальная политика доступа
        $this->defineGates();

        // Настройки моделей Eloquent
        $this->configureEloquent();

        // Отслеживание длительных запросов к базе данных
        $this->monitorDatabaseQueries();

        // Отслеживание длительности HTTP-запросов
        $this->monitorHttpRequests();

        // Настройка слушателя запросов к базе данных
        $this->setupDatabaseQueryListener();

        // Настройка ограничения скорости запросов
        $this->configureRateLimiting();
    }

    /**
     * Определение правил доступа через Gate.
     */
    protected function defineGates(): void
    {
        Gate::before(static function ($user) {
            // Проверяем, что $user не null и является экземпляром User
            if ($user instanceof User && $user->hasRole('Admin')) {
                return true;
            }

            return null; // Возвращаем null, чтобы продолжить проверки других правил
        });
    }

    /**
     * Конфигурация настроек Eloquent ORM.
     */
    protected function configureEloquent(): void
    {
        Model::preventLazyLoading(!$this->app->isProduction());
        Model::preventSilentlyDiscardingAttributes(!$this->app->isProduction());
        Model::preventAccessingMissingAttributes();
    }

    /**
     * Мониторинг длительных запросов к базе данных.
     */
    protected function monitorDatabaseQueries(): void
    {
        DB::whenQueryingForLongerThan(3000, static function (Connection $connection, QueryExecuted $event) {
            $sql = $event->sql;
            $bindings = $event->bindings;
            $time = $event->time;

            Log::warning("Database query exceeded 3 seconds on connection [{$connection->getName()}].", [
                'sql' => $sql,
                'bindings' => $bindings,
                'time' => $time,
            ]);

        });
    }

    /**
     * Мониторинг длительности HTTP-запросов.
     *
     * @throws BindingResolutionException
     */
    protected function monitorHttpRequests(): void
    {
        /** @var HttpKernel $kernel */
        $kernel = $this->app->make(HttpKernel::class);

        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(4),
            function () {
                $url = request()->fullUrl();

                Log::warning('HTTP request exceeded 4 seconds.', [
                    'url' => $url,
                ]);

            }
        );
    }

    /**
     * Настройка слушателя запросов к базе данных.
     */
    protected function setupDatabaseQueryListener(): void
    {
        DB::listen(static function (QueryExecuted $query) {
            if ($query->time > 1000) {
                Log::warning('An individual database query exceeded 1 second.', [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time,
                ]);
            }
        });
    }

    /**
     * Конфигурация ограничений скорости запросов.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', static function (Request $request) {
            $identifier = $request->user()?->id ?? $request->ip();

            return Limit::perMinute(100)->by($identifier);
        });

        RateLimiter::for('global', static function (Request $request) {
            $identifier = $request->user()?->id ?? $request->ip();

            return Limit::perMinute(5000)
                ->by($identifier)
                ->response(function (Request $request, array $headers) {
                    return response('Take it easy', Response::HTTP_TOO_MANY_REQUESTS, $headers);
                });
        });

        RateLimiter::for('login', static function (Request $request) {
            return Limit::perMinute(15)->by($request->ip());
        });
    }
}

