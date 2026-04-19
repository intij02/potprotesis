<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table            = 'patients';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    protected $allowedFields = [
        'client_id',
        'name',
        'notes',
        'is_active',
    ];

    protected array $casts = [
        'client_id' => 'integer',
        'is_active' => 'boolean',
    ];
}
