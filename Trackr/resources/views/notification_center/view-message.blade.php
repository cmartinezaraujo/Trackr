@extends('layout')

@section('content')
<main class="message-container bg-dark">
  <div class="notification-card bg-primary">
    <p>From: {{$Notification->data['sender']}} </p>
    <p>Received: {{$Notification->created_at}}</p>

    <div>
      <span id="message">
        {{$Notification->data['message']}}
      </span>
    </div>
    <div class="button-links">
      <a href="{{ route('delete-message', [$user_id, $Notification->id]) }}" method="GET"><button
          class="btn bg-error">Delete</button></a>
      <a href="{{ route('user-notification-center', $user_id) }}" method="GET"><button
          class="btn bg-success">Save</button></a>
    </div>
  </div>
</main>
@endsection