@extends('layouts.layout')

@section('content')
    <!-- タグフィルタ -->
    @if (Route::currentRouteName() === 'questions.main')
        @foreach ($tags as $tag)
            <a href="{{ route('questions.filterByTag', $tag->id) }}" class="btn btn-outline-primary m-1 tag-btn">
                {{ $tag->body }}
            </a>
        @endforeach
    @else
        @foreach ($tags as $tag)
            <a href="{{ route('questions.main') }}" class="btn btn-secondary">全て表示</a>
            <p class="btn m-1 tag-btn btn-primary">
                {{ $tag->body }}
            </p>
        @endforeach
    @endif




    {{--  @dd($questions)  --}}
    @foreach ($questions as $question)
        <div class="main_question-container">
            <a href="{{ route('questions.show', $question->id) }}" class="question-card">
                <h5 class="card-title">タイトル : {{ $question->title }}</h5>
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
                <div class="container mt-5">
                    <div class="card shadow-sm p-4 rounded" style="max-width: 500px; margin: auto;">
                        <div class="text-center">
                            <div class="user-image mb-3">
                                <img src="{{ asset('assets/img/' . ($question->user->user_icon ? basename($question->user->user_icon) : 'sample.png')) }}"
                                    alt="ユーザー画像" class="rounded-circle img-thumbnail shadow" width="150" height="150">
                            </div>
                            <h4 class="fw-bold">{{ $question->user->name }}</h4>
                        </div>
                    </div>
                </div>
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

    @auth
        <a href="{{ route('questions.create') }}" class="">
            <i class="fa-solid fa-square-plus custom-icon"></i>
        </a>
    @endauth
@endsection

@section('right-content')
    <div class="main_map-section">
        <h4>view map</h4>
        <a href="{{ route('map.index') }}" class="">
            <img src="{{ asset('assets/img/map.png') }}" alt="説明文" class="map-image">
        </a>
    </div>
@endsection
