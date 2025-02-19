<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 回答者のユーザー（既存ユーザーがない場合は自動生成）
            'user_id'    => User::factory(),
            // 回答本文
            'body'       => $this->faker->paragraph,
            // 画像は任意なので、生成する場合としない場合をランダムに
            'image'      => $this->faker->optional()->imageUrl(640, 480, 'cats', true),
            // 質問ID は Seeder 側で指定するため、ここでは設定しない
            // 'questions_id' は Seeder で渡すため省略
        ];
    }
}
