<template>
    <div class="modal fade" id="addPayment" tabindex="-1" role="dialog" aria-labelledby="addPayment" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0">
                    <div class="card p-0 m-0">
                        <div class="card-header px-4 py-3">
                            <h5>Collect Deposit Online</h5>
                            <span>Use these settings to request payment upon or after approval of this proposal.</span>
                            <button class="btn-close close" type="button" data-bs-dismiss="modal" aria-label="Close" @click="store.closeModal()"></button>
                        </div>
                        <div class="card-body p-0" style="background-color: #f5f7fb; overflow-y: auto; max-height: 65vh;">
                            <div class="card m-0 p-0">
                                <div class="card-body m-0 p-0 px-4 py-4">
                                    <h5>Proposal Client Total: <span class="f-w-700">{{ formatCurrency(this.clientPrice) }}</span></h5>
                                    <hr/>

                                    <div class="d-flex flex-column m-0 p-0 gap-4">
                                        <div class="col-md-12 p-0">
                                            <label class="form-label f-w-600 p-0">Payment Type</label>
                                            <div class="col-md-12" role="group" aria-label="Basic example">
                                                <div class="btn" style="border-bottom-right-radius: 0px; border-top-right-radius: 0px;"
                                                        :class="depositType == 'amount' ? 'btn-primary-v2 text-white' : 'btn-outline-primary-v2'" 
                                                        type="button" 
                                                        @click="togglePaymentAmountValue('amount')">Amount</div>
                                                <div class="btn"  style="border-bottom-left-radius: 0px; border-top-left-radius: 0px;"
                                                        :class="depositType == 'percent' ? 'btn-primary-v2 text-white' : 'btn-outline-primary-v2'" 
                                                        type="button" 
                                                        @click="togglePaymentAmountValue('percent')">Percent</div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 row m-0 p-0" v-if="depositType == 'amount'">
                                            <label class="form-label f-w-600 p-0">Payment Amount</label>
                                            <div class="input-group p-0">
                                                <span class="input-group-text b-primary" style="font-size: 12px !important;">$</span>
                                                <input class="form-control b-primary" @input="processInput" aria-label="Amount (to the nearest dollar)" v-model="deposit">
                                            </div>
                                            <div class="text-danger px-0 py-0" v-if="modalBillingAmountError">{{ modalBillingAmountError }}</div>
                                        </div>
                                        
                                        <div class="col-md-12 d-flex row m-0 p-0 gap-3" v-else>
                                            <div class="p-0 pr-2" style="width: 200px;">
                                                <label class="form-label f-w-600">Percent of Total</label>
                                                <div class="input-group">
                                                    <input class="form-control b-primary" @input="processInput" aria-label="Amount (to the nearest dollar)" v-model="percentage">
                                                    <span class="input-group-text b-primary" style="font-size: 12px !important;">%</span>
                                                </div>
                                            </div>
                                            <div class="p-0" style="width: 200px;">
                                                <label class="form-label f-w-600">Payment Amount</label>
                                                <label class="form-control f-w-500 b-primary">{{ computePercentage() }}</label>
                                                <div class="text-danger px-0 py-0" v-if="modalBillingAmountError">{{ modalBillingAmountError }}</div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row m-0 p-0">
                                            <label class="form-label f-w-600 p-0">Payment Due</label>
                                            <div class="col mt-1">
                                                <label class="d-block" for="pd-upon">
                                                    <input class="radio_animated" id="pd-upon" type="radio" name="rdo-pd" checked="" value="upon" v-model="paymentDue">Upon approval of proposal
                                                </label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <label class="d-block mr-3" for="pd-after">
                                                            <input class="radio_animated" id="pd-after" type="radio" name="rdo-pd" value="after" v-model="paymentDue">After approval of proposal
                                                    </label>
                                                    <template v-if="paymentDue === 'after'">
                                                        <div class="col-md-1 row m-0 p-0 mr-3">
                                                            <input class="form-control b-primary" type="number" min="1" v-model="paymentDueDay">
                                                        </div>
                                                        <label class="col-md-4" for="pd-after"># of Days After Approval</label>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="col-md-12 row m-0 p-0">
                                            <label class="form-label f-w-600 p-0">Payment Method</label>
                                            <div class="col mt-1">
                                                <label class="d-block" for="pm-cc">
                                                    <input class="radio_animated" id="pm-cc" type="radio" name="rdo-pm" checked="" value="credit" v-model="paymentMethod">Credit Card
                                                </label>
                                                <label class="d-block" for="pm-ach">
                                                    <input class="radio_animated" id="pm-ach" type="radio" name="rdo-pm" value="ach" v-model="paymentMethod">ACH
                                                </label>
                                                <label class="d-block" for="pm-cc-or-ach">
                                                    <input class="radio_animated" id="pm-cc-or-ach" type="radio" name="rdo-pm" value="credit-ach" v-model="paymentMethod">Credit Card ACH
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 d-flex">
                            <button class="btn btn-danger-v2" data-bs-dismiss="modal" @click="handleCancelPaymentRequest" v-if="store.form.request_deposit">Cancel Payment Request</button>
                            <span class="flex-grow-1"></span>
                            <div class="d-flex gap-3">
                                <button class="btn btn-light" data-bs-dismiss="modal" @click="store.closeModal()">Close</button>
                                <button class="btn btn-primary-v2" data-bs-dismiss="modal" @click="handleSubmit"  v-if="!modalBillingAmountError">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { usePaymentRequest } from '../../stores/payment-request';
import { useWorksheet } from '@/stores/worksheet-table';

export default {
    data(){  
        const modalBillingAmountError = '';
        const deposit = 0.0;
        const depositType = 'amount';
        const paymentDue = 'upon';
        const paymentDueDay = 1;
        const paymentMethod = 'credit';
        const percentage = 0;

        return { depositType, modalBillingAmountError, deposit, paymentDue, paymentDueDay, paymentMethod, percentage }
    },
    setup(){
        const store = usePaymentRequest();
        const worksheetStore = useWorksheet();

        return { store, worksheetStore }
    },
    methods: {
        handleCancelPaymentRequest(){
            this.store.form.request_deposit = false;
            this.store.closeModal();
        },
        handleSubmit(){
            this.store.setSubmittedForm({
                ...this.store.form,
                proposal_billing_id: 0,
                request_deposit: true,
                deposit: this.deposit,
                deposit_type: this.depositType,
                payment_due: this.paymentDue,
                payment_due_day: this.paymentDueDay,
                payment_method: this.paymentMethod,
                percentage: this.percentage
            });
            this.store.closeModal();
        },
        updateModalVisibility() {
            const modalElement = document.getElementById('addPayment');
            const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});

            if (this.store.isModalOpen) {
                modalInstance.show();
            } else {
                document.querySelector(`#addPayment .close`).click();
            }
        },
        togglePaymentAmountValue(type){
            this.depositType = type;
            this.store.setDepositType(type);
        },
        processInput(event) {
            let value = event.target.value;

            if (!/^\d*\.?\d{0,2}$/.test(value)) {
                event.target.value = value.substring(0, value.length - 1);
            }
        },
        computePercentage(){
            if(this.worksheetStore.clientPrice){
                const totalOwnerPrice = this.clientPrice + '';
                const owner_price = parseFloat(totalOwnerPrice.replace(/[$,]/g, ''));
                const deposit = owner_price * (this.percentage/100);
                if(deposit > this.clientPrice){
                    this.modalBillingAmountError = `Deposit can't exceed the client price ${this.formatCurrency(this.clientPrice)}`;
                }else if(deposit > 1000){
                    this.modalBillingAmountError = `Deposit can't exceed $1,000.`;
                }else{
                    this.modalBillingAmountError = '';
                    this.deposit = parseFloat(deposit).toFixed(2);
                    this.store.setDeposit(this.deposit);
                }

                return this.formatCurrency(deposit);
            }else{
                return '$0.0';
            }
        },
        formatCurrency(amount) {
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
    },
    computed: {
        isModalOpen() {
            return this.store.isModalOpen;
        },
        clientPrice(){
            return (this.worksheetStore.clientPrice - this.worksheetStore.discount).toFixed(2);
        }
    },
    watch: {
        isModalOpen: {
            handler() {
                this.updateModalVisibility();
            }
        },
        deposit: {
            handler(newValue) {
                if(newValue > this.clientPrice){
                    this.modalBillingAmountError = `Deposit can't exceed the client price ${this.formatCurrency(this.clientPrice)}`;
                }else if(newValue > 1000){
                    this.modalBillingAmountError = `Deposit can't exceed $1,000.`;
                }else{
                    this.modalBillingAmountError = '';
                    this.store.setDeposit(newValue);
                }
            }
        }
    }
}
</script>