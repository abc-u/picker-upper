<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    function index()
    {
        $tags = Tag::all(); // すべてのタグを取得
        return view('tags.index', compact('tags'));
    }

    // function create()
    // {
    //     $tags = Tag::all(); // すべてのタグを取得
    //     return view('questions.create', compact('tags'));
    // }

    // function edit($id)
    // {
    //     $question = Question::find($id);
    //     return view('questions.edit', compact('question'));
    // }

    function update(Request $request, $id)
    {
        // 指定されたIDのタグを取得
        $tag = Tag::find($id);

        // タグが見つからない場合の処理
        if (!$tag) {
            return redirect()->route('tags.index')->with('error', '指定されたタグが見つかりません。');
        }

        // 入力のバリデーション
        $request->validate([
            'body' => 'required|string|max:255',
        ]);

        // タグの内容を更新
        $tag->body = $request->body;
        $tag->save();

        // 成功メッセージ付きでリダイレクト
        return redirect()->route('tags.index')->with('success', 'タグが更新されました！');
    }


    public function destroy($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return redirect()->route('tags.index')->with('error', 'Tag not found.');
        }

        // `question_tags` テーブルの該当するレコードを削除
        DB::table('question_tags')->where('tag_id', $id)->delete();

        // `tags` テーブルの該当するレコードを削除
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully.');
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'body' => 'required|string|max:10',
        ], [
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは10文字以内で入力してください。',
            'body.required' => '内容を入力してください。',
        ]);

        // 投稿を保存
        $post = new Tag();
        $post->body = $request->body;
        $post->save();

        // // タグを保存（中間テーブルを利用）
        // if ($request->has('tags') && !empty($request->tags)) {
        //     // カンマ区切りの文字列を配列に変換
        //     $tags = explode(',', $request->tags);

        //     // 整数型に変換（無効な値を除去）
        //     $tags = array_filter(array_map('intval', $tags), function ($id) {
        //         return $id > 0; // 0以下の値を除外
        //     });

        //     // タグを同期
        //     $post->tags()->sync($tags);
        // }

        return redirect()->route('tags.index')->with('success', 'タグが作成されました。');
    }
}
