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
            'is_admin' => true,
        ]);

        // 通常ユーザーを作成
        User::create([
            'name'     => 'user',
            'email'    => 'user@email.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // 追加の複数ユーザーを作成
        $users = [
            ['name' => 'Alice', 'email' => 'alice@email.com', 'password' => 'password', 'is_admin' => false],
            ['name' => 'Bob', 'email' => 'bob@email.com', 'password' => 'password', 'is_admin' => false],
            ['name' => 'Charlie', 'email' => 'charlie@email.com', 'password' => 'password', 'is_admin' => false],
            ['name' => 'David', 'email' => 'david@email.com', 'password' => 'password', 'is_admin' => false],
            ['name' => 'Eve', 'email' => 'eve@email.com', 'password' => 'password', 'is_admin' => false],
            ['name' => 'Frank', 'email' => 'frank@email.com', 'password' => 'password', 'is_admin' => false],
            ['name' => 'Grace', 'email' => 'grace@email.com', 'password' => 'password', 'is_admin' => false],
            ['name' => 'Hannah', 'email' => 'hannah@email.com', 'password' => 'password', 'is_admin' => false],
        ];

        foreach ($users as $user) {
            User::create([
                'name'     => $user['name'],
                'email'    => $user['email'],
                'password' => Hash::make($user['password']),
                'is_admin' => $user['is_admin'],
            ]);
        }
    }
}
