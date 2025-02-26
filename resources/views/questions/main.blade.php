@extends('layouts.layout')

@section('content')
    <!-- タグフィルタ -->
    <div class="tags-slider">
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
    </div>

    {{--  @php
        $sortOrder = request('sort', 'desc'); // デフォルトは降順（新しい投稿が上）
        $questions = $sortOrder === 'asc' ? $questions->sortBy('created_at') : $questions->sortByDesc('created_at');
    @endphp  --}}

    {{--  <!-- 並び順変更ボタン -->
    <div class="sort-buttons mb-3">
        <a href="?sort=asc" class="btn btn-outline-secondary">昇順</a>
        <a href="?sort=desc" class="btn btn-outline-secondary">降順</a>
    </div>  --}}



    <h2 class="title-span">投稿一覧</h2>

    {{--  <div class="container">
        @foreach ($questions as $question)
            {{ $question->name }}
        @endforeach
    </div>  --}}

    {{ $questions->links() }}

    {{--  <!-- ページネーションのリンクを表示 -->
    <div class="pagination-links">
        {{ $questions->appends(request()->query())->links() }}
    </div>  --}}

    {{--  @dd($questions)  --}}
    @foreach ($questions as $question)
        <div class="main_question-container">
            <a href="{{ route('questions.show', $question->id) }}" class="question-card">


                <div class="user-info-section">
                    <div class="user-image">
                        @if ($question->user->user_icon)
                            <img src="{{ asset($question->user->user_icon) }}" alt="ユーザー画像"
                                class="rounded-circle img-thumbnail shadow-sm">
                        @else
                            <i class="fa-regular fa-user rounded-circle img-thumbnail shadow-sm"></i>
                        @endif
                    </div>
                    <div class="user-info">
                        <h5 class="user-name">{{ $question->user->name }}</h5>
                        <p class="question_created_at">{{ $question->created_at }}</p>
                    </div>
                </div>

                <div class="question-card_content">
                    <h5 class="question-title">{{ $question->title }}</h5>
                    <div class="question-tags">
                        @foreach ($question->tags as $tag)
                            <span>
                                {{ $tag->body }}
                            </span>
                        @endforeach
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

    {{-- Create btn --}}
    @auth
        <a href="{{ route('questions.create') }}" class="">
            <i class="fa-solid fa-square-plus custom-icon"></i>
        </a>
    @endauth

@endsection

{{-- Map section --}}
@section('right-content')
    <div class="main_map-section">
        <h4>View on map</h4>
        <a href="{{ route('map.index') }}" class="">
            <img src="{{ asset('assets/img/map.png') }}" alt="説明文" class="map-image">
        </a>
    </div>
@endsection
