<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image; // データベース保存用
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // アップロードフォームの表示
    public function showUploadForm()
    {
        return view('upload');
    }

    // 画像のアップロード処理
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->file('image')) {
            // 画像を `storage/app/public/user_icon/` に保存
            $path = $request->file('image')->store('user_icon', 'public');

            // 現在のログインユーザーの情報を更新
            $user = Auth::user();
            $user->user_icon = $path; // パスをデータベースに保存
            $user->save();

            return back()->with('success', 'プロフィール画像が更新されました！');
        }

        return back()->with('error', '画像のアップロードに失敗しました。');
    }

    // // アップロードされた画像を一覧表示
    // public function index()
    // {
    //     $images = Image::all();
    //     return view('images.index', compact('images'));
    // }

    // // 画像の削除
    // public function destroy($id)
    // {
    //     $image = Image::findOrFail($id);
    //     Storage::delete('public/' . $image->path);
    //     $image->delete();

    //     return back()->with('success', '画像を削除しました。');
    // }
}
