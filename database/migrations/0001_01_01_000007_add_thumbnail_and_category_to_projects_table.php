<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Kategori boleh kosong supaya project lama tetap valid.
            $table->foreignId('category_id')->nullable()->after('stack')
                ->constrained()->nullOnDelete();

            // Hanya menyimpan PATH file (mis. projects/thumbnails/abc.jpg), bukan filenya.
            $table->string('thumbnail')->nullable()->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropColumn('thumbnail');
        });
    }
};
