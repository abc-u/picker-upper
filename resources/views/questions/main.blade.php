@extends('layouts.layout')
@section('content')
    @foreach ($questions as $question)
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
    @endforeach
@endsection
