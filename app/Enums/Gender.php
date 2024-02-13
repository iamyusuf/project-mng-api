<?php

namespace App\Enums;

enum Gender:int
{
    case Male = 1;
    case Female = 2;

    public static function forSelect(): array
    {
        return [
            self::Male->value => [
                'label' => 'Male',
                'description' => 'This is the Male gender',
            ],
            self::Female->value => [
                'label' => 'Female',
                'description' => 'This is the Female gender',
            ],
        ];
    }

}
