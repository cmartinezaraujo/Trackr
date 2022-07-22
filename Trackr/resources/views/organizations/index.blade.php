@extends('layout')

@section('content')
<h1>Organizations Index</h1>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Organization ID</th>
      <th>Lead Member ID</th>
      <th>Organization Name</th>
    </tr>
  </thead>
  <tbody>
      @foreach($Organizations as $Organization)
    <tr class="active">
      <td>{{$Organization->organization_id}}</td>
      <td>{{$Organization->leader_id}}</td>
      <td>{{$Organization->organization_name}}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection