<?php

namespace App\Enums;

enum ItemUnit: int
{
    case KG   = 1;
    case PCS  = 2;
    case PACK = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::KG   => 'Kg',
            self::PCS  => 'Pcs',
            self::PACK => 'Pack',
        };
    }
}
