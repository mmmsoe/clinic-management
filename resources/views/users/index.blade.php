@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <label class="text-lg text-center">アカウント情報</label>
    </div>

    <div class="container bg-white d-inline-block p-4">
        <table class="table">
            <thead>
                <tr>
                    <th>メールアドレス</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>

                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">パスワード変更</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">メールアドレス</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection