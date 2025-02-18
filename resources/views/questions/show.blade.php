@extends('layouts.layout')
@section('content')
    <a href="{{ route('questions.show', $question->id) }}" class="post">
        <h5 class="card-title">タイトル : {{ $question->title }}</h5>
        <p class="card-text">
            内容 : {{ $question->body }}
        </p>
        <p class="card-text">投稿者：Seed Techさん</p>
        投稿日時 : {{ $question->created_at }}
    </a>
    <dev class="editdelete">
        <a href="{{ route('questions.edit', $question->id) }}" class="edit">edit</a>
        <form action='{{ route('questions.destroy', $question->id) }}' method='post'>
            @csrf
            @method('delete')
            <input type='submit' value='削除' class="btn btn-danger" onclick='return confirm("本当に削除しますか？");'>
        </form>
    </dev>

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

    <div class="row justify-content-center">
        <div class="col-md-8 mt-5">
            コメント一覧
            @foreach ($question->answers as $answer)
                <div class="card mt-3">
                    <h5 class="card-header">投稿者：{{ $answer->user->name }}</h5>
                    <div class="card-body">
                        <h5 class="card-title">投稿日時：{{ $answer->created_at }}</h5>
                        <p class="card-text">内容：{{ $answer->body }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <h2>以下の記事にコメントします</h2>
    <form action="{{ route('comments.store') }}" method="post">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <div class="form-group">
            <label>コメント</label>
            <textarea class="form-control" placeholder="内容" rows="5" name="body"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">コメントする</button>
    </form>

@endsection
