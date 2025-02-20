@extends('layouts.layout')

@section('content')
<h4>view map</h4>
    <a href="{{ route('map.index') }}" class="">
        <img src="{{ asset('assets/img/map.png') }}" alt="説明文" class="map-image">
    </a>

    @foreach ($questions as $question)
        <div class="main_question-container">
            <a href="{{ route('questions.show', $question->id) }}" class="question-card">
                <h5 class="card-title">タイトル : {{ $question->title }}</h5>
                <p class="card-text">
                    内容 : {{ $question->body }}
                </p>
                <p class="card-text">投稿者：{{ $question->user->name ?? '匿名' }}さん</p>
                投稿日時 : {{ $question->created_at }}
            </a>

            @if (auth()->check() && (auth()->user()->is_admin || auth()->user()->id === $question->user_id))
                <div class="edidel">
                    <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-danger">edit</a>
                    <form action="{{ route('questions.destroy', $question->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="delete" class="btn btn-danger" onclick="return confirm('本当に削除しますか？');">
                    </form>
                </div>
            @endif
        </div>
    @endforeach

    <a href="{{ route('questions.create') }}" class="">
        <i class="fa-solid fa-square-plus custom-icon"></i>
    </a>
@endsection
