@extends('layout')

@section('content')
<h1>Attachment Index</h1>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>File ID</th>
      <th>Report ID</th>
      <th>File Location</th>
    </tr>
  </thead>
  <tbody>
      @foreach($ReportData as $Attachment)
    <tr class="active">
      <td>{{$Attachment->file_id}}</td>
      <td>{{$Attachment->report_id}}</td>
      <td>{{$Attachment->file_location}}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection