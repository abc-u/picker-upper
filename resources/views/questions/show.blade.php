@extends('layouts.layout')
@section('content')
    <div class="show_card">
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
            <p class="question-body">{!! nl2br(e($question->body)) !!}</p>
            <div class="question-tags">
                @foreach ($question->tags as $tag)
                    <span>
                        {{ $tag->body }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
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

    <div class="show_map-section">
        <h4 class="title-span">投稿場所</h4>
        <div id="map" style="height: 400px;"></div>

        <script>
            function initMap() {
                var location = {
                    lat: parseFloat("{{ $question->latitude ?? 35.6895 }}"),
                    lng: parseFloat("{{ $question->longitude ?? 139.6917 }}")
                };
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    center: location
                });
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
            }
        </script>
    </div>

    <h4 class="title-span">コメント一覧</h4>
    @foreach ($question->answers as $answer)
        <div class="show_card answer">

            <div class="user-info-section">
                <div class="user-image">
                    @if ($answer->user->user_icon)
                        <img src="{{ asset($answer->user->user_icon) }}" alt="ユーザー画像"
                            class="rounded-circle img-thumbnail shadow-sm">
                    @else
                        <i class="fa-regular fa-user rounded-circle img-thumbnail shadow-sm"></i>
                    @endif
                </div>
                <div class="user-info">
                    <h5 class="user-name">{{ $answer->user->name }}</h5>
                    <p class="question_created_at">{{ $answer->created_at }}</p>
                </div>
            </div>

            <div class= "show_card_answer">
                <p class="">{{ $answer->body }}</p>
            </div>

            @if (auth()->check() && (auth()->user()->is_admin || auth()->user()->id === $question->user_id))
                <div class="edit-delete-buttons">
                    <a href="{{ route('answers.edit', $answer->id) }}" class="edit-button">edit</a>

                    <form action="{{ route('answers.destroy', $answer->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="delete" class="delete-button" onclick="return confirm('本当に削除しますか？');">
                    </form>
                </div>
            @endif
        </div>

        {{-- <div class="user-info-section">
            <div class="user-image">
                <img src="{{ asset('storage/user_icon/' . ($question->user->user_icon ? basename($question->user->user_icon) : 'sample.png')) }}"
                    alt="ユーザー画像" class="rounded-circle img-thumbnail shadow-sm">
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
        </div> --}}
    @endforeach



    <h5 class="title-span">以下の記事にコメントします</h5>
    <form action="{{ route('comments.store') }}" method="post">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <label class="">コメント</label>
        <textarea class="form-control" placeholder="内容" rows="5" name="body"></textarea>
        <button type="submit" id="submit_btn" class="btn btn-primary mt-3">コメントする</button>
    </form>
@endsection
