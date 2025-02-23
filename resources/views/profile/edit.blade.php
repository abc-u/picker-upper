@extends('layouts.layout')

@section('content')
    @include('profile.partials.update-profile-information-form')

    @include('profile.partials.update-password-form')

    @include('profile.partials.delete-user-form')

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('upload.image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" required>
        <button type="submit">アップロード</button>
    </form>
@endsection
