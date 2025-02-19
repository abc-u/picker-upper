@extends('layouts.layout')
@section('content')
    <div class="post">
        <h5 class="card-title">タイトル : {{ $question->title }}</h5>
        <p class="card-text">
            内容 : {{ $question->body }}
        </p>
        <p class="card-text">投稿者：{{ $question->user->name ?? '匿名' }}</p>
        投稿日時 : {{ $question->created_at }}
    </div>
    @if (auth()->check() && (auth()->user()->is_admin || auth()->user()->id === $question->user_id))
        <div class="editdelete">
            <a href="{{ route('questions.edit', $question->id) }}" class="edit">edit</a>
            <form action="{{ route('questions.destroy', $question->id) }}" method="post">
                @csrf
                @method('delete')
                <input type="submit" value="削除" class="btn btn-danger" onclick="return confirm('本当に削除しますか？');">
            </form>
        </div>
    @endif

    <h4>投稿場所</h4>
    <div id="map" style="height: 400px; width: 100%;"></div>

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

    <p>コメント一覧</p>
    @foreach ($question->answers as $answer)
        <div class="post">
            <h5 class="">コメント：{{ $answer->body }}</h5>
            <p class="">投稿者：{{ $answer->user->name }}</p>
            <p class="">投稿日時：{{ $answer->created_at }}</p>
        </div>
    @endforeach


    <h5>以下の記事にコメントします</h5>
    <form action="{{ route('comments.store') }}" method="post">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <label>コメント</label>
        <textarea class="form-control" placeholder="内容" rows="5" name="body"></textarea>
        <button type="submit" class="btn btn-primary mt-3">コメントする</button>
    </form>
@endsection
