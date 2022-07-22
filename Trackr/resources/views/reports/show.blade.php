@extends('layout')

@section('content')

<h1>All cases reported in your network</h1>

<h1>Case {{$caseInfo->report_id}}</h1>
<p>Reported by: {{$caseInfo->user->first_name}}</p>
<p>Report type: {{$caseInfo->type}}</p>
<p>Report time: {{$caseInfo->reported}}</p>
@endsection