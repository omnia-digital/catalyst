<?php

namespace App\Models;

use URL;

class NullMedia
{
    public int $id = 0;

    public $type;

    public function __construct($type = 'team') {
        $this->type = $type;
    }

    public function count(): int
    {
        return 0;
    }

    public function first(): static
    {
        return $this;
    }
}