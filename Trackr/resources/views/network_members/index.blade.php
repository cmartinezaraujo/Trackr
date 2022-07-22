@extends('layout')

@section('content')
<h1>Network Index</h1>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Network ID</th>
      <th>Member ID</th>
    </tr>
  </thead>
  <tbody>
      @foreach($NetworkMembers as $Member)
    <tr class="active">
      <td>{{$Member->network_id}}</td>
      <td>{{$Member->member_id}}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection