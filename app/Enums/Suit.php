<?php

namespace App\Enums;

enum Suit: string
{
    case Hearts = "H";
    case Diamonds = "D";
    case Clubs = "C";
    case Spades = "S";

    public function color(): string
    {
        return match($this) {
            Suit::Hearts, Suit::Diamonds => 'Red',
            Suit::Clubs, Suit::Spades => 'Black'
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function forSelect(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public static function forSelect2(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_column(self::cases(), 'name')
        );
    }
}
