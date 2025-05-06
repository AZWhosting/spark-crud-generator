<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class {{entity}} extends Entity
{
    protected $attributes = [
        {{attributes}}
    ];

    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
