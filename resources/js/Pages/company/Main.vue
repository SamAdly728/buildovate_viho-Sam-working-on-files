<template>
  <div class="row m-0 p-0">
    <div class="col-md-12 row m-0 p-0" style="height: 300px;">
      <div class="col-lg-6 m-0 p-0 p-3" style="height: 100%;">
        <div class="bg-white b-radius-10 shadow-sm" style="height: 100%;">
          <div class="f-20 text-muted px-3 py-2 d-flex justify-content-between">
            <span class="f-w-600">Current Month Sales: <span class="f-w-700 text-dark">$52,740.65</span></span>
            <i class="icon-info-alt text-primary-v2 bigger" style="cursor: pointer;"></i>
          </div>  
        </div>
      </div>
      <div class="col-lg-6 m-0 p-0 p-3" style="height: 100%;">
        <div class="bg-white b-radius-10 shadow-sm d-flex flex-column" style="height: 100%;">
          <div class="f-20 f-w-600 text-muted px-3 py-2 d-flex justify-content-between">
            Financials Goals
            <i class="icon-info-alt text-primary-v2 bigger" style="cursor: pointer;"></i>
          </div>  
          <div class="flex-grow-1 d-flex align-items-center justify-content-center gap-5">
            <CirclePercentageStatus :percentage="40"/>
            <div style="width: 2px; height: 100px;" class="bg-primary-v2"></div>
            <div class="m-0 p-0 d-flex flex-column">
                <div class="d-flex flex-column bg-hover px-3 py-2 b-radius-10" style="cursor: pointer;">
                  <span class="f-12 text-muted f-w-600">Achieved:</span>
                  <span class="f-18 text-dark f-w-600">$52,000.00</span>
                </div>
                <div class="d-flex flex-column bg-hover px-3 py-2 b-radius-10" style="cursor: pointer;">
                  <span class="f-12 text-muted f-w-600">Planned:</span>
                  <span class="f-18 text-dark f-w-600">$8,770.00</span>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-12 m-0 p-0 p-3" style="height: 400px">
      <div class="bg-white b-radius-10 shadow-sm d-flex flex-column" style="height: 100%;">
        <div class="f-20  text-muted px-3 py-2 d-flex justify-content-between">
          <span class="f-w-600">Monthly Project Budget</span>
        </div>
        <div class="flex-grow-1 px-3 pb-2">
          <apexchart
            type="bar"
            height="310"
            :options="chartOptions"
            :series="series"
            ></apexchart>
        </div>
      </div>
    </div>
    
    <div class="col-lg-12 m-0 p-0 p-3" style="height: 400px">
      <div class="bg-white b-radius-10 shadow-sm" style="height: 100%;">

        <div class="f-20 f-w-600 text-muted px-3 py-2">Monthly Project Profits</div>
        <div class="flex-grow-1 px-3 pb-2">
          <apexchart
            type="line"
            height="310"
            :options="chartOptions"
            :series="series"
            ></apexchart>
        </div>

      </div>
    </div>

  </div>
</template>
<script>
import CirclePercentageStatus from '../../components/plaid/CirclePercentageStatus.vue';

export default {
  components: { CirclePercentageStatus },
  data() {
    const series = [
      { name: 'Total Budget', data: [1000, 700, 1000, 100, 900, 100, 900, 100, 100, 500, 100, 100] },
      { name: 'Budget Used', data: [700, 900, 900, 200, 500, 200, 200, 500, 200, 900, 200, 200] },
      { name: 'Total Used', data: [900, 1000, 300, 900, 300, 300, 500, 900, 300, 300, 300, 500] },
    ];
    const chartOptions = {
      plotOptions: {
        bar: {
          horizontal: false,
          borderRadius: 6,
          columnWidth: '80%',
        },
      },
      colors: ['#1E5BB2', '#739bd4', '#BFCFE7'],
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      },
    };
    return { series, chartOptions };
  }
}

</script>
