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
      sparkline: {
        enabled: true
      }
    },
    plotOptions: {
      radialBar: {
        startAngle: -90,
        endAngle: 90,
        track: {
          background: "#e7e7e7",
          strokeWidth: "97%",
          margin: 5, // margin is in pixels
          dropShadow: {
            enabled: true,
            top: 2,
            left: 0,
            color: "#999",
            opacity: 1,
            blur: 2
          }
        },
        dataLabels: {
          name: {
            show: false
          },
          value: {
            offsetY: -2,
            fontSize: "22px"
          }
        }
      }
    },
    grid: {
      padding: {
        top: -10
      }
    },
    fill: {
      type: "gradient",
      gradient: {
        shade: "light",
        shadeIntensity: 0.4,
        inverseColors: false,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 50, 53, 91]
      }
    },
    labels: ["Average Results"]
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
