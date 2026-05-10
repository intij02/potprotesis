<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderEditLogModel extends Model
{
    protected $table            = 'order_edit_logs';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'order_id',
        'admin_user_id',
        'admin_username',
        'admin_full_name',
        'observations',
    ];
}
