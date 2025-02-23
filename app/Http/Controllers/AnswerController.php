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
