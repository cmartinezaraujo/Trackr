@extends('layout')

@section('content')
<h1>Welcome, {{$user->first_name}}</h1>
<button class="btn"><a href="{{route('users.show', auth()->user())}}">Go to profile</a></button>
@endsection