<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama');           
            $table->string('slug')->unique(); 
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $defaults = [
            ['nama' => 'Desain Publikasi', 'slug' => 'desain-publikasi'],
            ['nama' => 'UI Design',        'slug' => 'ui-design'],
            ['nama' => 'Social Media',     'slug' => 'social-media'],
            ['nama' => 'Web Development',  'slug' => 'web-development'],
            ['nama' => 'Video Editing',    'slug' => 'video-editing'],
            ['nama' => 'Foto Editing',     'slug' => 'foto-editing'],
            ['nama' => 'Fotografi',        'slug' => 'fotografi'],
            ['nama' => 'Lainnya',          'slug' => 'others'],
        ];

        foreach ($defaults as $cat) {
            DB::table('categories')->insert([
                'nama'       => $cat['nama'],
                'slug'       => $cat['slug'],
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
