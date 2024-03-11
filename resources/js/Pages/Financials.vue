<template>
  <div class="d-flex flex-column m-0 p-2 gap-1" style="height: calc(100vh - 98px);">
    <PlaidBubble />
    <div class="row m-0 p-0">
      <div class="col-md-8 d-flex flex-column m-0 p-0">
        <div class="d-flex m-0 p-2 gap-3" style="height: 160px;">
          <div class="bg-primary-v2 m-0 p-2 shadow b-light-v2 b-radius-5 flex-grow-1 bigger d-flex flex-column py-3 px-4 justify-content-center" style="overflow: hidden;">
            <i class="icon-pulse f-100 text-white f-w-900" style="position: absolute; bottom: -35px; opacity: 0.3; left: -10px;"></i>
            <h5 class="f-w-600 f-16 text-white">Sales Total</h5>
            <h5 class="f-w-700 f-30 text-white">$93,600.00</h5>
            <div class="d-flex mt-1">
              <a class="flex-grow-1"></a>
              <a class="btn btn-white px-2 py-1 text-primary-v2 bigger"><i class="icon-plus"></i> Change Order</a>
            </div>
          </div>
          
          <div class="bg-secondary-v2 m-0 p-2 shadow b-light-v2 b-radius-5 flex-grow-1 bigger d-flex flex-column py-3 px-4 justify-content-center" style="overflow: hidden;">
            <i class="icon-server f-100 text-white f-w-900" style="position: absolute; bottom: -35px; opacity: 0.3; left: -20px;"></i>
            <h5 class="f-w-600 f-16 text-white">Cash Received</h5>
            <h5 class="f-w-700 f-30 text-white">$50,000.00</h5>
            <div class="d-flex mt-1">
              <a class="flex-grow-1"></a>
              <a class="btn btn-white px-2 py-1 text-secondary-v2 bigger"><i class="icon-plus"></i> Record Payment</a>
            </div>
          </div>
          
          <div class="bg-light-success-v2 m-0 p-2 shadow b-light-v2 b-radius-5 flex-grow-1 bigger d-flex flex-column py-3 px-4 justify-content-center" style="overflow: hidden;">
            <i class="icon-harddrives f-100 text-white f-w-900" style="position: absolute; bottom: -35px; opacity: 0.3; left: -20px;"></i>
            <h5 class="f-w-600 f-16 text-white">Pending Receivables</h5>
            <h5 class="f-w-700 f-30 text-white">$43,000.00</h5>
            <div class="d-flex mt-1">
              <a class="flex-grow-1"></a>
              <a class="btn btn-white px-2 py-1 text-success-v2 bigger"><i class="icon-plus"></i> Send Invoice</a>
            </div>
          </div>
          
          <div class="bg-success-v2 m-0 p-2 shadow b-light-v2 b-radius-5 flex-grow-1 bigger d-flex flex-column py-3 px-4 justify-content-center" style="overflow: hidden;">
            <i class="icon-wallet f-100 text-white f-w-900" style="position: absolute; bottom: -30px; opacity: 0.3; left: -20px;"></i>
            <h5 class="f-w-600 f-16 text-white">Commission Paid</h5>
            <h5 class="f-w-700 f-30 text-white">$7,500.00</h5>
            <div class="d-flex mt-1">
              <a class="flex-grow-1"></a>
              <a class="btn btn-white px-2 py-1 text-success-v2 bigger"><i class="icon-plus"></i> Request Money</a>
            </div>
          </div>

        </div>
        <div class="flex-grow-1 row m-0 p-2">
          <div class="bg-white m-0 p-2 shadow-sm b-light-v2 b-radius-5 px-3 py-2 d-flex flex-column gap-1">
            <div class="d-flex justify-content-between pb-2">
              <a class="f-w-600 text-muted">Stage Payment Status</a>
              <div class="d-flex f-12 gap-3 f-w-600">
                <a><i class="icofont icofont-brand-mts text-success-v2"></i> Paid</a>
                <a><i class="icofont icofont-brand-mts text-primary-v2"></i> Partial</a>
                <a><i class="icofont icofont-brand-mts text-muted"></i> Unpaid</a>
              </div>
              <a class="f-w-600 text-primary-v2" style="cursor: pointer;">Request Changes</a>
            </div>
            <div class="flex-grow-1 d-flex slim-scroll-gray gap-4 align-items-center px-3" style="overflow-y: hidden; overflow-x: auto;">
              <template v-for="stagePayment in stagePayments">
                  <StagePaymentStatus :percentage="stagePayment" />
              </template>
            </div>
            <div class="d-flex flex-column">
              <div class="d-flex justify-content-between">
                <span class="f-12 text-muted">Date Started: Jan 11, 1999</span>
                <span class="f-12 text-dark f-w-600">Project Age</span>
                <span class="f-12 text-muted">Date Started: Dec 20, 2022</span>
              </div>
              <div class="bg-muted px-2">
                <a class="f-12 text-muted align-right">0 Days Remaining</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 m-0 p-2">
        <div class="bg-white m-0 p-2 shadow-sm b-light-v2 b-radius-5 px-4 py-3 d-flex flex-column" style="height: 100%;">
          <h5 class="f-20 f-w-600 text-muted">INCOME STATEMENT</h5>
          <div class="d-flex justify-content-between"><h5 class="f-18 f-w-700 text-dark mt-3">Total Sales</h5><h5 class="f-18 f-w-500 text-dark mt-3">$93,600.00</h5></div>
          <div class="d-flex justify-content-between"><h5 class="f-18 f-w-700 text-dark">Project Budget</h5><h5 class="f-18 f-w-500 text-dark">$52,000.00</h5></div>
          <hr>
          <div class="d-flex justify-content-between"><h5 class="f-18 f-w-700 text-dark">Gross Profit</h5><h5 class="f-18 f-w-500 text-dark">$41,600.00</h5></div>
          <div class="d-flex justify-content-between"><h5 class="f-18 f-w-700 text-dark">Overhead</h5><h5 class="f-18 f-w-500 text-dark">$19,460.00</h5></div>
          <div class="d-flex justify-content-between" style="margin-left: 25px;"><h5 class="f-14 f-w-700 text-muted">Estimated Expense</h5><h5 class="f-14 f-w-500 text-dark">$100.00</h5></div>
          <div class="d-flex justify-content-between" style="margin-left: 25px;"><h5 class="f-14 f-w-700 text-muted">Lead Cost</h5><h5 class="f-14 f-w-500 text-dark">$19,360.00</h5></div>
          <div class="d-flex justify-content-between"><h5 class="f-18 f-w-700 text-dark">Other Expenses</h5><h5 class="f-18 f-w-500 text-dark">$50.75</h5></div>
          <hr>
          <div class="d-flex justify-content-between"><h5 class="f-18 f-w-700 text-dark mt-3">Commission</h5><h5 class="f-18 f-w-500 text-dark mt-3">$16,169.00</h5></div>
        </div>
      </div>
    </div>
    <div class="flex-grow-1 row m-0 p-0" style="min-height: 400px;">
      <div class="col-md-4 m-0 p-2">
        <div class="bg-white m-0 p-2 shadow-sm b-light-v2 b-radius-5 px-4 py-3 d-flex flex-grow-1 flex-column" style="height: 100%;">
          <h5 class="f-20 f-w-600">Project Budget</h5>
          <div class="row m-0 p-0 flex-grow-1">
            <div class="col-lg-7 d-flex align-items-center">
            <apexchart
                type="bar"
                height="250"
                ref="bar"
                :options="chartOptions"
                :series="series"
              ></apexchart>
            </div>
              <div class="col-lg-5 m-0 p-0 d-flex flex-column">
                <div class="d-flex flex-column bg-hover px-3 py-2 b-radius-10" style="cursor: pointer;">
                  <span class="f-12 text-muted f-w-600">Total Budget:</span>
                  <span class="f-18 text-dark f-w-600">$52,000.00</span>
                </div>
                <div class="d-flex flex-column px-3 py-2 b-radius-10 bg-primary-overlap" style="cursor: pointer;">
                  <span class="f-12 f-w-600">Budget Used:</span>
                  <span class="f-18 f-w-600">$43,230.00</span>
                </div>
                <div class="d-flex flex-column bg-hover px-3 py-2 b-radius-10" style="cursor: pointer;">
                  <span class="f-12 text-muted f-w-600">Remaining:</span>
                  <span class="f-18 text-dark f-w-600">$8,770.00</span>
                </div>
                <div class="d-flex align-items-center justify-content-center flex-column py-3">
                  <span class="f-40 f-w-800 text-danger-v2">
                  <i class="icon-stats-down"></i> 8.1%</span>
                  <span class="f-18 f-w-700 text-muted">Over Target</span>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 m-0 p-2">
        <div class="bg-white m-0 p-2 shadow-sm b-radius-5 px-4 py-3 b-l-primary-10-v2 d-flex flex-grow-1 flex-column" style="height: 100%;">
          <h5 class="f-20 f-w-600">Cost Breakdown</h5>
          <div class="row m-0 p-0 flex-grow-1">
            <div class="col-lg-7 d-flex align-items-center">
            <apexchart
                type="pie"
                height="500"
                :options="pieChart"
                :series="pieSeries"
              ></apexchart>
            </div>
              <div class="col-lg-5 m-0 p-0 d-flex flex-column gap-1">
                <div class="b-l-primary-5-v2 d-flex flex-column bg-hover-primary px-3 py-2 b-radius-10" :class="activeBreakdown === 'labor' ? ' bg-primary-overlap' : ''" style="cursor: pointer;" @click="handleChangeBreakdowbn('labor')">
                  <span class="f-12 f-w-600" :class="activeBreakdown === 'labor' ? 'text-white' : 'text-muted'">Labor & Installers</span>
                  <span class="f-18 f-w-600" :class="activeBreakdown === 'labor' ? 'text-white' : 'text-dark'">$52,000.00</span>
                </div>
                <div class="b-l-secondary-5-v2 d-flex flex-column px-3 py-2 bg-hover-secondary b-radius-10" :class="activeBreakdown === 'material' ? ' bg-secondary-overlap' : ''" style="cursor: pointer;" @click="handleChangeBreakdowbn('material')">
                  <span class="f-12 f-w-600" :class="activeBreakdown === 'material' ? 'text-white' : 'text-muted'">Materials & Supplies:</span>
                  <span class="f-18 f-w-600" :class="activeBreakdown === 'material' ? 'text-white' : 'text-dark'">$43,230.00</span>
                </div>
                <div class="b-l-success-5-v2 d-flex flex-column bg-hover-success px-3 py-2 b-radius-10" :class="activeBreakdown === 'equipment' ? ' bg-success-overlap' : ''" style="cursor: pointer;" @click="handleChangeBreakdowbn('equipment')">
                  <span class="f-12 f-w-600" :class="activeBreakdown === 'equipment' ? 'text-white' : 'text-muted'">Equipment Rentals:</span>
                  <span class="f-18 f-w-600" :class="activeBreakdown === 'equipment' ? 'text-white' : 'text-dark'">$8,770.00</span>
                </div>
                <div class="b-l-danger-5-v2 d-flex flex-column bg-hover-danger px-3 py-2 b-radius-10" :class="activeBreakdown === 'fees' ? ' bg-danger-overlap' : ''" style="cursor: pointer;" @click="handleChangeBreakdowbn('fees')">
                  <span class="f-12 f-w-600" :class="activeBreakdown === 'fees' ? 'text-white' : 'text-muted'">Plans, Permits, Fees:</span>
                  <span class="f-18 f-w-600" :class="activeBreakdown === 'fees' ? 'text-white' : 'text-dark'">$8,770.00</span>
                </div>
                <div class="b-l-warning-5-v2 d-flex flex-column bg-hover-warning px-3 py-2 b-radius-10" :class="activeBreakdown === 'commisions' ? ' bg-warning-overlap' : ''" style="cursor: pointer;" @click="handleChangeBreakdowbn('commisions')">
                  <span class="f-12 f-w-600" :class="activeBreakdown === 'commisions' ? 'text-white' : 'text-muted'">Commissions:</span>
                  <span class="f-18 f-w-600" :class="activeBreakdown === 'commisions' ? 'text-white' : 'text-dark'">$8,770.00</span>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 m-0 p-2">
        <div class="bg-white m-0 p-2 shadow-sm b-radius-5 d-flex flex-column" :class="getLeftBorder(activeBreakdown)" style="height: 100%;">
          <div class="d-flex justify-content-between align-items-center py-2" style="width: 100% !important;">
            <h5 class="f-20 f-w-600 m-0 p-0">Expense Payment Details</h5>
            <a class="btn btn-primary-v2 px-2 py-1 bigger"><span class="f-12"><i class="icon-plus"></i> Add Expense</span></a>
          </div>
          <div class="flex-grow-1 slim-scroll-gray" style="overflow: hidden;">
            <div class="d-flex f-w-600 py-2 b-b-primary">
              <a class="px-1 text-muted" style="width: 100px;">Date</a>
              <a class="px-1 text-muted" style="width: 150px;">Description</a>
              <a class="px-1 text-muted" style="width: 100px;">Amount</a>
              <div class="flex-grow-1 px-1 text-muted d-flex justify-content-between">Status
                <div class="d-flex f-12 gap-1 f-w-600">
                  <a><i class="icofont icofont-brand-mts text-success-v2"></i> Paid</a>
                  <a><i class="icofont icofont-brand-mts text-muted"></i> Outstanding</a>
                </div>
              </div>
            </div>
            <div style="max-height: 300px; overflow: auto;" class="d-flex flex-column slim-scroll-gray">
            <template v-for="expense in expenses">
              <div class="d-flex f-w-500 py-2 f-12 align-items-center bg-hover" style="cursor: pointer;">
                <a class="px-1" style="width: 100px;">{{ expense.date }}</a>
                <a class="px-1" style="width: 150px;">-</a>
                <a class="px-1" style="width: 100px;">{{ expense.amount }}</a>
                <a class="flex-grow-1 px-1 d-flex flex-column">
                  <div class="f-12 bg-muted px-2">0%</div>
                  <div class="f-12 px-2 d-flex justify-content-between">
                    <span>$0.00</span>
                    <span>{{ expense.amount }}</span>
                  </div>
                </a>
              </div>
            </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { usePage } from '@inertiajs/vue3';
