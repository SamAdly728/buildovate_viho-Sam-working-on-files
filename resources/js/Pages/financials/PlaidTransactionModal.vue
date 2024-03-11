<template>
    <div class="modal fade" id="plaidAttachedModal" tabindex="-1" role="dialog" aria-labelledby="plaidAttachedModal" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0">
                    <div class="card p-0 m-0">
                        <div class="card-header border">
                            <h5>PLAID Transaction</h5>
                            <span >You can attached the bank transaction to your buildovate account to have better views on statistics.</span>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div id="scrollable-div" class="card-body p-4 position-relative" style="background-color: #f5f7fb; overflow-y: auto; max-height: 65vh;">
                            <div class="card b-r-5" style="overflow: hidden;">
                                <div class="card-header d-flex justify-content-between align-items-center pb-0 bg-primary">
                                    <h5>{{ transactionData.name }}</h5>
                                    <h5>{{ formatCurrency(transactionData.amount)}}</h5>
                                </div>
                                <div class="card-body px-4 pt-3 bg-primary">
                                    <div class="mt-2 bg-white" style="height: 1px;"></div>
                                    <p class="mb-0 mt-4"><b>Merchant Name: </b>{{ transactionData.merchant_name }}</p>
                                    <p class="mb-0"><b>Date:</b>  {{ formatDate(transactionData.date) }}</p>
                                    <p class="mb-0"><b>Category:</b> {{ (transactionData.category) }}</p>
                                </div>
                            </div>

                            <div class="card b-r-5" style="overflow: hidden;">
                                <div class="card-header border d-flex justify-content-between">
                                    <span >Choose the desired jobsite and specify the amount where you wish to link this transaction.</span>
                                </div>
                                <div class="card-body">
                                    <!-- Iterate over each attachment in attachLists -->
                                    <template v-for="(attach, index) in attachLists" :key="index">
                                        <div class="px-2 d-flex align-items-center" :class="index != attachLists.length -1 ? 'mb-3' : ''">
                                            <a class="badge rounded-pill badge-danger mr-2 cursor-pointer" data-bs-original-title="" title="Remove Split"  @click="handleRemoveSplit(index)" v-if="(attachLists.length != 1)">
                                                <i class="icon-close"></i>
                                            </a>
                                            <select v-model="attach.jobsite_id" class="form-control border-success mr-2" name="status">
                                                <option value="0">-- SELECT JOBSITE HERE --</option>
                                                <template v-for="jobsite in jobsite_list" :key="jobsite.jobsite_id">
                                                    <option :value="jobsite.jobsite_id">{{ jobsite.jobsite_name }}</option>
                                                </template>
                                            </select>
                                            <div class="input-group border-success mr-2 b-r-3" style="width: 250px; overflow: hidden;">
                                                <span class="input-group-text group-text-style"><i class="icon-money"></i></span>
                                                <input v-model="attach.amount" class="form-control border-success text-right" type="text" />
                                            </div>
                                            <a class="btn btn-outline-primary m-0 px-3" title="Full Amount" @click="handleAddFullClicked(transactionData, (attachLists.length == 1 && attach.amount != transactionData.amount), index)">{{ (attachLists.length == 1 && attach.amount != transactionData.amount) ? 'Full' : 'Split'}}</a>
                                        </div>
                                    </template>
                                </div>
                                <div class="card-header border d-flex justify-content-between">
                                    <span class="text-danger" style="max-width: 70%;" v-if="calculateTotalAmount() != transactionData.amount">Total attached amount should be equal to the transaction amount.</span>
                                    <span class="text-danger" style="max-width: 70%;" v-else-if="!hasEmptyJobsite()">Select jobsite you want to attached the amount.</span>
                                    <div></div>
                                    <div class="mr-3 f-w-600">
                                        Total Amount: <span class="f-w-700 text-success">{{ formatCurrency(calculateTotalAmount()) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute top-0 bottom-0 right-0 left-0" style="background-color: #e0e0e0ce;" v-if="processing">
                                <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%;">
                                    <div style="height: 40px;">
                                        <LoadingStyleMetric></LoadingStyleMetric>
                                    </div>
                                    <a class="f-w-600 mt-1 mb-5">Saving transaction to Jobsite...</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between" v-if="!processing">
                            <button class="btn btn-outline-primary">Incorrect Info?</button>
                            <div>
                                <button class="btn btn-light mr-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                <button class="btn btn-primary" v-if="calculateTotalAmount() == transactionData.amount && hasEmptyJobsite()" @click="hanldeSubmit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { jobsite_list, new_transactions_added } from '../../globalState';
import axios from 'axios';
import Swal from 'sweetalert2';
import { usePage } from "@inertiajs/vue3";
import LoadingStyleMetric from '../../components/LoadingStyleMetric.vue';

const page = usePage();
const processing = ref(false);
const { transactionData } = defineProps({
    transactionData: {
        type: Object,
        required: true
    },
});

const attachLists = ref([
    {
        date_paid: '',
        transaction_description: '',
        transaction_id: '',
        jobsite_id: 0,
        amount: 0
    }
]);

function resetModalData() {
  attachLists.value = [{
        date_paid: '',
        transaction_description: '',
        transaction_id: '',
        jobsite_id: 0,
        amount: 0
  }];
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

function hasEmptyJobsite(){
    let hasJobsite = true;
    for(let jobsite of attachLists.value){
        if(hasJobsite){
            if(jobsite.jobsite_id == 0){
                hasJobsite = false;
            }
        }
    }

    return hasJobsite;
}

function calculateTotalAmount(){
    let total = 0.0;

    for(let jobsite of attachLists.value){
        total += parseFloat(jobsite.amount);
    }

    return parseFloat(total);
}

function handleRemoveSplit(index){
    const currentAmount = attachLists.value[index].amount;
    let addIndex = index - 1;

    if(index !== 0){
        addIndex = index - 1;
    }else{
        addIndex = index;
    }
    attachLists.value.pop(index);

    const prevAmount =  attachLists.value[addIndex].amount;
    attachLists.value[addIndex].amount = prevAmount + currentAmount;
}

function handleAddFullClicked(transaction, split, index){
    if(!split){
        const currentAmount = attachLists.value[index].amount;

        attachLists.value[index].amount = currentAmount/2;
        attachLists.value.push({
            transaction_id: transaction.transaction_id,
            jobsite_id: 0,
            amount: currentAmount/2,
            date_paid: transaction.date,
            transaction_description: transaction.name,
        })
    }else{
        attachLists.value[0].date_paid = transaction.date;
        attachLists.value[0].transaction_description = transaction.name;
        attachLists.value[0].transaction_id = transaction.transaction_id;
        attachLists.value[0].amount = transaction.amount;
    }
}

async function hanldeSubmit(){
    try {
        const element = document.querySelector('#scrollable-div');
        element.scrollTop = 0;
        element.style.overflowY = 'hidden';
        
        processing.value = true;
        const response = await axios.post('/api/addTransactions', attachLists.value, {
            headers: {
                'Authorization': 'Bearer ' + page.props.csrf_token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        if (response.data.status === 'success') {
            new_transactions_added.value = true;
            element.scrollTop = 0;
            element.style.overflowY = 'auto';
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Data has been sent successfully!',
            });
            document.querySelector('#plaidAttachedModal .btn-close').click();
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `Response failure .${ response.data.status }`,
            });
        }
        processing.value = false;
    } catch (error) {
        processing.value = false;
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: `There was a problem when saving the data! .${ error }`,
        });
    }
}

watch(attachLists, (_) => {
    calculateTotalAmount();
    hasEmptyJobsite();
}, {deep: true});


// onMounted(() => {
//   let modalElem = document.getElementById('plaidAttachedModal');
//   modalElem.addEventListener('show.bs.modal', resetModalData);
// });

// onUnmounted(() => {
//   let modalElem = document.getElementById('plaidAttachedModal');
//   modalElem.removeEventListener('show.bs.modal', resetModalData);
// });

</script>