@extends('layout')

@section('content')
<h1>Organization Networks Index</h1>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Network ID</th>
      <th>Organization ID</th>
      <th>Creator ID</th>
      <th>Network Name</th>
    </tr>
  </thead>
  <tbody>
      @foreach($OrganizationNetworks as $Network)
    <tr class="active">
      <td>{{$Network->network_id}}</td>
      <td>{{$Network->organization_id}}</td>
      <td>{{$Network->creator_id}}</td>
      <td>{{$Network->network_name}}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection