@extends('layouts.layout')

@section('content')

<p>{{ $user->name }}</p>
<p>{{ $user->email }}</p>
<a href="{{ route('profile.update') }}">編集</a>

@endsection
