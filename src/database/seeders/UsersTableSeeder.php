<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Profile;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment('local')) {
            // 1人目の店舗代表者を指定して作成
            // $storeManager = User::create([
            // 'name' => 'Store Manager One',
            // 'email' => 'store1@example.com',
            // 'password' => bcrypt('store123'),
            // ]);
            // $storeManager->assignRole('store_manager');
            // $storeManager->givePermissionTo('store_management');
            // $storeManager->update(['email_verified_at' => now()]);

            // 1人目の一般ユーザーを指定して作成
            $user1 = User::create([
                'name' => 'test',
                'email' => 'test@example.com',
                'password' => Hash::make('00000000'),
            ]);

            $directory = 'profile_images/';
            $path1 = $directory . $user1->id . '.png';

            $testImage = public_path('images/profiles/dog.jpg');
            if (app()->environment('production')) {
                Storage::disk('s3')->put($path1, file_get_contents($testImage));
            } else {
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }
                Storage::disk('public')->put($path1, file_get_contents($testImage));
            }

            $user1->profile()->create([
                'user_id' => $user1->id,
                'image' => $path1,
                'postcode' => '123-4567',
                'address' => '東京都東京市東京123-123',
                'building' => '東京マンション101',
            ]);

            // $userOne->assignRole('user');
            // $userOne->givePermissionTo('user');
            // $userOne->update(['email_verified_at' => now()]);

            $user2 = User::create([
                'name' => 'test1',
                'email' => 'test1@example.com',
                'password' => Hash::make('11111111'),
            ]);

            $path2 = $directory . $user2->id . '.png';

            $testImage = public_path('images/profiles/cat.jpg');
            if (app()->environment('production')) {
                Storage::disk('s3')->put($path2, file_get_contents($testImage));
            } else {
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }
                Storage::disk('public')->put($path2, file_get_contents($testImage));
            }

            $user2->profile()->create([
                'user_id' => $user2->id,
                'image' => $path2,
                'postcode' => '891-0123',
                'address' => '東京都渋谷市渋谷456-789',
                'building' => '渋谷マンション909',
            ]);

            // $userOne->assignRole('user');
            // $userOne->givePermissionTo('user');
            // $userOne->update(['email_verified_at' => now()]);

            // 他の一般ユーザーをランダムに生成
            // User::factory(9)->create()->each(function ($user) {
            // $user->assignRole('user');
            // $user->givePermissionTo('user');
            // });
        } elseif (app()->environment('production')) {
            // 1人目の店舗代表者を指定して作成
            // $storeManager = User::create([
            // 'name' => 'Store Manager One',
            // 'email' => 'imakoko39+sub2@gmail.com',
            // 'password' => bcrypt('store123'),
            // ]);
            // $storeManager->assignRole('store_manager');
            // $storeManager->givePermissionTo('store_management');
            // $storeManager->update(['email_verified_at' => now()]);
        }
    }
}
