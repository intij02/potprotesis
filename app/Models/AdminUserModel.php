<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminUserModel extends Model
{
    protected $table            = 'admin_users';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'username',
        'password_hash',
        'full_name',
        'is_active',
    ];

    protected array $casts = [
        'is_active' => 'boolean',
    ];
}
