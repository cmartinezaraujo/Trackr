@extends('layout')

@section('content')
<h1>Current Users</h1>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>First Name</th>
      <th>Middle Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Password</th>
      <th>Status</th>
      <th>Vacinated</th>
    </tr>
  </thead>
  <tbody>
    @foreach($People as $User)
    <tr class="active">
      <td>{{$User->id}}</td>
      <td>{{$User->first_name}}</td>
      <td>{{$User->middle_name}}</td>
      <td>{{$User->last_name}}</td>
      <td>{{$User->email}}</td>
      <td>{{$User->password}}</td>
      <td>{{$User->status}}</td>
      <td>{{$User->vaccinated}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection