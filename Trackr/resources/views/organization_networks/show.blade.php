@extends('layout')


<section class="layout">
    <div class="sidebar bg-dark">
        <h1>{{$network->network_name}}</h1>
        <p>Total Reports: {{$reportsCount}}</p>
        <p>Members: {{$network->members->count()}}</p>

        <a class="sidebar-button" href="{{route('search-network-members', ['id'=>$network->network_id])}}">
            <button class="btn btn-primary">Add Members</button>
        </a>

        <a class="sidebar-button" href="{{route('show-network-graphs', $network->network_id)}}">
            <button class="btn btn-primary">View Report Stats</button>
        </a>

        <a class="sidebar-button" href="{{route('organizations.show', ['organization'=>$network->organization_id])}}">
            <button class="btn btn-primary">Back to Organization</button>
        </a>

        <form class="sidebar-button" action="{{ route('organization_networks.destroy', $network->network_id) }}"
            method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-error" type="submit">Delete Network</button>
        </form>
    </div>

    <div class="body">
        <h2 class="center-header">Network Members</h2>
        @if($network->members->count() > 0)

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Health Status</th>
                    <th>Report Count</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($network->members as $Member)
                <tr class="active">
                    <td>{{$Member->user->first_name}}</td>
                    <td>{{$Member->user->last_name}}</td>
                    <td>{{$Member->user->status}}</td>
                    <td>{{$Member->user->cases->count()}}</td>
                    <td>
                        <form action="{{ route('network-member-remove-member', $Member->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="status" name="status" value="remove">
                            </div>
                            @method('PUT')
                            <button class="btn btn-error" type="submit">Remove Member</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('view-member-reports', $Member->member_id) }}"><button
                                class="btn btn-primary">View
                                Reports</button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <div class="empty">
            <div class="empty-icon">
                <i class="icon icon-people"></i>
            </div>
            <p class="empty-title h5">This network has no members</p>
            <p class="empty-subtitle">You can search for elegible member in your organization</p>
            <div class="empty-action">
                <a href="{{route('search-network-members', ['id'=>$network->network_id])}}">
                    <button class="btn btn-primary">Add members</button>
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

@section('content')
@endsection