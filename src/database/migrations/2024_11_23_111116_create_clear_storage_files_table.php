<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (app()->environment('local')) {
            Storage::disk('public')->deleteDirectory('items');

            Storage::disk('public')->makeDirectory('items');
        }


        if (app()->environment('production')) {

            Storage::disk('s3')->deleteDirectory('items');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clear_storage_files');
    }
};
