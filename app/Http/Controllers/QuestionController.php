<?php

namespace App\Http\Controllers;

use App\Models\Tag;
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
        $tags = Tag::all(); // すべてのタグを取得

        return view('questions.main', compact('questions', 'tags'));
    }
    function create()
    {
        $tags = Tag::all(); // すべてのタグを取得
        return view('questions.create', compact('tags'));
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

    function update(Request $request, $id)
    {
        $question = Question::find($id);

        $question->title = $request->title;
        $question->body = $request->body;
        $question->save();

        return view('questions.show', compact('question'));
    }

    function destroy($id)
    {
        $post = Question::find($id);
        $post->delete();
        return redirect()->route('questions.main');
    }

    public function store(Request $request)
    {
        // バリデーション（必要に応じて追加）
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'body' => 'required|string',
        //     'tags' => 'array', // タグは配列で送信される
        //     'tags.*' => 'exists:tags,id', // 各タグが `tags` テーブルに存在するか確認
        //     'latitude' => 'nullable|numeric',
        //     'longitude' => 'nullable|numeric',
        // ]);

        // 投稿を保存
        $post = new Question;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::id();
        $post->latitude = $request->latitude;
        $post->longitude = $request->longitude;
        $post->save();

        // タグを保存（中間テーブルを利用）
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('questions.main')->with('success', '質問が作成されました！');
    }

    public function filterByTag(Tag $tag)
    {
        $questions = $tag->questions()->with('user')->latest()->get();
        // $tags = $tag; // すべてのタグを取得
        return view('questions.mainfilter', compact('questions', 'tag'));
    }
}
