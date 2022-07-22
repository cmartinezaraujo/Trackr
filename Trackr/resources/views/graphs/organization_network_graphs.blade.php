@extends('layout')
@section('content')

<header class="navbar">
  <section class="navbar-section">
    <a href="{{route('organization_networks.show', ['organization_network'=>$networkModel->network_id])}}">
      <button class="btn btn-link">Back</button>
    </a>

  </section>

  <section class="navbar-center">
    <h1 class="center-header">Reports for {{$networkModel->network_name}}</h1>
  </section>

  <section class="navbar-section">

  </section>

</header>

<!-- Chart's container -->
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
     url: "@chart('organization_network_weekly_cases')",
     data: {"chart":{"labels": {!! str_replace("\/","/",$weekLabels) !!},"extra":null},"datasets":[{"name":"Reports","values":{{$weekData}},"extra":null}]},
     hooks: new ChartisanHooks()
    .colors(['#5755d9'])
    .responsive()
    .beginAtZero()
    .legend({ position: 'bottom' })
    .title('Reports This Week')
    .datasets(['bar'])
    .padding(20)
   });

    const chartMonth = new Chartisan({
     el: '#monthGraph',
     url: "@chart('organization_network_monthly_cases')",
     data: {"chart":{"labels": {!! str_replace("\/","/",$monthLabels) !!}, "extra":null},"datasets":[{"name":"Reports","values":{{$monthData}},"extra":null}]},
     hooks: new ChartisanHooks()
    .colors(['#5755d9'])
    .responsive()
    .beginAtZero()
    .legend({ position: 'bottom' })
    .title('Reports This Month')
    .datasets(['bar'])
    .padding(20)
   });
   
   const chartYear = new Chartisan({
     el: '#yearGraph',
     url: "@chart('organization_network_yearly_cases')",
     data: {"chart":{"labels": {!! str_replace("\/","/",$yearLabels) !!}, "extra":null},"datasets":[{"name":"Reports","values":{{$yearData}},"extra":null}]},
     hooks: new ChartisanHooks()
    .colors(['#5755d9'])
    .responsive()
    .beginAtZero()
    .legend({ position: 'bottom' })
    .title('Reports This Year')
    .datasets(['bar'])
    .padding(20)
   });

</script>


@endsection