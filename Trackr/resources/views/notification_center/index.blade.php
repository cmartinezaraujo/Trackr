@extends('layout')

@section('content')

<main class="bg-dark">
  <div class="navbar">
    <section class="navbar-section">
      <a class="nav-link"
        href="{{($User->account_type == 'user') ? (route('users.show', $User->id)) : (route('organizations.show', $User->organizationOwner->organization_id))}}">Back</a>
    </section>

    <section class="nav-center">
      <h1>Message Center</h1>
    </section>

    <section class="navbar-section">

    </section>
  </div>
  <div class="notification-center">
    <table class="table table-striped table-hover text-dark">
      <thead>
        <tr>
          <th class="text-light">From</th>
          <th class="text-light">Received</th>
          <th class="text-light">Message</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($Notifications as $notification)
        <tr class="active">
          <td> {{$notification->data['sender']}}</td>
          <td> {{$notification->created_at}}</td>
          <td> {{$notification->data['message']}}</td>
          <td><a href="{{ route('view-message', [$User->id, $notification->id]) }}" method="GET"><button
                class="btn btn-primary">View</button></a>
          </td>
          <td><a href="{{ route('delete-message', [$User->id, $notification->id]) }}" method="GET"><button
                class="btn bg-error">Delete</button></a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</main>

@endsection