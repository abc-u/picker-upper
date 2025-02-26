<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Cebu City周辺の座標の範囲（例）
        $minLatitude  = 10.3000;
        $maxLatitude  = 10.3300;
        $minLongitude = 123.8700;
        $maxLongitude = 123.9000;

        return [
            'title'    => $this->faker->sentence,
            'body'     => $this->faker->paragraph,
            // user_id は既存のユーザーが存在する前提、またはここでUserファクトリーを利用
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            // Cebu City周辺のランダムな緯度・経度を生成
            'latitude'  => $this->faker->latitude($minLatitude, $maxLatitude),
            'longitude' => $this->faker->longitude($minLongitude, $maxLongitude),
        ];
    }
}
