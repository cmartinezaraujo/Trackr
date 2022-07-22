@extends('layout')
<header class="navbar">
    <section class="navbar-section">
        <a href="{{route('organization_networks.show', $Network->network_id)}}" class="btn btn-link">Back</a>
    </section>

    <section class="navbar-center">
        <h1 class="center-header">Organization members</h1>
    </section>

    <section class="navbar-section">

    </section>
</header>

@if($Members->count() > 0)
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($Members as $Member)
        <tr class="active">
            <td>{{$Member->user->first_name}}</td>
            <td>{{$Member->user->email}}</td>
            <td>
                <form
                    action="{{ route('add-network-member', ['network_id'=>$Network->network_id,'member_id'=>$Member->user->id]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-success" type="submit">Add to Network</button>
                </form>
            </td>
            @endforeach
        </tr>
    </tbody>
</table>
@else
<div class="empty">
    <div class="empty-icon">
        <i class="icon icon-people"></i>
    </div>
    <p class="empty-title h5">No elegible organization members</p>
    <div class="empty-action">
        <div class="empty-action">
            <a href="{{url()->previous()}}">
                <button class="btn btn-primary">Go to Network</button>
            </a>
        </div>
    </div>
</div>

@endif
@section('content')
@endsection