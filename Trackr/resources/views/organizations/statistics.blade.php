@extends('layout')
@section('content')
<h1>Statistics for {{$organizationModel->organization_name}}</h1>

<!-- Chart's container -->
<div id="weekly" style="height: 300px;"></div>

<div id="monthly" style="height: 300px;"></div>

<!-- Charting library -->
<script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

<!-- Your application script -->

<script>
    const chartWeek = new Chartisan({
     el: '#weekly',
     url: "@chart('organization_weekly_cases')",
     data: {"chart":{"labels": {!! str_replace("\/","/",$weekLabels) !!},"extra":null},"datasets":[{"name":"Cases","values":{{$weekData}},"extra":null}]},
     hooks: new ChartisanHooks()
    .colors(['#5755d9'])
    .responsive()
    .beginAtZero()
    .legend({ position: 'bottom' })
    .title('Weekly Cases')
    .datasets(['bar'])
   });

    const chartMonth = new Chartisan({
     el: '#monthly',
     url: "@chart('organization_monthly_cases')",
     data: {"chart":{"labels": {!! str_replace("\/","/",$monthLabels) !!}, "extra":null},"datasets":[{"name":"Cases","values":{{$monthData}},"extra":null}]},
     hooks: new ChartisanHooks()
    .colors(['#5755d9'])
    .responsive()
    .beginAtZero()
    .legend({ position: 'bottom' })
    .title('Monthly Cases')
    .datasets(['bar'])
   }); 

</script>


@endsection