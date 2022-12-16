@extends('layouts.client.sidenav')
@section('sidenav')
<style>
    .doughnut{
        height: 300px;
        width: 45%;
    }
    .bar{
        width: 40%;
        margin: 25px;
    }
    #barChart{
        margin: 0px !important;
    }
</style>

<style>

    .doughnut .section-list{
        display: flex;
        gap: 20px;
        flex-direction: column;
    }
    .doughnut .section-list section{
        background: var(--fontNavy);
        padding: 5px;
        font-size: 1.5rem;
        display: flex;
        border-radius: 10px;
        align-items: center;
        color: white;
    }
    i.section-list.fa{
        color: white;
        font-size: 2rem;
        border: 1px solid white;
        border-radius: 50%;
        padding: 10px;
        margin: 5px;
    }
</style>
<section class="report-box" style="padding: 20px 10px;">
    <article class="doughnut" id="donuts">
       <div style="display: flex; justify-content:space-between;">
         <p style="color:gray;">Overall Revenue : </span> <span style="font-size:1.1rem;"> {{ number_format($total) }}</span></p></p>
         <p style="color:gray;">Overall Product : </span> <span style="font-size:1.1rem;"> {{ number_format($totalproduct) }}</span></p></p>
       </div>
        <canvas id="refundChart"></canvas>
    </article>

    <article class="doughnut">
         <div class="section-list">
           <section>
                <i class="section-list fa fa-spinner"></i>
                <span style="margin-right:20px;">Pending : </span>
                <span>{{ number_format($order[0]) }}</span>
           </section>
           <section>
                <i class="section-list fa fa-cart-plus"></i>
                <span style="margin-right:20px;">Approved : </span>
                <span>{{ number_format($order[2]) }}</span>
            </section>
            <section>
                <i class="section-list fa fa-exclamation-triangle"></i>
                <span style="margin-right:20px;">Cancelled : </span>
                <span>{{ number_format($order[1]) }}</span>
           </section>
        </div>
    </article>

    <article class="bar">
        <div style="display:flex; width:100%; gap:100px;">
            <p style="color:gray;">Total Refund : <span style="font-size:1.1rem; color:rgb(255, 205, 86);"> {{ number_format($statustotal[0]) }}</span></p>
            <p style="color:gray;">Total Cancelled : <span style="font-size:1.1rem;  color:rgb(255, 99, 132);"> {{ number_format($statustotal[1]) }}</span></p>
        </div>
        <canvas id="barChart"></canvas>
    </article>
    <article class="bar">
        <p style="color:gray;">Total revenue : <span style="font-size:1.1rem; color:rgb(0, 204, 0);">+ {{ number_format($statustotal[2]) }}</span></p>
        <canvas id="lineChart"></canvas>
   </article>

</section>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    //line
    const lineChart = document.getElementById('lineChart');
    new Chart(lineChart, {
        type: 'line',
        data: {
        labels: @json($line[1]),
        datasets: [{
            label: 'Total Earning',
            data: @json($line[0]),
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        },{
            label: 'Total Delivered',
            data: @json($line[2]),
            fill: false,
            borderColor: 'rgb(34 197 94)',
            tension: 0.1
        }]
        },
    });
</script>


<script>
    const ctx = document.getElementById('refundChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
        labels: ['Refund','Cancelled','Delivered'],
        datasets: [{
        data:  @json($statuscount),
        backgroundColor: [
          'rgb(255, 205, 86)',
          'rgb(255, 99, 132)',
          'rgb(0, 204, 0)'
        ],
         },
         {
        data: @json($statustotal),
        backgroundColor: [
          'rgb(255, 205, 86)',
          'rgb(255, 99, 132)',
          'rgb(0, 204, 0)'
        ],
         }]
        },
    });
</script>

<script>
 //bar
    const bar = document.getElementById('barChart');
    new Chart(bar, {
            type: 'bar',
            data: {
            labels: @json($cancel[1]),
            datasets: [{
            label: 'Refund',
            data: @json($refund[0]),
            backgroundColor: [
                'rgb(255, 205, 86)',
                ],
                borderColor: [
                'rgb(255, 99, 132)',
                ],
                borderWidth: 1
            },
            {
            label: 'Cancelled',
            data: @json($cancel[0]),
            backgroundColor: [
                'rgb(255, 99, 132)',
                ],
                borderColor: [
                'rgb(255, 99, 132)',
                ],
                borderWidth: 1
            },
             {
            label: 'Delivered',
            data: @json($line[2]),
            backgroundColor: [
                'rgb(0, 204, 0)',
                ],
                borderColor: [
                'rgb(255, 99, 132)',
                ],
                borderWidth: 1
            }
        ]
                },
        });

</script>
@endsection


