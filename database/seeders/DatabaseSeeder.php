<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // まずユーザーを作成
        $this->call(UserSeeder::class);

        // その後に質問を作成
        $questions = Question::factory()->count(10)->create();

        // 各質問に対して3件の回答を作成
        // foreach ($questions as $question) {
        //     Answer::factory()->count(3)->create([
        //         'question_id' => $question->id, // 修正ポイント（後述）
        //     ]);
        // }

        // 他のSeederを呼び出し
        $this->call(MapTagSeeder::class);
    }
}
