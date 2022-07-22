@extends('layout')

@section('content')
<h1>Compose Message</h1>

<!-- CONTACTS TABLE-->
<h3>Contacts</h3>

<a class="btn btn-primary" href="#addContact">Add Contact</a>
<div class="modal modal-sm" id="addContact">
  <a href="#close" class="modal-overlay" aria-label="Close"></a>
  <div class="modal-container">
    <form action="{{ route('add-contact', ['requester_id'=>$User->id]) }}" method="POST">
      @csrf
      <div class="form-group input-group input-inline ">
        <input id="contact_email" name="contact_email" class="form-input" type="text" placeholder="Contact Email">
        <button type="submit" class="btn btn-primary">Send Invite</button>
      </div>
      @method('PUT')
    </form>
  </div>
</div>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Contact name</th>
      <th>Status</th>
      <th>Last login</th>
      <th>Reported cases</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($Network as $Contact)
    <tr class="active">
      <td>{{$Contact->first_name}}</td>
      <td>{{$Contact->status}}</td>
      <td>{{$Contact->last_login}}</td>
      <td>{{$Contact->cases->count()}}</td>
      <td>
        <form action="{{ route('contacts.destroy', $User->id) }}" method="POST">
          @csrf
          <input type="hidden" id="contact_id" name="contact_id" value={{$Contact->id}}>
          @method('DELETE')
          <button class="btn btn-error" type="submit">Remove</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>



@endsection