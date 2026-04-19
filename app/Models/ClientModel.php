<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'clients';
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
        'name',
        'contact_phone',
        'email',
        'password_hash',
        'email_verification_token',
        'email_verification_sent_at',
        'email_verified_at',
        'notes',
        'is_active',
    ];

    protected array $casts = [
        'is_active' => 'boolean',
    ];

    public function findByEmail(string $email): ?array
    {
        $email = trim($email);

        if ($email === '') {
            return null;
        }

        $normalizedEmail = function_exists('mb_strtolower')
            ? mb_strtolower($email, 'UTF-8')
            : strtolower($email);

        return $this->where('LOWER(email)', $normalizedEmail)->first();
    }
}
