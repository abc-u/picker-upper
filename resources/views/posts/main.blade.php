@extends('layouts.layout')
@section('content')
    <a href="{{ url('/home') }}" class="post">
        <h5 class="title">これについて教えてもらえますか？</h5>
        <p class="comment-body">
            明日の天気によってどっちに行くか考えているんです、どうですか？どこがいいか教えて欲しいです。雨だと外に出れ
        </p>
        <p class="post-detail">投稿者:ひろき 投稿日時：2025-02-11 11:00:00</p>
    </a>
    
    <dev class="editdelete">
        <a href="{{ url('/edit') }}" class="edit">edit</a>
        <a href="{{ url('/delete') }}"class="delete">delete</a>
    </dev>
@endsection
