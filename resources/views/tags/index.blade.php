@extends('layouts.layout')
@section('content')

    <!-- タグの一覧 -->
    @foreach ($tags as $tag)
        <!-- タグ名をクリックで編集フォームを表示 -->
        <a href="javascript:void(0);" class="btn btn-outline-primary m-1 tag-btn"
            onclick="toggleEditForm({{ $tag->id }})">
            {{ $tag->body }}
        </a>
    @endforeach

    <!-- 新規作成ボタン -->
    <a href="javascript:void(0);" class="btn btn-primary mt-3" onclick="toggleEditForm('createnew')">
        新規作成
    </a>

    <!-- 編集フォーム（デフォルトは非表示） -->
    @foreach ($tags as $tag)
        <div id="edit-form-{{ $tag->id }}" style="display: none; margin-top: 10px;">
            <form action="{{ route('tags.update', ['id' => $tag->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>内容</label>
                    <textarea class="form-control" rows="3" name="body">{{ $tag->body }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">更新する</button>
            </form>

            <!-- 削除ボタン -->
            <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" style="margin-top: 5px;">
                @csrf
                @method('DELETE')
                <input type="submit" value="削除する" class="btn btn-danger" onclick="return confirm('本当に削除しますか？');">
            </form>
        </div>
    @endforeach

    <!-- 新規作成フォーム -->
    <div id="edit-form-createnew" style="display: none; margin-top: 10px;">
        <form action="{{ route('tags.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>タグ名</label>
                <textarea class="form-control @error('body') is-invalid @enderror" placeholder="タグ名を入力" rows="3" name="body">{{ old('body') }}</textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">作成</button>
        </form>
    </div>

    <script>
        function toggleEditForm(id) {
            // すべての編集フォームを非表示にする
            document.querySelectorAll('[id^="edit-form-"]').forEach(form => {
                form.style.display = 'none';
            });

            // 選択されたフォームのみ表示
            let form = document.getElementById(`edit-form-${id}`);
            if (form) {
                form.style.display = 'block';
            }
        }
    </script>

@endsection
