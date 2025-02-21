@extends('layouts.layout')

@section('content')
    <!-- タグフィルタ -->
    <div class="tag-filter">
        {{--  <a href="{{ route('questions.main') }}" class="btn btn-secondary">全て表示</a>  --}}
        @foreach ($tags as $tag)
            <a href="{{ route('questions.filterByTag', $tag->id) }}" class="btn btn-outline-primary m-1 tag-btn">
                {{ $tag->body }}
            </a>
        @endforeach
    </div>

    {{--  @dd($questions)  --}}
    @foreach ($questions as $question)
        <div class="main_question-container">
            <a href="{{ route('questions.show', $question->id) }}" class="question-card">
                <h5 class="card-title">タイトル : {{ $question->title }}</h5>
                <p class="card-text">内容 : {{ $question->body }}</p>
                <p class="card-text">投稿者：{{ $question->user->name ?? '匿名' }}さん</p>
                <p>投稿日時 : {{ $question->created_at }}</p>
                {{--  @dd(@$question->tags)  --}}
                <p>タグ：</p>
                @foreach ($question->tags as $tag)
                    <div class="tag">{{ $tag->body }}</div>
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

    @auth
        <a href="{{ route('questions.create') }}" class="">
            <i class="fa-solid fa-square-plus custom-icon"></i>
        </a>
    @endauth
@endsection

@section('map-content')
    <div class="main_map-section">
        <h4>view map</h4>
        <a href="{{ route('map.index') }}" class="">
            <img src="{{ asset('assets/img/map.png') }}" alt="説明文" class="map-image">
        </a>
    </div>
@endsection
