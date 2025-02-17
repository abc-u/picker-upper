<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 管理者ユーザーを作成
        User::create([
            'name'     => 'admin',
            'email'    => 'admin@email.com',
            'password' => Hash::make('password'), // 本番環境では強力なパスワードを設定してください
            'is_admin'     => true,
        ]);

        // 通常ユーザーを作成
        User::create([
            'name'     => 'user',
            'email'    => 'user@email.com',
            'password' => Hash::make('password'),
            'is_admin'     => false,
        ]);
    }
}
