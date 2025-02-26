<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    // public function create($post_id)
    // {
    //     $post = Post::find($post_id);
    //     return view('comments.create', ['post' => $post]);
    // }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }

        $request->validate([
            'body' => 'required|string|min:5',
            'question_id' => 'required|exists:questions,id',
        ], [
            'body.required' => '回答を入力してください。',
            'body.min' => '回答は1文字以上入力してください。',
            'question_id.required' => '質問IDが必要です。',
            'question_id.exists' => '指定された質問が存在しません。',
        ]);


        $question = Question::find($request->question_id);
        $answer = new Answer;
        $answer->body = $request->body;
        $answer->user_id = Auth::id();
        $answer->questions_id = $request->question_id;
        $answer->save();

        return redirect()->route('questions.show', $question->id);
    }

    function edit($id)
    {
        $answer = Answer::find($id);
        return view('answers.edit', compact('answer'));
    }

    function update(Request $request, $id)
    {
        $answer = Answer::find($id);

        $question = Question::find($answer->questions_id);
        // $answer->title = $request->title;
        $answer->body = $request->body;
        $answer->save();

        return redirect()->route('questions.show', $question->id);
    }

    function destroy($id)
    {
        $answer = Answer::find($id);
        // dd($answer);

        $question = Question::find($answer->questions_id);
        $answer->delete();
        return redirect()->route('questions.show', $question->id);
    }
}
