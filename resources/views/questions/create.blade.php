@extends('layouts.layout')
@section('content')
    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>タイトル</label>
            <input type="text" class="form-control" placeholder="タイトルを入力して下さい" name="title">
        </div>
        <div class="form-group">
            <label>内容</label>
            <textarea class="form-control" placeholder="内容" rows="5" name="body"></textarea>
        </div>

        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">

        <div>
            <button type="button" class="btn btn-secondary" onclick="getLocation()">現在地を取得</button>
        </div>

        <div class="form-group mt-3">
            <label>タグを選択:</label>
            @foreach ($tags as $tag)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}">
                    <label class="form-check-label" for="tag{{ $tag->id }}">
                        {{ $tag->body }}
                    </label>
                </div>
            @endforeach
        </div>

        <div>
            <button type="submit" class="btn btn-primary mt-3">作成</button>
        </div>
    </form>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    alert("現在地が取得されました！");
                }, function(error) {
                    alert("位置情報を取得できませんでした。");
                });
            } else {
                alert("このブラウザは位置情報をサポートしていません。");
            }
        }
    </script>
@endsection