import { useTransactionModal } from '../stores/transaction-modal';
import { useSideBar } from '../stores/sidebar';
import RichTable from '../components/RichTable.vue';
import PlaidBubble from '../components/plaid/PlaidBubble.vue';
import StagePaymentStatus from '../components/plaid/StagePaymentStatus.vue';

export default {
  components: {
    RichTable, PlaidBubble, StagePaymentStatus
  },
  props: {
    accessToken: {
      typeof: String,
      default: ''
    }
  },
  setup() {
    const page = usePage();
    const storeTransaction = useTransactionModal();
    const storeSideBar = useSideBar();

    return { page, storeTransaction, storeSideBar }
  },
  data(){
    const activeBreakdown = 'labor';
    const asset_link = window.asset_link;
    const loading = false;
    const linkToken = '';
    const refAccessToken = '';
    const tokenError = '';
    const tokenErrorMessage = '';
    const rowData = [];
    const headers = [
      { name: "Description", min: '250px'},
      { name: "Amount", min: '200px', max: '200px'},
      { name: "select_item", min: '110px', max: '110px'},
    ];
    const stagePayments = [100, 100, 100, 40, 10, 0];
    const series = [
            {
              name: 'Total Budget',
              data: [52000],
            },
            {
              name: 'Budget Used',
              data: [43230],
            },
            {
              name: 'Total Used',
              data: [8770],
            },
          ];
    const chartOptions ={
            plotOptions: {
                bar: {
                  horizontal: false,
                  borderRadius: 6,
                  columnWidth: '80%',
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
                categories: ['Project A'],
            },
          };
    const pieSeries = [44, 55, 13, 43, 22];
    const pieChart = {
      labels: ["Labor & Installers", "Materials & Supplies", "Equipment Rentals", "Plans, Permits, Fees", "Commissions"],
      colors: ['#1E5BB2', '#739bd4', '#0b793a', '#FF9800', '#B80000'],
      legend: {
        position: 'bottom',
        horizontalAlign: 'center',
      },
      dataLabels: {
        enabled: true, 
      }
    };
    const expenses = [
      { date: 'Jan 01, 2024', amount: '$1,0000.00' },
      { date: 'Jan 02, 2024', amount: '$2,0000.00' },
      { date: 'Jan 03, 2024', amount: '$3,0000.00' },
      { date: 'Jan 04, 2024', amount: '$4,0000.00' },
      { date: 'Jan 05, 2024', amount: '$5,0000.00' },
      { date: 'Jan 06, 2024', amount: '$6,0000.00' },
      { date: 'Jan 07, 2024', amount: '$7,0000.00' },
      { date: 'Jan 08, 2024', amount: '$8,0000.00' },
      { date: 'Jan 09, 2024', amount: '$9,0000.00' },
      { date: 'Jan 10, 2024', amount: '$10,0000.00' },
      { date: 'Jan 06, 2024', amount: '$6,0000.00' },
      { date: 'Jan 07, 2024', amount: '$7,0000.00' },
      { date: 'Jan 08, 2024', amount: '$8,0000.00' },
      { date: 'Jan 09, 2024', amount: '$9,0000.00' },
      { date: 'Jan 10, 2024', amount: '$10,0000.00' },
      { date: 'Jan 11, 2024', amount: '$11,0000.00' },
    ]

    return{
      refAccessToken,
      asset_link,
      loading,
      linkToken,
      tokenError,
      tokenErrorMessage,
      rowData,
      headers,
      stagePayments,
      series,
      chartOptions,
      pieChart,
      pieSeries,
      activeBreakdown,
      expenses
    }
  },
  methods: {
    getLeftBorder(type){
      if(type === 'labor'){
        return 'b-l-primary-10-v2';
      }else if(type === 'material'){
        return 'b-l-secondary-10-v2';
      }else if(type === 'equipment'){
        return 'b-l-success-10-v2';
      }else if(type === 'fees'){
        return 'b-l-danger-10-v2';
      }else if(type === 'commisions'){
        return 'b-l-warning-10-v2';
      }
      
      return 'b-l-primary-10-v2';
    },
    handleChangeBreakdowbn(type){
      this.activeBreakdown = type;
    },
    handleSelectedTransaction(data){
      this.storeTransaction.toggleModal();
    },
    formatCurrency(amount) {
      if(amount){
        const formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD',
        });
        return formatter.format(parseFloat(amount).toFixed(2));
      }else{
        return '$0.0';
      }
    }
    
  },
  mounted(){
    if(this.accessToken){
      this.refAccessToken = this.accessToken;
      // this.fetchTransactions(this.refAccessToken);
    }
  }


}

</script>
