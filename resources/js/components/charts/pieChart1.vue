<template>
    <div id="piechart">
        <apexchart
            :options="chartOptions"
            :series="series"
        ></apexchart>
    </div>
</template>
<script>
var primary = localStorage.getItem('--theme-deafult') || '#24695c';
var secondary = localStorage.getItem('--theme-secondary') || '#ba895d';
export default {
    data(){
        return{
            series: [5, 10, 15, 20, 22],
            chartOptions:{
                chart: {
                    width: 380,
                    type: 'pie',
                    title: "My Daily Activities",
                },
                labels: ['Work', 'Eat', 'Commute', 'Watch TV', 'Sleep'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                colors:[primary, secondary, '#222222', '#717171', '#e2c636']
            }
        }
    }
}
</script>