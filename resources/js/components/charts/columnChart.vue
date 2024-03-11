<template>
  <div id="column-chart">
      <apexchart
        type="bar"
        height="250"
        ref="bar"
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
             series: [
            {
              name: 'Net Profit',
              data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
            },
            {
              name: 'Revenue',
              data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
            },
            {
              name: 'Free Cash Flow',
              data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
            },
          ],
          chartOptions:{
              chart:{
                height:250,
                type: 'bar',
                toolbar:{
                  show: false
                }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            e̶n̶d̶i̶n̶g̶S̶h̶a̶p̶e̶: 'rounded',
          borderRadius: 6,
            columnWidth: '55%',
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    
    xaxis: {
        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
    },
    yaxis: {
        title: {
            text: '$ (thousands)'
        }
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "$ " + val + " thousands"
            }
        }
    },
    colors:[primary, secondary, '#222222']
          }
        
        }
    }
}
</script>