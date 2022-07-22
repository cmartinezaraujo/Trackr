@extends('layout')
@section('content')
<header class="navbar bg-secondary">
    <section class="navbar-section">
        <a href="{{route('users.show', $user->id)}}">
            <button class="btn btn-link">Back</button>
        </a>

    </section>

    <section class="navbar-center">
    </section>

    <section class="navbar-section">

    </section>

</header>
<main class="user-graph bg-secondary">
    <h1 class="center-header">{{"{$user->first_name}'s Network Reports Overview"}}</h1>

    <div id="weekGraph" style="height: 300px;"></div>

    <!-- Charting library -->
    <script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

    <!-- Your application script -->

    <script>
        const chartWeek = new Chartisan({
         el: '#weekGraph',
         url: "@chart('user_weekly_cases')",
         data: {"chart":{"labels": {!! str_replace("\/","/",$weekLabels) !!},"extra":null},"datasets":[{"name":"Reports","values":{{$weekData}},"extra":null}]},
         hooks: new ChartisanHooks()
        .colors(['#5755d9'])
        .responsive()
        .beginAtZero()
        .legend({ position: 'bottom' })
        .title('Network Reports')
        .datasets(['bar'])
       });
    
    </script>
</main>

@endsection