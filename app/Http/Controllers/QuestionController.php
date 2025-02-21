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


    public function filterByTag(Tag $tag)
    {
        $questions = $tag->questions()->with('user')->latest()->get();
        $tags = Tag::where('id', $tag->id)->get(); // 指定された $tag のみ取得

        return view('questions.main', compact('questions', 'tags'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'nullable|string', // タグはカンマ区切りの文字列として送信される
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ], [
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'body.required' => '内容を入力してください。',
        ]);

        // 投稿を保存
        $post = new Question;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = Auth::id();
        $post->latitude = $request->latitude;
        $post->longitude = $request->longitude;
        $post->save();

        // タグを保存（中間テーブルを利用）
        if ($request->has('tags') && !empty($request->tags)) {
            // カンマ区切りの文字列を配列に変換
            $tags = explode(',', $request->tags);

            // 整数型に変換（無効な値を除去）
            $tags = array_filter(array_map('intval', $tags), function ($id) {
                return $id > 0; // 0以下の値を除外
            });

            // タグを同期
            $post->tags()->sync($tags);
        }

        return redirect()->route('questions.main')->with('success', '質問が作成されました。');
    }
}
