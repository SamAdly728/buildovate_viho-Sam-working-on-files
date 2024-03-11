<script setup>
import { ref, onMounted, computed } from "vue";

var primary = localStorage.getItem("--theme-deafult") || "#24695c";
var secondary = localStorage.getItem("--theme-secondary") || "#ba895d";

const series = ref([76]);
// const chartOptions = ref({});

const chartOptions = computed(() => {
  return {
    chart: {
      type: "radialBar",
      offsetY: -10,
      height: 350
    },
    plotOptions: {
      radialBar: {
        startAngle: -135,
        endAngle: 135,
        dataLabels: {
          name: {
            fontSize: "16px",
            color: undefined,
            offsetY: 120
          },
          value: {
            offsetY: 76,
            fontSize: "22px",
            color: undefined,
            formatter: function (val) {
              return val + "";
            }
          }
        }
      }
    },
    fill: {
      type: "gradient",
      gradient: {
        shade: "dark",
        shadeIntensity: 0.15,
        inverseColors: false,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 50, 65, 91]
      }
    },
    stroke: {
      dashArray: 4
    },
    labels: ["Median Ratio"]
  };
});

onMounted(() => {});
</script>
<template>
  <div>
    <apexchart
      height="320"
      type="radialBar"
      :options="chartOptions"
      :series="series"
    ></apexchart>
  </div>
</template>
