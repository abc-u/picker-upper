@extends('layouts.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}" />
    <h1 class="title-span">プロフィール</h1>
    <div class="user-profile d-flex align-items-center p-4 bg-light rounded shadow">
        <!-- ユーザー画像 -->
        <div class="user-image">
            {{-- <img src="{{ asset(auth()->user()->user_icon ? auth()->user()->user_icon : 'assets/img/user_icon/sample.png') }}"
                alt="ユーザー画像" class="rounded-circle img-thumbnail shadow-sm" width="200" height="200"> --}}
            @if (auth()->user()->user_icon)
                <img src="{{ asset(auth()->user()->user_icon) }}" alt="ユーザー画像"
                    class="rounded-circle img-thumbnail shadow-sm">
            @else
                <i class="fa-regular fa-user rounded-circle img-thumbnail shadow-sm"></i>
            @endif

        </div>

        <!-- ユーザー情報 -->
        <div class="user-info">
            <p class="fw-bold mb-1 text-primary">名前</p>
            <p class="fs-5 text-dark">{{ $user->name }}</p>
            <p class="fw-bold mb-1 text-secondary">メールアドレス</p>
            <p class="fs-6 text-muted">{{ $user->email }}</p>
            <a href="{{ route('profile.update') }}" class="btn btn-outline-warning">編集</a>
        </div>
    </div>

    <!-- タブメニュー -->
    <ul class="nav nav-tabs mt-4" id="profileTabs">
        <li class="nav-item">
            <a class="nav-link active" id="questions-tab" data-bs-toggle="tab" href="#questions">
                <h5 class="title-span">自分の質問一覧</h5>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="answers-tab" data-bs-toggle="tab" href="#answers">
                <h5 class="title-span">自分の回答一覧</h5>
            </a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <!-- 自分の質問一覧 -->
        <div class="tab-pane fade show active" id="questions">
            @foreach ($questions as $question)
                <div class="user_question-container">
                    <a href="{{ route('questions.show', $question->id) }}" class="question-card">

                        <div class="question-card_content">
                            <h5 class="question-title">{{ $question->title }}</h5>
                            <div class="question-tags">
                                @foreach ($question->tags as $tag)
                                    <span>
                                        {{ $tag->body }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </a>


                    @if (auth()->check() && (auth()->user()->is_admin || auth()->user()->id === $question->user_id))
                        <div class="edit-delete-buttons">
                            <a href="{{ route('questions.edit', $question->id) }}" class="edit-button">edit</a>
                            <form action="{{ route('questions.destroy', $question->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <input type="submit" value="delete" class="delete-button"
                                    onclick="return confirm('本当に削除しますか？');">
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- 自分の回答一覧 -->
        <div class="tab-pane fade" id="answers">
            @foreach ($answeredQuestions as $answeredQuestion)
                <div class="main_question-container">
                    <a href="{{ route('questions.show', $answeredQuestion->id) }}" class="question-card">


                        <div class="user-info-section">
                            <div class="user-image">
                                @if ($question->user->user_icon)
                                    <img src="{{ asset($question->user->user_icon) }}" alt="ユーザー画像"
                                        class="rounded-circle img-thumbnail shadow-sm">
                                @else
                                    <i class="fa-regular fa-user rounded-circle img-thumbnail shadow-sm"></i>
                                @endif
                            </div>
                            <div class="user-info">
                                <h5 class="user-name">{{ $answeredQuestion->user->name }}</h5>
                                <p class="question_created_at">{{ $question->created_at }}</p>
                            </div>
                        </div>

                        <div class="question-card_content">
                            <h5 class="question-title">{{ $answeredQuestion->title }}</h5>
                            <div class="question-tags">
                                @foreach ($answeredQuestion->tags as $tag)
                                    <span>
                                        {{ $tag->body }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>


    <!-- Bootstrapのタブを動作させるためのJavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var firstTab = new bootstrap.Tab(document.querySelector("#profileTabs .active"));
            firstTab.show();
        });
    </script>
@endsection
