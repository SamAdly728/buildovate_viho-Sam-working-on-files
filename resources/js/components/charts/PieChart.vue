<script setup>
import { ref, onMounted, computed } from "vue";

var primary = localStorage.getItem("--theme-deafult") || "#24695c";
var secondary = localStorage.getItem("--theme-secondary") || "#ba895d";

const series = ref([44, 55, 13, 43, 22]);
// const chartOptions = ref({});

const chartOptions = computed(() => {
  return {
    chart: {
      width: 380,
      type: "pie"
    },
    labels: ["Team A", "Team B", "Team C", "Team D", "Team E"],
    responsive: [
      {
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: "bottom"
          }
        }
      }
    ]
  };
});

onMounted(() => {});
</script>
<template>
  <div>
    <apexchart :options="chartOptions" :series="series"></apexchart>
  </div>
</template>
