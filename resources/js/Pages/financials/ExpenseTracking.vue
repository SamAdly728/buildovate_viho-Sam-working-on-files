<template>
  <div class="container-fluid" style="background-color: #f5f7fb;">
    <div style="height: 110vh; overflow: hidden;" class="pb-5">
      <div class="row m-0 p-0">
        <div :class="loading ? 'col-xl-12' : 'col-xl-8'" class="d-flex flex-column" style="height: 107vh; overflow: hidden;">
          <div class="row" v-if="!fetchingTransactions">
            <div class="col-sm-6 col-xl-3 col-lg-6" v-if="selected_jobsite !== null">
              <div class="card o-hidden border-0">
                <div class="bg-primary b-r-4 card-body">
                  <div class="media static-top-widget">
                    <div class="media-body p-0">
                      <span class="m-0">Owner Price</span>
                      <h4 class="mb-0 counter">{{formatCurrency(100000)}}</h4>
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database icon-bg"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
              <div class="card o-hidden border-0">
                <div class="bg-primary b-r-4 card-body">
                  <div class="media static-top-widget">
                    <div class="media-body m-0 p-0">
                      <span class="m-0">Paid</span>
                      <h4 class="mb-0 counter">{{formatCurrency(30000)}}</h4>
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database icon-bg"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
              <div class="card o-hidden border-0">
                <div class="bg-primary b-r-4 card-body">
                  <div class="media static-top-widget">
                    <div class="media-body m-0 p-0">
                      <span class="m-0">Remainings</span>
                      <h4 class="mb-0 counter">{{formatCurrency(70000)}}</h4>
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database icon-bg"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6" v-if="selected_jobsite !== null">
              <div class="card o-hidden border-0">
                <div class="bg-primary b-r-4 card-body">
                  <div class="media static-top-widget">
                    <div class="media-body m-0 p-0">
                      <span class="m-0">Progress</span>
                      <h4 class="mb-0 counter">20%</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database icon-bg"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div :class="fetchingTransactions ? '' : 'flex-grow-1'">
            <div class="col-md-12 d-flex flex-column align-items-center">
              <div v-if="loading">
                <div style="width: 200px; height: 200px;">
                  <img src="../../../assets/sales/expense-tracking.png" alt="">
                </div>
                <h3 class="text-dark text-center f-w-600">Connecting PLAID...</h3>
                <p class="sub-content text-center text-success f-w-500"></p>
                <p class="sub-content text-center text-success f-w-500">Please wait...</p>
              </div>

              <div v-else-if="!accessToken">
                <div class="d-flex flex-column justify-content-center align-items-center">
                  <div style="width: 200px; height: 200px;">
                    <img src="../../../assets/sales/expense-tracking.png" alt="">
                  </div>
                  <h3 class="text-dark text-center f-w-600">Connect to PLAID</h3>
                  <p class="sub-content text-center text-success f-w-500">Get the most of buildovate innovation by tracking your banking expenses.</p>
                  <a class="btn btn-outline-primary" style="width: 300px;" @click="linkPlaidAccount">SETUP CONNECTION</a>
                </div>
              </div>

              <div v-else-if="tokenError">
                <div class="d-flex flex-column justify-content-center align-items-center">
                  <div style="width: 200px; height: 200px;">
                    <img src="../../../assets/sales/expense-tracking.png" alt="">
                  </div>
                  <h3 class="text-dark text-center f-w-600">{{ tokenError }}</h3>
                  <p class="sub-content text-center text-success f-w-500">{{ tokenErrorMessage }}. Please try to reconnect again.</p>
                  <a class="btn btn-outline-primary" style="width: 300px;" @click="linkPlaidAccount">RETRY CONNECTION</a>
                </div>
              </div>

              <div class="card m-0 p-0" v-else-if="fetchingTransactions" style="width: 100%;">
                  <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%; margin-top: 50px;">
                    <div style="height: 40px;">
                        <LoadingStyleMetric></LoadingStyleMetric>
                    </div>
                    <a class="f-w-600 mt-1 mb-5">Retreiving transactions ...</a>
                  </div>
              </div>

              <div class="card m-0 p-0 position-relative bg-white" v-else-if="filteredData.length != 0" style="width: 100%; height: auto; max-height: 93vh; overflow: hidden;">
                  <div class="card-header d-flex justify-content-between align-items-center" style="border-bottom: 2px gainsboro solid;">
                      <h4 class="card-title mb-0 text-dark">Jobsite Transactions</h4>
                      <div>
                        <a class="btn btn-outline-primary mr-2 px-3" title="Export"><i class="icon-export"></i></a>
                        <a class="btn btn-outline-primary mr-2 px-3" title="Import"><i class="icon-import"></i></a>
                        <a class="btn btn-outline-primary m-0 px-3" title="Reload"><i class="icon-filter"></i></a>
                      </div>
                  </div>
                  <div class="overflow-handler flex-grow-1 d-flex flex-column">
                    <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%; margin-top: 50px;" v-if="loadTable">
                      <div style="height: 40px;">
                          <LoadingStyleMetric></LoadingStyleMetric>
                      </div>
                      <a class="f-w-600 mt-1 mb-5">Retreiving transactions ...</a>
                    </div>
                      <div class="table-responsive flex-grow-1" v-else>
                        <table class="table" id="transaction-list">
                          <thead>
                              <tr>
                                  <template v-for="col in columnDefs">
                                      <th class='f-w-700' :key="col.field" :style="{ width: col.width }" v-if="!col.hide">{{ col.headerName }}</th>
                                  </template>
                              </tr>
                          </thead>
                          <tbody>
                              <tr v-for="jobsite_transaction in filteredData" :key="jobsite_transaction.jobsite_transaction_id">
                                  <template v-for="col in columnDefs">
                                      <td 
                                          :key="col.field" 
                                          :style="{ width: col.width }" 
                                          v-html="getCellContent(jobsite_transaction, col)"
                                          v-if="!col.hide">
                                      </td>
                                  </template>
                              </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="p-3 card-footer">
                      <nav class="d-flex justify-content-between">
                          <a class="mt-1">Showing <b>{{ startingEntry }}</b> to <b>{{ endingEntry }}</b> out of <b>{{ totalEntries }}</b> entries</a>
                          <ul class="pagination justify-content-end pagination-primary">
                              <li class="mr-3" :class="{ 'disabled': fetchingTransactions }">
                                  <select v-model="pageLimit" class="form-select border-success">
                                      <option value="10">10</option>
                                      <option value="25">25</option>
                                      <option value="50">50</option>
                                      <option value="100">100</option>
                                  </select>
                              </li>
                              <li class="page-item" :class="{ 'disabled': (currentPage <= 1) || fetchingTransactions }">
                                  <a class="page-link" href="javascript:void(0)" @click="changePage(currentPage - 1)">Previous</a>
                              </li>

                              <li class="page-item" v-for="page in pagesToShow" :key="page" :class="[{ 'active': page === currentPage }, { 'disabled': fetchingTransactions }]">
                                  <a class="page-link" href="javascript:void(0)" @click="changePage(page)">{{ page }}</a>
                              </li>

                              <li class="page-item" :class="{ 'disabled': (currentPage >= totalPages)|| fetchingTransactions}">
                                  <a class="page-link" href="javascript:void(0)" @click="changePage(currentPage + 1)">Next</a>
                              </li>
                          </ul>
                      </nav>
                  </div>
              </div>

              <div class="card container p-5 position-relative bg-white" v-else>
                <div class="col-md-12 d-flex flex-column align-items-center">
                    <div style="width: 200px; height: 180px;">
                      <img src="../../../assets/sales/empty-item-list.png" alt="">
                    </div>
                    <h3 class="text-dark text-center">No Transaction Attached!</h3>
                    <p class="sub-content text-center">You don't have attached transaction on this one yet.</p>
                </div>
              </div>

              </div>
          </div>

        </div>

        <div class="col-xl-4">
          <div class="card m-0 p-0" v-if="fetchingTransactions" style="width: 100%;">
            <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%; margin-top: 50px;">
              <div style="height: 40px;">
                <LoadingStyleMetric></LoadingStyleMetric>
              </div>
              <a class="f-w-600 mt-1 mb-5">Retreiving transactions ...</a>
            </div>
          </div>
          <div class="card" style="height: 107vh;" v-else>
            <div class="card-header d-flex justify-content-between align-items-center" style="border-bottom: 2px gainsboro solid;">
              <h4 class="card-title mb-0">PLAID Transactions</h4>
              <div>
                <a class="btn btn-outline-primary mr-2 px-3" title="reload"><i class="icon-reload"></i></a>
                <a class="btn btn-outline-primary m-0 px-3" title="reload"><i class="icon-filter"></i></a>
              </div>
            </div>
              <div class="card-body p-0 no-scrollbar-space">
                <template v-for="(transaction, index) in transactionsItem" :key="transaction.transaction_id + '_' + index"> 
                  <a class="card m-0 p-0 cursor-pointer transaction-card" :class="transaction.pending ? 'bg-warning' : ''" @click="handleTransactionClick(transaction)">
                      <div class="card-body m-0 p-0 d-flex flex-row align-items-center justify-content-between px-4 py-4">
                        <div>
                          <h6>{{ transaction.name }}</h6>
                          <p>{{ formatDate(transaction.date) }}</p>
                        </div>
                        <h6 class="card-amount" :class="(transaction.amount >= 0) ? 'amount-add' : 'amount-minus'" style="font-size: 20px;">{{ formatCurrency(transaction.amount) }}</h6>
                    </div>
                  </a>
                </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <PlaidTransactionModal :transactionData="selectedTransaction"/>
