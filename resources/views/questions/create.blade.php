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
            <div class="d-flex flex-wrap">
                @foreach ($tags as $tag)
                    <button type="button" class="btn btn-outline-primary m-1 tag-btn"
                            data-id="{{ $tag->id }}" onclick="toggleTag(this)">
                        {{ $tag->body }}
                    </button>
                @endforeach
            </div>
            <input type="hidden" name="tags" id="selectedTags">
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

        function toggleTag(button) {
            button.classList.toggle('btn-primary');
            button.classList.toggle('btn-outline-primary');

            let tagId = button.getAttribute('data-id');
            let selectedTags = document.getElementById('selectedTags');
            let tagsArray = selectedTags.value ? selectedTags.value.split(',') : [];

            if (tagsArray.includes(tagId)) {
                tagsArray = tagsArray.filter(id => id !== tagId);
            } else {
                tagsArray.push(tagId);
            }

            selectedTags.value = tagsArray.join(',');
        }
    </script>
@endsection
