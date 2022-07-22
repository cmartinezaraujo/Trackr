@extends('layout')

@section('content')
<header class="navbar">
    <section class="navbar-section">
        <a href="{{route('users.show', $user_id)}}" class="btn btn-link">Back</a>
    </section>

    <section class="navbar-center">
        <h1>Reports in Your Network</h1>
    </section>

    <section class="navbar-section">
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button class="btn btn-link" :href="route('logout')" onclick="event.preventDefault();
                          this.closest('form').submit();">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </section>
</header>

<main class="bg-dark flex-center">
    <div class="report-list-container">
        @if($cases->count() > 0)
        @foreach ($cases as $caseInfo)
        <div class="report-display bg-secondary text-dark">
            <h2>{{$caseInfo->user->first_name}} {{$caseInfo->user->last_name}}</h2>
            <p>{{$caseInfo->user->email}}</p>
            <p>Report type: {{$caseInfo->type}}</p>
            <p>Report date: {{$caseInfo->reported}}</p>
        </div>
        @endforeach
        @else
        <div class="empty">
            <div class="empty-icon">
                <i class="icon icon-check"></i>
            </div>
            <p class="empty-title h5">All your contacts seem to be healthy!</p>
            <p class="empty-subtitle">No reports have been made.</p>
            <div class="empty-action">
                <a href="{{url()->previous()}}">
                    <button class="btn btn-primary">Go back to Profile</button>
                </a>
            </div>
        </div>
    </div>
</main>

@endif

@endsection