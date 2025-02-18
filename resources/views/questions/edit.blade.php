@extends('layouts.layout')
@section('content')

<form action="{{ route('questions.update',$question->id) }}" method="POST">
    @csrf
    @method('put')
    <div class="form-group">
        <label>タイトル</label>
        <input type="text" class="form-control" value="{{ $question->title }}" name="title">
    </div>
    <div class="form-group">
        <label>内容</label>
        <textarea class="form-control" rows="5" name="body">{{ $question->body }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">更新する</button>
</form>


@endsection
