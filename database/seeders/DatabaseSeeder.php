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
        $this->call([
            UserSeeder::class,
            MapTagSeeder::class,
        ]);

        // questions テーブルにデモデータを10件作成
        $questions = Question::factory()->count(10)->create();

        // 各質問に対して3件の回答を作成
        foreach ($questions as $question) {
            Answer::factory()->count(3)->create([
                'questions_id' => $question->id,
            ]);
        }
    }
}
