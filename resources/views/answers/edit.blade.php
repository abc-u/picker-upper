@extends('layouts.layout')
@section('content')

<form action="{{ route('answers.update',$answer->id) }}" method="POST">
    @csrf
    @method('put')
    <div class="form-group">
        <label>内容</label>
        <textarea class="form-control" rows="5" name="body">{{ $answer->body }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary mt-3 d-block ms-auto">更新する</button>
</form>

@endsection
