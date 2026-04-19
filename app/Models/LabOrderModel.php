<?php

namespace App\Models;

use CodeIgniter\Model;

class LabOrderModel extends Model
{
    protected $table            = 'lab_orders';
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
        'order_number',
        'sent_date',
        'required_date',
        'client_id',
        'patient_id',
        'dentist_name',
        'patient_name',
        'contact_phone',
        'status',
        'shade',
        'work_types',
        'selected_teeth',
        'restoration_types',
        'implant_case',
        'implant_chimney',
        'observations',
        'signature_name',
    ];

    protected array $casts = [
        'client_id'          => 'integer',
        'patient_id'         => 'integer',
        'work_types'         => 'json-array',
        'selected_teeth'     => 'json-array',
        'restoration_types'  => 'json-array',
        'implant_case'       => 'boolean',
    ];
}