</template>
<script setup>
import { ref, onMounted, watch } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { new_transactions_added, selected_jobsite } from '../../globalState';
import axios from 'axios';
import PlaidTransactionModal from './PlaidTransactionModal.vue';
import LoadingStyleMetric from '../../components/LoadingStyleMetric.vue';

const { plaidToken } = defineProps({
  plaidToken: String, 
});
const page = usePage();
const linkToken = ref('');
const accessToken = ref(plaidToken);
const tokenError = ref(null);
const tokenErrorMessage = ref('Unknown issue occured while connecting to your plaid account.');

//TRANSACTIONS
const pageLimit = ref(10);
const currentPage = ref(1);
const totalPages = ref(0);
const startingEntry = ref(0);
const endingEntry = ref(0);
const totalEntries = ref(0);
const transactionError = ref('');
const transactionErrorMessage = ref('');
const transHas_more = ref(false);
const transModified = ref([]);
const transNext_cursor = ref('');
const transRemoved = ref([]);
const latestTransRequestID = ref('');
const transactionsItem = ref([]);
const selectedTransaction = ref({
  name: '',
  amount: 0
});

const rowData = ref([]);
const filteredData = ref([]);
const columnDefs = ref([
  { headerName: "Jobsite", width: '300px', hide: false},
  { headerName: "Added by" , width: 'auto', hide: false},
  { headerName: "Amount" , width: '200px', hide: false},
  { headerName: "Status" , width: '100px', hide: false},
  { headerName: "Type", width: '100px', hide: false},
]);

