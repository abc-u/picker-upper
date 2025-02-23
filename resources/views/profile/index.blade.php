@extends('layouts.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}" />
    <h1 class="title-span">プロフィール</h1>
    <div class="user-profile d-flex align-items-center p-4 bg-light rounded shadow">
        <!-- ユーザー画像 -->
        <div class="user-image me-4">
            {{--  <img src="{{ asset('/img/' . ($user->user_icon ? basename($user->user_icon) : 'sample.png')) }}"
                alt="ユーザー画像" class="rounded-circle img-thumbnail shadow-sm" width="200" height="200">  --}}
            <img src="{{ asset('storage/user_icon/' . (auth()->user()->user_icon ? basename(auth()->user()->user_icon) : 'sample.png')) }}"
                alt="ユーザー画像" class="rounded-circle img-thumbnail shadow-sm" width="200" height="200">
        </div>

        <!-- ユーザー情報 -->
        <div class="user-info">
            <p class="fw-bold mb-1 text-primary">名前</p>
            <p class="fs-5 text-dark">{{ $user->name }}</p>
            <p class="fw-bold mb-1 text-secondary">メールアドレス</p>
            <p class="fs-6 text-muted">{{ $user->email }}</p>
            <a href="{{ route('profile.update') }}">編集</a>
        </div>
    </div>



    <h3 class="title-span">自分の質問一覧</h3>
    @foreach ($questions as $question)
        <div class="main_question-container">
            <a href="{{ route('questions.show', $question->id) }}" class="question-card">
                <h5 class="card-title comment-title">タイトル : {{ $question->title }}</h5>
                <p class="card-text">内容 : {{ $question->body }}</p>
                <p class="card-text">投稿者：{{ $question->user->name ?? '匿名' }}さん</p>
                <p>投稿日時 : {{ $question->created_at }}</p>
                {{--  @dd(@$question->tags)  --}}
                {{--  <p class="d-inline">タグ：</p>  --}}
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


    <h3 class="title-span">自分の回答一覧</h3>
    @foreach ($answeredQuestions as $answeredQuestion)
        <div class="main_question-container">
            <a href="{{ route('questions.show', $answeredQuestion->id) }}" class="question-card">
                <h5 class="card-title comment-title">タイトル : {{ $answeredQuestion->title }}</h5>
                <p class="card-text">内容 : {{ $answeredQuestion->body }}</p>
                <p class="card-text">投稿者：{{ $answeredQuestion->user->name ?? '匿名' }}さん</p>
                <p>投稿日時 : {{ $answeredQuestion->created_at }}</p>
                {{--  @dd(@$answeredQuestion->tags)  --}}
                {{--  <p class="d-inline">タグ：</p>  --}}
                @foreach ($answeredQuestion->tags as $tag)
                    <p class="btn btn-outline-primary m-1 tag-btn">
                        {{ $tag->body }}
                    </p>
                @endforeach
            </a>

            @if (auth()->check() && (auth()->user()->is_admin || auth()->user()->id === $answeredQuestion->user_id))
                <div class="edit-delete-buttons">
                    <a href="{{ route('questions.edit', $answeredQuestion->id) }}" class="edit-button">edit</a>
                    <form action="{{ route('questions.destroy', $answeredQuestion->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="delete" class="delete-button" onclick="return confirm('本当に削除しますか？');">
                    </form>
                </div>
            @endif
        </div>
    @endforeach
@endsection
