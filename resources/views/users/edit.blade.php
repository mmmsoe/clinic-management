@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <label class="text-lg text-center">アカウント情報</label>
    </div>

    <div class="container bg-white d-inline-block p-4">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required disabled>
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">パスワード（確認）</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary">アカウントを保存する</button>
        </form>
    </div>
</div>
@endsection