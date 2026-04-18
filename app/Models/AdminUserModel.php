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
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = '';

    protected $allowedFields = [
        'username',
        'password_hash',
        'full_name',
        'role',
        'is_active',
    ];

    protected array $casts = [
        'is_active' => 'boolean',
    ];
}
