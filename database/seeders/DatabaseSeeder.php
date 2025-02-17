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

        // タグの作成
        $tag1 = Tag::create(['body' => 'Laravel']);
        $tag2 = Tag::create(['body' => 'PHP']);
        $tag3 = Tag::create(['body' => 'Database']);

        // 質問の作成
        $question1 = Question::create([
            'title' => 'How to use Laravel?',
            'body' => 'I am new to Laravel. Can someone explain the basics?',
            'user_id' => 1,
            'latitude' => 35.6895,
            'longitude' => 139.6917,
            'tag_id' => $tag1->id,
        ]);

        $question2 = Question::create([
            'title' => 'What is Eloquent ORM?',
            'body' => 'How does Eloquent ORM work in Laravel?',
            'user_id' => 2,
            'latitude' => 37.7749,
            'longitude' => -122.4194,
            'tag_id' => $tag2->id,
        ]);

        // タグと質問の関連付け
        $question1->tags()->attach([$tag1->id, $tag3->id]);
        $question2->tags()->attach([$tag2->id]);

        // 回答の作成
        Answer::create([
            'user_id' => 2,
            'body' => 'Laravel is a PHP framework that follows the MVC pattern.',
            'image' => null,
            'questions_id' => $question1->id,
        ]);

        Answer::create([
            'user_id' => 1,
            'body' => 'Eloquent ORM is a powerful tool for database operations in Laravel.',
            'image' => null,
            'questions_id' => $question2->id,
        ]);
    }
}
