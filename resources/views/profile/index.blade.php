@extends('layouts.layout')

@section('content')
    <p>{{ $user->name }}</p>
    <p>{{ $user->email }}</p>
    <p>
        <img src="{{ asset('assets/img/' . ($user->user_icon ? basename($user->user_icon) : 'sample.png')) }}" alt="サンプル画像"
            class="rounded-circle img-thumbnail" width="200" height="200">
    </p>

    <a href="{{ route('profile.update') }}">編集</a>
    <h3>自分の質問一覧</h3>
    @foreach ($questions as $question)
        <div class="main_question-container">
            <a href="{{ route('questions.show', $question->id) }}" class="question-card">
                <h5 class="card-title">タイトル : {{ $question->title }}</h5>
                <p class="card-text">内容 : {{ $question->body }}</p>
                <p class="card-text">投稿者：{{ $question->user->name ?? '匿名' }}さん</p>
                <p>投稿日時 : {{ $question->created_at }}</p>
                {{--  @dd(@$question->tags)  --}}
                <p class="d-inline">タグ：</p>
                @foreach ($question->tags as $tag)
                    <p class="btn btn-outline-primary m-1 tag-btn">
                        {{ $tag->body }}
                    </p>
                @endforeach
            </a>

            @if (auth()->check() && (auth()->user()->is_admin || auth()->user()->id === $question->user_id))
                <div class="edit-delete-buttons">
                    <a href="{{ route('questions.edit', $question->id) }}" class="edit-button">edit</a>
                    <form action="{{ route('questions.destroy', $question->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="delete" class="delete-button" onclick="return confirm('本当に削除しますか？');">
                    </form>
                </div>
            @endif
        </div>
    @endforeach
@endsection
