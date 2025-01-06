<?php

namespace App\Enums;

enum InvoiceEnum: string
{
    case DRAFT = 'draft';
    case CONFIRMED = 'confirmed';
    case REJECTED = 'rejected';

    public function translate(): string
    {
        return match ($this){
            self::DRAFT => 'Черновик',
            self::CONFIRMED => 'Подтвержден',
            self::REJECTED => 'Отклонен',
        };
    }
}
