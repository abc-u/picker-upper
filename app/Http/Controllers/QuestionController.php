<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    // function index()
    // {
    //     $questions = Question::all();
    //     //$questions = "questionだよ";
    //     // $questions = [
    //     //     "mainData" => "questionだよ"
    //     // ];

    //     return response()->view('questions.main', $questions);
    //     //dd($questions);
    //     //return view('questions.main',compact('questions'));
    // }

    function map()
    {
        return view('questions.map');
    }
    function main()
    {
        $questions = Question::all();
        return view('questions.main', compact('questions'));
    }
    function create()
    {
        return view('questions.create');
    }
    function show($id)
    {
        $question = Question::find($id);

        return view('questions.show', compact('question'));
    }
    function edit($id)
    {
        $question = Question::find($id);
        return view('questions.edit', compact('question'));
    }

    function update(Request $request,$id)
    {
        $question = Question::find($id);

        $question -> title = $request -> title;
        $question -> body = $request -> body;
        $question ->save();

        return view('questions.show', compact('question'));
    }

    function destroy($id)
    {
        $post = Question::find($id);
        $post->delete();
        return redirect()->route('questions.main');
    }

    function store(Request $request)
    {
        //dd($request);
        $post = new Question;
        $post -> title = $request -> title;
        $post -> body = $request -> body;
        $post -> user_id = Auth::id();

        $post->latitude = $request->latitude;
        $post->longitude = $request->longitude;

        $post -> save();

        return redirect()->route('questions.main');
    }
}
