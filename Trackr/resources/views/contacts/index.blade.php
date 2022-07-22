@extends('layout')

@section('content')
<h1>Contact Index</h1>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Requester ID</th>
      <th>Adressee ID</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
      @foreach($Contacts as $Connection)
    <tr class="active">
      <td>{{$Connection->requester_id}}</td>
      <td>{{$Connection->addressee_id}}</td>
      <td>{{$Connection->status}}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection