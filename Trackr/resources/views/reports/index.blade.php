@extends('layout')

@section('content')
<h1>Reports Index</h1>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Report ID</th>
      <th>User ID</th>
      <th>Type</th>
      <th>Time</th>
      <th>Notes</th>
      <th>Attachment</th>
      <th>Anonymous</th>
    </tr>
  </thead>
  <tbody>
      @foreach($Reports as $Report)
    <tr class="active">
      <td>{{$Report->report_id}}</td>
      <td>{{$Report->user_id}}</td>
      <td>{{$Report->type}}</td>
      <td>{{$Report->notes}}</td>
      <td>{{$Report->has_attachment}}</td>
      <td>{{$Report->is_anonymous}}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection