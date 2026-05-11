<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogPostsTable extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('blog_posts')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 180,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'content' => [
                'type' => 'LONGTEXT',
            ],
            'image_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug', 'uq_blog_posts_slug');
        $this->forge->createTable('blog_posts', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('blog_posts', true);
    }
}
