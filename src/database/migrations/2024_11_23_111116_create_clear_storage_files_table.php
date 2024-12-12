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

            if (Storage::disk('public')->exists('items')) {
                Storage::disk('public')->deleteDirectory('items');
            }

            if (Storage::disk('public')->exists('profile_images')) {
                Storage::disk('public')->deleteDirectory('profile_images');
            }

            Storage::disk('public')->makeDirectory('items');
            Storage::disk('public')->makeDirectory('profile_images');
        }


        if (app()->environment('production')) {

            if (Storage::disk('s3')->exists('items')) {
                Storage::disk('s3')->deleteDirectory('items');
            }

            if (Storage::disk('s3')->exists('profile_images')) {
                Storage::disk('s3')->deleteDirectory('profile_images');
            }
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
