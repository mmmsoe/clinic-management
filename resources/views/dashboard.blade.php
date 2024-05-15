@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <a href="{{ route('clinics.manage') }}" class="nav-link">
                    <h2 class="text-xl font-semibold mb-4 text-blue-500 text-center">診察時間編集</h2>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <a href="{{ route('clinics.manage') }}" class="nav-link">
                    <h2 class="text-xl font-semibold mb-4 text-blue-500 text-center">長期休業設定</h2>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <a href="{{ route('users.index') }}" class="nav-link">
                    <h3 class="text-xl font-semibold mb-4 text-blue-500 text-center">アカウント情報</h3>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection