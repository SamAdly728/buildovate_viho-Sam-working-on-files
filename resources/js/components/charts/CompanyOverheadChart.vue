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
    props: {
        // Define props
        seriesData: {
            type: Array,
            required: true
        },
        chartLabels: {
            type: Array,
            required: false,
            default: () => ['Work', 'Eat', 'Commute', 'Watch TV', 'Sleep'] // Default labels if not provided
        }
    },
    data(){
        return{
            series: this.seriesData,
            chartOptions:{
                chart: {
                    width: 380,
                    type: 'pie',
                    title: "My Daily Activities",
                },
                labels: this.chartLabels,
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
    },
    watch: {
        // Watch for changes in props and update component data accordingly
        seriesData(newVal) {
            this.series = newVal;
        },
        chartLabels(newVal) {
            this.chartOptions.labels = newVal;
        }
    }
}
</script>