@extends('layout')

@section('content')
<h1>Organization Members Index</h1>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Organization ID</th>
      <th>Member ID</th>
      <th>Role</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
      @foreach($OrganizationMembers as $Member)
    <tr class="active">
      <td>{{$Member->organization_id}}</td>
      <td>{{$Member->member_id}}</td>
      <td>{{$Member->role}}</td>
      <td>{{$Member->status}}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection