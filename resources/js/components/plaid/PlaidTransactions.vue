<template>
    <div class="modal-transparent d-flex" style="position: absolute; left: 0; top: 0; bottom: 0; right: 0; z-index: 1000;" v-if="showing">
        <div class="flex-grow-1 d-flex justify-content-end px-5 pt-5" style="margin-bottom: auto;">
            <div class="bg-white shadow-lg p-3 b-radius-5 d-flex flex-column" v-if="selectedTransaction" style="width: 500px;">
                <div class="d-flex justify-content-between">
                    <p class="text-muted f-w-600">Transaction Details</p>
                    <a style="cursor: pointer;" @click="handleCloseSelected"><i class="icon-close"></i></a>
                </div>
                <div class="d-flex px-2">
                    <img :src="selectedTransaction.personal_finance_category_icon_url" :alt="selectedTransaction.merchant_name" style="height: 50px;"/>
                    <div class="d-flex flex-column gap-0 px-3" style="overflow: hidden;">
                        <a class="text-dark f-12 f-w-700 m-0 p-0 text-truncated">Description: <span class="text-muted">{{ selectedTransaction.name }}</span></a>
                        <a class="text-dark f-12 f-w-700 m-0 p-0 text-truncated">Merchant: <span class="text-muted">{{ selectedTransaction.merchant_name }}</span></a>
                        <a class="text-dark f-12 f-w-700 m-0 p-0 text-truncated">ID: <span class="text-muted">{{ selectedTransaction.transaction_id }}</span> <span style="cursor: pointer;" class="text-dark f-14"><i class="icon-files"></i></span></a>
                        <a class="text-dark f-12 f-w-700 m-0 p-0 text-truncated">Date: <span class="text-muted">{{ selectedTransaction.date }}</span></a>
                    </div>
                </div>
                <hr>
                <div class="d-flex flex-column"> 
                    <p class="text-danger f-w-600 p-0 m-0" v-if="selectedTransaction.amount < 0">Log Project Expense</p>     
                    <p class="text-success f-w-600 p-0 m-0" v-else>Log Project Amount Received</p>       
                    <a class="text-dark f-40 f-w-700 m-0 p-0" :class="selectedTransaction.amount < 0 ? 'text-danger-v2' : 'text-success-v2'">{{ formatCurrency(selectedTransaction.amount) }}</a>
                    
                    <hr v-if="splits.length != 0">
                    <div class="d-flex flex-column py-2 gap-2" v-if="splits.length != 0">   
                        <p class="text-muted f-w-600 p-0 m-0" >Split Amount</p>
                        <template v-for="split in splits">
                            <div class="d-flex gap-2 align-items-center">
                                <a class="f-20 f-w-700" :class="split.amount < 0 ? 'text-danger-v2' : 'text-success-v2'">{{ formatCurrency(split.amount) }}</a> | 
                                <select class="px-2 py-1"><option class=" f-w-600">Select Project</option></select>|
                                <a class="f-16 f-w-700">{{ split.percent }}%</a>
                            </div>
                        </template>
                    </div>   

                    <hr>
                    <div class="d-flex gap-2">
                        <a class="btn px-3 py-1 btn-warning-v2" @click="handleSplitClick" v-if="splits.length === 0">Split</a>
                        <a class="flex-grow-1"></a>
                        <a class="btn px-3 py-1" :class="selectedTransaction.amount < 0 ? 'btn-danger-v2' : 'btn-success-v2'">Attach {{ splits.length === 0 ? 'Full' : 'Splited' }} Amount</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-lg d-flex flex-column" :class="this.isOpen ? 'right-slide-animation-in' : 'right-slide-animation-out'">
            <div class="d-flex align-items-center">
                <h5 class="p-3 f-w-600 text-dark m-0 p-0 flex-grow-1" style="height: 55px;">Plaid Transaction</h5>
                <a style="cursor: pointer;" @click="store.close()" class="p-3"><i class="icon-close"></i></a>
            </div>
            <div style="height: 1px; width: 100%;" class="bg-primary"></div>
            <div class="flex-grow-1 bg-main" style="max-height: calc(100vh - 51px); overflow: hidden;">
                <div class="d-flex justify-content-center align-items-center f-14 f-w-600 text-muted py-2" v-if="loading">
                    <i class="fa fa-spin fa-spinner me-2"></i>Loading...
                </div>
                <div v-else-if="transactions.length != 0" class="slim-scroll-gray d-flex flex-column gap-3 py-3" style="max-height: calc(100vh - 51px); overflow: auto;">
                    <template v-for="transaction in transactions">
                        <div class="p-2 bg-hover-primary f-14 f-w-600 text-muted mx-3 shadow-sm bigger bg-white"
                            :class="selectedTransaction && selectedTransaction.transaction_id === transaction.transaction_id ? transaction.amount < 0 ? 'b-l-danger-3-v2' : 'b-l-success-3-v2' : ''"
                             style="border-radius: 5px; cursor: pointer;" 
                             @click="handleSelectedTransaction(transaction)">
                            <div class="d-flex align-items-center px-2">
                                <img :src="transaction.personal_finance_category_icon_url" :alt="transaction.merchant_name" style="height: 50px;"/>
                                <div class="d-flex flex-column gap-0 px-3" style="overflow: hidden;">
                                    <a class="text-dark f-12 f-w-700 m-0 p-0 text-truncated">{{ transaction.name }}</a>
                                    <a class="text-dark f-20 f-w-700 m-0 p-0" :class="transaction.amount < 0 ? 'text-danger-v2' : 'text-success-v2'">{{ formatCurrency(transaction.amount) }}</a>
                                    <a class="text-muted f-12 f-w-700 m-0 p-0">Date: {{ transaction.date }}</a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center f-14 f-w-600 text-muted py-2"  v-else>
                    <p>Your transactions is empty.</p>
                    <a class="btn btn-primary-v2" @click="handleRetryConnection">Let's try reconnecting</a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useTransactionSidebar } from '../../stores/plaid-transaction';
import { usePage } from '@inertiajs/inertia-vue3';
import axios from 'axios';

export default {
    data(){
        const showing = false;
        const loading = false;
        const linkToken = '';
        const refAccessToken = '';
        const tokenError = '';
        const tokenErrorMessage = '';
        const transactions = [];
        const selectedTransaction = null;
        const splits = [];

        return { showing, loading, linkToken, refAccessToken, tokenError, tokenErrorMessage, transactions, selectedTransaction, splits }
    },
    setup(){
        const store = useTransactionSidebar();
        const page = usePage();

        return { store, page }
    },
    methods: {
        handleRetryConnection(){
            this.fetchLinkToken();
        },
        handleCloseSelected(){
            this.selectedTransaction = null;
        },
        handleSplitClick(){
            this.splits.push(this.splitAmount(this.selectedTransaction.amount, 100));
            this.splits.push(this.splitAmount(this.selectedTransaction.amount, 100));
        },
        splitAmount(amount, percent){
            const splitAmount = amount/2;
            const splitPercent = percent/2;
            const splitObject = { amount: splitAmount, percent: splitPercent, jobsite_site: null };
            return splitObject;
        },
        handleSelectedTransaction(transaction){
            this.splits = [];
            this.selectedTransaction = transaction;
        },
        updateVisibility() {
            if (this.store.isOpen) {
                this.showing = true;

                if(window.plaid_access_token){
                    this.fetchTransactions(window.plaid_access_token);
                }
            } else {
                setTimeout(() => {
                    this.showing = false;
                }, 500);
            }
        },
        linkPlaidAccount() {
            this.fetchLinkToken();
        },
        async fetchLinkToken() {
            try {
                this.loading = true;
                const response = await axios.post('/api/plaid/create_link_token', {
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                const jsonData = response.data;
                this.linkToken = jsonData.link_token;

                if (this.linkToken) {
                    this.initializePlaid(this.linkToken);
                }else{
                    this.loading = false;
                    console.error('Error fetching Plaid link token: ', jsonData);
                }
            } catch (error) {
                console.error('Error fetching Plaid link token: (error)', error);
            }
        },
        initializePlaid(token) {
            const linkHandler = Plaid.create({ token,
                onSuccess: (public_token, metadata) => {
                    this.exchangePublicToken(public_token);
                },
                onExit: (err, metadata) => {
                    console.log('Plaid onExit:', err, metadata);
                },
            });

            this.loading = false;
            linkHandler.open();
        },
        async exchangePublicToken(public_token) {
            try {
                this.loading = true;
                const response = await axios.post('/api/plaid/exchange_public_token', {public_token: public_token}, {
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                const jsonData = response.data;
                if(jsonData){
                    const error_code = jsonData.error_code;
                    this.refAccessToken = jsonData.access_token;

                if(error_code){
                    this.tokenError = error_code;
                    this.tokenErrorMessage = jsonData.message;
                    console.log(`(${error_code}) Create alert here saying: `, jsonData.message);
                }else if (this.refAccessToken) {
                    this.tokenError = null;
                    this.fetchTransactions(this.refAccessToken);
                    this.saveAccessToken(this.refAccessToken);
                }else{
                    this.tokenError = 'UNKNOWN_ERROR_UNIDENTIED_RESPONSE';
                    this.tokenErrorMessage = 'Unknown issue occured while connecting to your plaid account.';
                    console.error('Error fetching Plaid access token: ', jsonData);
                }
                }else{
                    this.tokenError = 'UNKNOWN_ERROR_NO_JSON';
                    this.tokenErrorMessage = 'Unknown issue occured while connecting to your plaid account.';
                    console.error('Error fetching Plaid access token NO JSON');
                }

                this.loading = false;
            } catch (error) {
                console.error('Error fetching Plaid access token: (error)', error);
            }
        },
        async saveAccessToken(access_token) {
            try {
                await axios.post('/api/plaid/save_access_token', {access_token: access_token}, {
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
            } catch (error) {
                console.error('Error fetching Plaid link token: (error)', error);
            }
        },
        async fetchTransactions(access_token) {
            try {
                this.loading = true;
                const response = await axios.post('/api/plaid/transaction_sync', { access_token: access_token }, {
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                const jsonData = response.data;
                if(jsonData.added){
                    this.transactions = jsonData.added;
                }
                
                console.log('jsonData changed', jsonData);
                this.loading = false;
            } catch (error) {
                this.loading = false;
                console.error('Error fetching Plaid link token: (error)', error);
            }
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
    computed: {
        isOpen() {
            return this.store.isOpen;
        }
    },
    watch: {
        isOpen: {
            handler() {
                this.updateVisibility();
            }
        }
    }
}
</script>