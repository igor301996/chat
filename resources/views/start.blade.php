@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Auth::check())
            <h4 class="text-center">пользователь {{Auth::user()->name}}</h4>
            <socket-chat-component :users="{{ App\User::select('name', 'id')->where('id', '!=', Auth::id())->get() }}" :user="{{ Auth::user() }}"></socket-chat-component>
            @endif
    </div>
@endsection

