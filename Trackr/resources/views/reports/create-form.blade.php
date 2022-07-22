@extends('layout')

@section('content')


<main class="flex-center bg-primary">

  <div class="bg-secondary text-dark report-container">

    <h1>Create a Report</h1>

    <form method="POST" action="{{ route('reports.store')}}">
      @csrf
      <div class="form-group">
        <!--Place holder for variables when authentication is implemented -->
        <p>First Name: {{$user->first_name}}</p>
        <p>Last Name: {{$user->last_name}}</p>

        <select class="form-select" name="type">
          <option>Select report type</option>
          <option value="sick">Sick (Positive Test)</option>
          <option value="exposed">Exposure</option>
        </select>

        {{-- <label class="form-switch">
          <input type="checkbox" name="anonymous">
          <i class="form-icon"></i> Make report anonymous
        </label> --}}

        <label class="form-label" for="notes">Notes:</label>
        <textarea class="form-input" id="notes" placeholder="Textarea" rows="3" name="notes"></textarea>
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <button type="submit" class="btn btn-primary">Report</button>
      </div>

    </form>
  </div>

</main>


@endsection