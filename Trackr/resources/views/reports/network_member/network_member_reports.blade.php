@extends('layout')

@section('content')
<header class="navbar">
    <section class="navbar-section">
        <a href="{{url()->previous()}}" class="btn btn-link">Back</a>
    </section>

    <section class="navbar-center">
        <h1>Reports for {{$member->first_name}} {{$member->last_name}}</h1>
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
        @if($memberReports->count() > 0)
        @foreach ($memberReports as $caseInfo)
        <div class="report-display bg-secondary text-dark">
            <figure class="avitar-card avatar avatar-lg"
                data-initial="{{substr($caseInfo->user->first_name,0,1)}}{{substr($caseInfo->user->first_name,0,1)}}"
                style="background-color: #5755d9;">
                @if ($caseInfo->user->status == 'healthy')
                <i class="avatar-presence online"></i>
                @elseif ($caseInfo->user->status == 'quarantine')
                <i class="avatar-presence away"></i>
                @else
                <i class="avatar-presence busy"></i>
                @endif
            </figure>
            <p></p>
            <p>{{$caseInfo->user->email}}</p>
            <p>Report type: {{$caseInfo->type}}</p>
            <p>Report date: {{$caseInfo->created_at}}</p>
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
        @endif
    </div>
</main>

{{-- <h1 class="center-header">Reports for {{$member->first_name}} {{$member->last_name}}</h1>

@if($memberReports->count() > 0)

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Report ID</th>
            <th>Report Type</th>
            <th>Report Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($memberReports as $caseInfo)
        <tr class="active">
            <td>{{$caseInfo->report_id}}</td>
            <td>{{$caseInfo->type}}</td>
            <td>{{$caseInfo->reported}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="empty">
    <div class="empty-icon">
        <i class="icon icon-check"></i>
    </div>
    <p class="empty-title h5">Your network is healthy at the moment</p>
    <p class="empty-subtitle">No reports have been made.</p>
    <div class="empty-action">
        <a href="{{url()->previous()}}">
            <button class="btn btn-primary">Go to Network</button>
        </a>
    </div>
</div>
@endif --}}

@endsection