@extends('layout')
@section('content')
<header class="navbar">
  <section class="navbar-section">
    <a href="{{route('organizations.show', ['organization'=>$organizationModel->organization_id])}}">
      <button class="btn btn-link">Back</button>
    </a>

  </section>

  <section class="navbar-center">
    <h1 class="center-header">Reports for {{$organizationModel->organization_name}}</h1>
  </section>

  <section class="navbar-section">

  </section>

</header>

<section class="bg-secondary">
  <div class="chart" id="weekGraph" style="height: 300px;"></div>
</section>

<section class="bg-gray">
  <div class="chart" id="monthGraph" style="height: 300px;"></div>

</section>

<section class="bg-secondary">
  <div class="chart" id="yearGraph" style="height: 300px;"></div>

</section>

<!-- Charting library -->
<script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

<!-- Your application script -->

<script>
  const chartWeek = new Chartisan({
     el: '#weekGraph',
     url: "@chart('organization_weekly_cases')",
     data: {"chart":{"labels": {!! str_replace("\/","/",$weekLabels) !!},"extra":null},"datasets":[{"name":"Cases","values":{{$weekData}},"extra":null}]},
     hooks: new ChartisanHooks()
    .colors(['#5755d9'])
    .responsive()
    .beginAtZero()
    .legend({ position: 'bottom' })
    .title('Reports This Wekk')
    .datasets(['bar'])
   });

    const chartMonth = new Chartisan({
     el: '#monthGraph',
     url: "@chart('organization_monthly_cases')",
     data: {"chart":{"labels": {!! str_replace("\/","/",$monthLabels) !!}, "extra":null},"datasets":[{"name":"Cases","values":{{$monthData}},"extra":null}]},
     hooks: new ChartisanHooks()
    .colors(['#5755d9'])
    .responsive()
    .beginAtZero()
    .legend({ position: 'bottom' })
    .title('Reports This Month')
    .datasets(['bar'])
   });
   
   const chartYear = new Chartisan({
     el: '#yearGraph',
     url: "@chart('organization_yearly_cases')",
     data: {"chart":{"labels": {!! str_replace("\/","/",$yearLabels) !!}, "extra":null},"datasets":[{"name":"Cases","values":{{$yearData}},"extra":null}]},
     hooks: new ChartisanHooks()
    .colors(['#5755d9'])
    .responsive()
    .beginAtZero()
    .legend({ position: 'bottom' })
    .title('Reports This Year')
    .datasets(['bar'])
   });

</script>


@endsection