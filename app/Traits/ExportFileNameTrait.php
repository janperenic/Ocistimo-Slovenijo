<?php

namespace App\Traits;

trait ExportFileNameTrait
{

    public function currentDate(string $name, string $extension = 'json'): string
    {
        return strtr(now()->toDateString() . '_' . $name . '.' . $extension, ['-' => '_', ' ' => ' ']);
    }

    public function name(string $name, string $extension = 'json'): string
    {
        return strtr($name . '.' . $extension, ['-' => '_', ' ' => '_']);
    }
}
