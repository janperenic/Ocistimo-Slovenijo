<?php

namespace App\Traits;

trait ExportFileNameTrait
{

    public function currentDate(string $name, string $extension = 'json'): string
    {
        return str_replace('-', '_', now()->toDateString()) . '_' . $name . '.' . $extension;
    }
}
