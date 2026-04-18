<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryItemModel extends Model
{
    protected $table            = 'gallery_items';
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
        'title',
        'image_path',
        'alt_text',
        'sort_order',
        'is_active',
    ];
}
