@extends('layouts.layout')
@section('content')
    <form action="{{ route('questions.update', $question->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="form-group mb-3">
            <label>タイトル</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old("title", $question->title) }}" name="title">

            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        </div>
        <div class="form-group">
            <label>内容</label>
            <textarea class="form-control @error('body') is-invalid @enderror" rows="5" name="body">{{ $question->body }}</textarea>
            @error('body')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label>タグを選択:</label>
            <div class="d-flex flex-wrap">
                @foreach ($tags as $tag)
                    @php
                        // $question->tags に $tag->id が含まれているかチェック
                        $isSelected = $question->tags->contains($tag->id);
                    @endphp
                    <button type="button" class="btn m-1 tag-btn {{ $isSelected ? 'btn-primary' : 'btn-outline-primary' }}"
                        data-id="{{ $tag->id }}" onclick="toggleTag(this)">
                        {{ $tag->body }}
                    </button>
                @endforeach
            </div>
            <input type="hidden" name="tags" id="selectedTags" value="{{ $question->tags->pluck('id')->implode(',') }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3 d-block ms-auto">更新する</button>
    </form>

    <script>
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
