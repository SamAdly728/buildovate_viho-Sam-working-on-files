<template>
  <div class="row inter-font">
      <div class="col-12"><h6>Progress Bar</h6></div>
      <div class="col-6">
        <apexchart type="radialBar" :options="chartOptions" :series="[40]"></apexchart>
      </div>
      <div class="col-6"></div>
      <div class="col-12 mb-3">
        <div class="progress-details">
        <div>Money In : $13,000 out of $50,000</div>
        <div>Money Out : $13,000 out of $50,000</div>
        </div>
      </div>
      <div class="col-6">
        <h6>Installers</h6>
        <apexchart type="radialBar" :options="chartOptions" :series="[40]"></apexchart>
      </div>
      <div class="col-6">
        <h6>Materials</h6>
        <apexchart type="radialBar" :options="chartOptions" :series="[40]"></apexchart>
      </div>
      <div class="col-12">
        <div>Commissions : $13,000 out of $50,000</div>
        <div>To Do's : $13,000 out of $50,000</div>
      </div>
    </div>
 </template>
 
 <script setup>

 const chartOptions = {
   chart: {
     type: 'radialBar',
     height: '150px',
     sparkline: {
       enabled: true,
     },
   },
   plotOptions: {
     radialBar: {
       hollow: {
         size: '55%',
       },
       dataLabels: {
         name: {
           show: false,
         },
         value: {
           fontSize: '22px',
           show: true,
           formatter: function (val) {
             return val + '%';
           },
           offsetY: -10,
         },
       },
       track: {
         background: '#e6e6e6',
         strokeWidth: '100%',
       },
       stroke: {
         lineCap: 'round',
         width: 5,
       },      
       startAngle: -90,
       endAngle: 90,
       inverseOrder: true,
     },
   },
   fill: {
     colors: ['#1e5bb2'],
   },
   labels: ['Progress'],
 };
 </script>
 
 <style scoped>
 .dashboard-summary {
   font-family: Arial, sans-serif;
 }
 
 .title h2 {
   margin-bottom: 1rem;
 }
 
 .progress-section {
   display: flex;
   flex-wrap: wrap;
   gap: 2rem;
 }
 
 .progress-bar-item {
   text-align: center;
 }
 
 .progress-details {
   margin-top: 1rem;
   font-size: 0.9rem;
 }
 
 .sub-title {
   font-size: 1.1rem;
   margin: 1rem 0;
 }
 
 /* Add additional styling as needed */
 </style>
 