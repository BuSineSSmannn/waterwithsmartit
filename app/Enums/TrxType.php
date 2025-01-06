<?php

namespace App\Enums;

enum TrxType: string
{
    case WHITE = 'white';
    case BLACK = 'black';

    public function translate(): string
    {
        return match ($this){
            self::WHITE => 'Белый',
            self::BLACK => 'Черный'
        };
    }
}