const loading = ref(false);
const fetchingTransactions = ref(false);
const loadTable = ref(false);
let linkHandler = null; // This will hold the Plaid instance

// Function to initialize Plaid with the token and configurations
const initializePlaid = (token) => {
  linkHandler = Plaid.create({
    token,
    onSuccess: (public_token, metadata) => {
      exchangePublicToken(public_token);
    },
    onExit: (err, metadata) => {
      console.log('Plaid onExit:', err, metadata);
    },
  });

  loading.value = false;
  linkHandler.open(); // This will open the Plaid Link immediately
};

// Fetch the link token from the server
const fetchLinkToken = async () => {
  try {
    loading.value = true;
    const response = await axios.post('/api/plaid/create_link_token', {
      headers: {
        'Authorization': 'Bearer ' + page.props.csrf_token,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
    const jsonData = response.data;
    linkToken.value = jsonData.link_token;

    if (linkToken.value) {
      initializePlaid(linkToken.value);
    }else{
      loading.value = false;
      console.error('Error fetching Plaid link token: ', jsonData);
    }
  } catch (error) {
    console.error('Error fetching Plaid link token: (error)', error);
  }
};

const saveAccessToken = async (access_token) => {
  try {
    loading.value = true;
    await axios.post('/api/plaid/save_access_token', {access_token: access_token}, {
      headers: {
        'Authorization': 'Bearer ' + page.props.csrf_token,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
  } catch (error) {
    console.error('Error fetching Plaid link token: (error)', error);
  }
};

const exchangePublicToken = async (public_token) => {
  try {
    loading.value = true;
    const response = await axios.post('/api/plaid/exchange_public_token', {public_token: public_token}, {
      headers: {
        'Authorization': 'Bearer ' + page.props.csrf_token,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
    const jsonData = response.data;
    if(jsonData){
      const error_code = jsonData.error_code;
      accessToken.value = jsonData.access_token;

      if(error_code){
        tokenError.value = error_code;
        tokenErrorMessage.value = jsonData.message;
        console.log(`(${error_code}) Create alert here saying: `, jsonData.message);
      }else if (accessToken.value) {
        tokenError.value = null;
        console.log('NOW WE CAN CONTINUE FINALLY FETCH DATA FROM PLAID USING', accessToken.value);
        saveAccessToken(accessToken.value);
      }else{
        tokenError.value = 'UNKNOWN_ERROR_UNIDENTIED_RESPONSE';
        tokenErrorMessage.value = 'Unknown issue occured while connecting to your plaid account.';
        console.error('Error fetching Plaid access token: ', jsonData);
      }
    }else{
        tokenError.value = 'UNKNOWN_ERROR_NO_JSON';
        tokenErrorMessage.value = 'Unknown issue occured while connecting to your plaid account.';
        console.error('Error fetching Plaid access token NO JSON');
    }

    loading.value = false;
  } catch (error) {
    console.error('Error fetching Plaid access token: (error)', error);
  }
}

const fetchTransactions = async () => {
  try {
    const response = await axios.post('/api/plaid/transaction_sync', 
      {
        access_token: accessToken.value
      }, {
      headers: {
        'Authorization': 'Bearer ' + page.props.csrf_token,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
    const jsonData = response.data;
    if(jsonData){
        transactionError.value = '';
        transactionErrorMessage.value = '';

        if(jsonData.has_more){
          transHas_more.value = jsonData.has_more;
        }
        if(jsonData.modified){
          transModified.value = jsonData.modified;
        }
        if(jsonData.next_cursor){
          transNext_cursor.value = jsonData.next_cursor;
        }
        if(jsonData.removed){
          transRemoved.value = jsonData.removed;
        }
        if(jsonData.request_id){
          latestTransRequestID.value = jsonData.request_id;
        }

        if(jsonData.added){
          transactionsItem.value = [];
          transactionsItem.value.push(...jsonData.added);

          transactionsItem.value = transactionsItem.value.filter(transaction => {
              return !rowData.value.some(row => row.plaid_transaction_id === transaction.transaction_id);
          });
        }
        fetchingTransactions.value = false;
    }else{
        fetchingTransactions.value = false;
        transactionError.value = 'UNKNOWN_TRANSACTION_ERROR_NO_JSON';
        transactionErrorMessage.value = 'Unknown issue occured while fetching transactions.';
        console.error('Error fetching Plaid transaction sync NO JSON');
    }
  } catch (error) {
    fetchingTransactions.value = false;
    console.error('Error fetching Plaid link token: (error)', error);
  }
};

const getJobsiteTransactions = async (pageNumber, limit = pageLimit.value, onChange = false) => {
  try {
    fetchingTransactions.value = !onChange;
    loadTable.value = onChange;

    const response = await axios.get('/api/getJobsiteTransactions', {
      params: { 
        page: pageNumber ,
        limit: limit
      },
      headers: {
        'Authorization': 'Bearer ' + page.props.csrf_token,
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
    const jsonResponse = response.data;
    new_transactions_added.value = false;

    if(jsonResponse){
      const status = jsonResponse.status;

      if(status === 'success'){
        const transactions = jsonResponse.data.data;

        rowData.value = transactions;
        startingEntry.value = jsonResponse.data.from;
        endingEntry.value = jsonResponse.data.to;
        totalEntries.value = jsonResponse.data.total;
        totalPages.value = jsonResponse.data.last_page || 0;

        if(selected_jobsite.value !== null){
          filteredData.value = rowData.value.filter(item => item.jobsite_id === selected_jobsite.value.jobsite_id);
        }else{
          filteredData.value = rowData.value;
        }

        if(accessToken.value && !onChange){
          console.log('fetchTransactions(); called');
          fetchTransactions();
        }else{
          console.log('fetchTransactions(); not called');
        }
        loadTable.value = false;
      }else{
        fetchingTransactions.value = false;
        loadTable.value = false;
        console.error('Error fetching jobsite transactions: (error failure)', jsonResponse);
      }
    }else{
      fetchingTransactions.value = false;
      loadTable.value = false;
      console.error('Error fetching jobsite transactions: (error)', response);
    }
  } catch (error) {
    fetchingTransactions.value = false;
    console.error('Error fetching Plaid link token: (error)', error);
  }
};

const linkPlaidAccount = () => {
  fetchLinkToken();
};

function changePage(pageNumber) {
  if (pageNumber >= 1 && pageNumber <= totalPages.value) {
    currentPage.value = pageNumber;
  }
  getJobsiteTransactions(currentPage.value, pageLimit.value, true);
}

function handleTransactionClick(transaction){
    if(transaction.pending){
      Swal.fire({
        icon: 'info',
        title: 'Pending Transaction Warning!',
        text: `Can't attached or modify pending transactions. This is only for viewing`,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'View Transaction'
      }).then((result) => {
        if (result.isConfirmed) {
          selectedTransaction.value = transaction;
          const modalElem = document.getElementById('plaidAttachedModal');
          var modal = new bootstrap.Modal(modalElem);
            modal.show();
          }
      });
    }else{
      selectedTransaction.value = transaction;
      const modalElem = document.getElementById('plaidAttachedModal');
      var modal = new bootstrap.Modal(modalElem);
      modal.show();
    }
}

function getCellContent(proposal_transaction, column) {
        if (column.headerName === 'Jobsite'){
          return getDetails(proposal_transaction);
        }
        
        if (column.headerName === 'Added by'){
          return getRecordedBy(proposal_transaction);
        }
        
        if (column.headerName === 'Amount'){
          return getAmount(proposal_transaction);
        }
        
        if (column.headerName === 'Status'){
          return getStatus(proposal_transaction.status);
        }
        
        if (column.headerName === 'Type'){
          return getAttachedType(proposal_transaction.attached_type);
        }
        
        return `<a>-</a>`;
}

function getDetails(transaction){
  const name = transaction.job_site.jobsite_name;
  const street = transaction.job_site.street;
  const city = transaction.job_site.city;
  const state = transaction.job_site.state;
  const zipcode = transaction.job_site.zipcode;
  const address = `${street} ${city} ${state} ${zipcode}`;

  return `<div>
            <a class='f-w-600 text-sucess truncate'>${name}</a><br><small class='truncate-text'>${address}</small>
        </div>`;
}

function getRecordedBy(transaction){
  const name = transaction.recorded_by.display_name;
  const date = transaction.date_attached;

  return `<div class='truncate-container'>
            <a class='f-w-600 text-sucess'>${name}</a><br><small class='truncate-text'>Date: ${formatDate(date)}</small>
        </div>`;
}

function getAmount(transaction){
  const amount = transaction.amount;
  const date = transaction.date_paid;
  let displayedAmount = getAmountCurrency(amount);

  return `<div class='truncate-container'>
            <a class='f-w-600'>${displayedAmount}</a><br><small class='truncate-text'>Date: ${formatDate(date)}</small>
        </div>`;
}

function getAmountCurrency(amountData){
  if(amountData){
    const amount = parseFloat(amountData);
    const color = (amount < 0) ? 'text-danger' : 'text-success';

    return `<a class='f-w-600 ${color}'>${formatCurrency(amount)}</a>`
  }else{
    return `<a class='f-w-600'>$0.0</a>`
  }
}

function getStatus(type){
  let color = 'success';
  let label = 'Paid';
  if(type === 'void') {
    color = 'danger';
    label = 'Void';
  }
  return `<span class="badge rounded-pill badge-${color}"> ${label} </span>`;
}

function getAttachedType(type){
  let color = 'success';
  if(type === 'Split') color = 'warning';
  return `<span class="badge rounded-pill badge-${color}"> ${type} </span>`;
}

function formatDate(date){
  const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  
  const d = new Date(date);
  const monthName = months[d.getMonth()]; // getMonth() returns month index (0-11)
  const day = d.getDate();
  const year = d.getFullYear();
  
  return `${monthName} ${day}, ${year}`;
}


function formatCurrency(amount) {
  if(amount){
    const formatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
    });
    return formatter.format(parseFloat(amount));
  }else{
    return '$0.0';
  }
}

onMounted(() => {
  getJobsiteTransactions(currentPage.value, pageLimit.value);
});

watch(new_transactions_added, (value) => {
  if(value){
    getJobsiteTransactions(currentPage.value, pageLimit.value);
  }
})

watch(pageLimit, (newValue) => {
  currentPage.value = 1;
  getJobsiteTransactions(currentPage.value, newValue, true);
});

watch(selected_jobsite, (value) => {
  if(value !== null){
    filteredData.value = rowData.value.filter(item => item.jobsite_id === value.jobsite_id);
  }else{
    filteredData.value = rowData.value;
  }
});

</script>
<style scoped>
.no-scrollbar-space {
  overflow-y: hidden; 
  scrollbar-width: thin;
  scrollbar-color: #24695c transparent;
}

.no-scrollbar-space:hover {
  overflow-y: auto; 
}

.no-scrollbar-space::-webkit-scrollbar {
  width: 5px; 
}

.no-scrollbar-space::-webkit-scrollbar-thumb {
  background-color: #24695c93; 
  border-radius: 6px; 
  background-clip: content-box;
}
.transaction-card:hover{
  background-color: #24695c;
  color: white !important;
}

.transaction-card:hover .amount-add, .transaction-card:hover .amount-minus{
  color: white !important;
}

.amount-add{
  color: #24695c;
}

.amount-minus{
  color: #D22D3D;
}

#transaction-list thead {
    background-color: #e6edef;
}

#transaction-list thead th {
    position: sticky;
    top: 0;
    background-color: #e6edef;
    z-index: 5;
    box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
}

#transaction-list tbody tr:hover {
    background-color: #e6edef94; /* light gray background on hover */
}

</style>