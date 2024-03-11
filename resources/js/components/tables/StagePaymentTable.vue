<template>
    <div class="m-0 p-0 slim-scroll-gray" style="max-height: calc(100vh - 370px); overflow: auto;">
        
        <div class="m-0 p-0 px-4" v-if="worksheetStore.worksheet.length === 0">
            <div class="card-body m-0 p-0">
                <a class="f-18 f-w-600 text-danger-v2">Please try adding items to the worksheet.</a>
            </div>
        </div>
        <div class="m-0 p-0 px-4" v-else>  
            <div class="m-0 p-0 d-flex flex-column gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="m-0 p-0 f-w-600 f-20">Payment Details</h4>
                </div>
                <div class="d-flex flex-column gap-1">
                    <div class="d-flex py-2 justify-content-between">
                        <div class="d-flex flex-column gap-2">
                            <div v-if="payment.request_deposit" class="d-flex gap-2 flex-column">                            
                                <div class="d-flex gap-2">
                                    <label class="f-w-600 f-14 text-muted m-0">Resquest Status:</label>
                                    <label class="f-w-600 f-14 text-white bg-warning-v2 px-3 b-radius-10 m-0">Pending</label>
                                </div>
                                <div class="d-flex gap-2">
                                    <label class="f-w-600 f-14 text-muted m-0">Payment Due:</label>
                                    <label class="f-w-600 f-14 m-0">{{ formatPaymentDue(payment.payment_due, payment.payment_due_day) }}</label>
                                </div>
                                <div class="d-flex gap-2">
                                    <label class="f-w-600 f-14 text-muted m-0">Payment Method:</label>
                                    <label class="f-w-600 f-14 m-0">{{ formatPaymentMethod(payment.payment_method) }}</label>
                                </div>
                            </div>
                            <div class="d-flex gap-2 align-items-center justify-content-center">
                                <label class="f-w-700 f-14 text-muted m-0">Job Client Price:</label>
                                <label class="f-w-700 f-18  m-0">{{ formatCurrency(clientPrice) }} 
                                    <small class="f-14 f-w-600 text-danger-v2" v-if="(totalStagesAmount.toFixed(2) != clientPrice)">( {{ getDifference() }} )</small>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex align-items-end">
                            <div class="d-flex gap-2">
                                <div class="d-flex gap-2">
                                    <a class="btn btn-outline-light float-right px-3" style="height: 35px !important;" @click="handleGenerateStages">Generate Stage Payment</a>
                                    <a class="btn btn-outline-light float-right px-3" style="height: 35px !important;" @click="handleAddStagePayment">New Stage</a>
                                </div>
                                <a class="btn btn-primary-v2 px-3" style="height: 35px !important;" @click="handlePaymentRequestClicked"> {{payment.request_deposit ? 'Edit' : 'Add'}} Required Deposit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body m-0 p-0">
                <div class="d-flex flex-column mt-2" v-if="paymentStore.form && paymentStore.form.stages">
                    <div class="col-12">
                        <li class="d-flex m-0 p-0 bg-primary-v2 text-white f-16 gap-2">
                            <span class="px-3 py-2 flex-grow-1 f-w-600 text-center" style="max-width: 90px;">Action</span>
                            <span class="px-3 py-2 flex-grow-1 f-w-600">Payment Name</span>
                            <span class="px-3 py-2 flex-grow-1 f-w-600" style="max-width: 120px;">Percent</span>
                            <span class="px-3 py-2 flex-grow-1 f-w-600" style="max-width: 200px;">Amount</span>
                            <span class="px-3 py-2 flex-grow-1 f-w-600" style="max-width: 150px;">Stage</span>
                            <span class="px-3 py-2 flex-grow-1 f-w-600" style="max-width: 200px; min-width: 200px;">Stage Amount</span>
                        </li>
                    </div>
                    <template v-for="stage in payment.stages" :key="'stage-' + stage">
                        <div class="col-12 position-relative">
                            <div class="bg-secondary-v2" style="height: 2px;" v-if="stage != 1"></div>
                            <div style="position: absolute; right: 0; width: 200px;" v-if="payment.stage_payments[stage-1].length !== 0"
                                class="bg-white d-flex align-items-center px-3" 
                                :style="{'height': `${58 * (payment.stage_payments[stage-1].length)}px`}">

                                <span class="f-16 f-w-600">$0.0</span>

                            </div>
                            <draggable :list="payment.stage_payments[stage-1]" group="people" @change="log" handle=".handle" :stage="stage" v-if="(payment.stage_payments[stage-1]) ? payment.stage_payments[stage-1].length == 0 : true ">
                                <li class="d-flex m-0 p-0 text-center py-1 f-w-700  bg-main">
                                    <span class="px-3 py-1 flex-grow-1 d-flex gap-2" style="max-width: 120px;">
                                        <i class="icon-trash f-w-500 f-18 text-danger bigger" style="cursor: pointer;" @click="handleDeleteStage(stage, null)"></i>
                                    </span>
                                    <span class="px-3 py-1 flex-grow-1 f-w-700">Empty Stage {{ stage }}</span>
                                </li>
                            </draggable>
                            <template v-for="(element, index) in payment.stage_payments[stage-1]" :key="'element-' + element.proposal_billing_stage_id + '-' + index">
                                <draggable :list="payment.stage_payments[stage-1]" group="people" @change="log" handle=".handle" :stage="stage">
                                    <li class="d-flex m-0 p-0 py-2 gap-2 align-items-center" :class="(editingStage === stage && editingStageIndex === index) ? 'bg-main' : ''" style="height: 58px;">

                                        <template v-if="editingStage === stage && editingStageIndex === index">
                                            <span class="px-3 py-2 flex-grow-1 d-flex gap-2" style="max-width: 90px;">
                                                <i class="icon-close bg-danger-v2 text-white b-radius-5 p-1 bigger" style="cursor: pointer;" @click="handleEditStage(null, null)"></i>
                                                <i class="icon-check bg-success-v2 text-white b-radius-5 p-1 bigger" style="cursor: pointer;" @click="handleEditStage(null, null)"></i>
                                            </span>
                                            <input class="px-3 py-2 flex-grow-1 f-w-500 b-primary-2-v2 b-radius-5" v-model="editingTitle" />
                                            <input class="px-3 py-2 flex-grow-1 f-w-500 b-primary-2-v2 b-radius-5" style="max-width: 120px;" type="number" v-model="editingPercent" @focus="handleFocusInput('percent')"/>
                                            <input class="px-3 py-2 flex-grow-1 f-w-500 b-primary-2-v2 b-radius-5" style="max-width: 200px;" type="number" v-model="editingAmount" @focus="handleFocusInput('amount')"/>
                                            <span class="px-3 py-2 flex-grow-1 f-w-500" style="max-width: 150px;">Stage {{ stage }}</span>
                                            <span class="px-3 py-2 flex-grow-1 700" style="max-width: 200px; min-width: 200px;"><div class="f-w-600">{{ formatCurrency(calculateStageTotal(stage)) }}</div></span>
                                        </template>

                                        <template v-else>
                                            <span class="px-3 py-2 flex-grow-1 d-flex gap-2" style="max-width: 90px;">
                                                <i class="icon-align-justify handle f-w-500 f-18" style="cursor: grab;"></i>
                                                <i class="icon-trash f-w-500 f-18 text-danger bigger" style="cursor: pointer;" @click="handleDeleteStage(stage, index)"></i>
                                            </span>
                                            <span class="px-3 py-2 flex-grow-1 f-w-500 border-input" 
                                                @click="handleEditStage(stage, index)" style="cursor: text;">{{ element.stage_name }}</span>
                                            <span class="px-3 py-2 flex-grow-1 f-w-600 border-input" 
                                                @click="handleEditStage(stage, index, 'percent')" style="max-width: 120px; cursor: text;">{{ this.getPercentage(element.stage_amount)}}%</span>
                                            <span class="px-3 py-2 flex-grow-1 f-w-500 d-flex gap-2 border-input" 
                                                @click="handleEditStage(stage, index, 'amount')" style="max-width: 200px; cursor: text;">
                                                {{ formatCurrency(element.stage_amount) }}
                                            </span>
                                            <span class="px-3 py-2 flex-grow-1 f-w-500" style="max-width: 150px;">Stage {{ stage }}</span>
                                            <span class="px-3 py-2 flex-grow-1 700" style="max-width: 200px; min-width: 200px;"><div class="f-w-600">{{ formatCurrency(calculateStageTotal(stage)) }}</div></span>
                                        </template>


                                    </li>
                                </draggable>
                            </template>
                        </div>
                    </template>
                    <li class="d-flex m-0 p-0 bg-primary-v2 text-white f-16">       
                        <span class="px-3 py-2 flex-grow-1 text-right f-w-500">Total Stage Payment: </span>
                        <span class="px-3 py-2 f-w-700 flex-grow-1" style="max-width: 200px;">{{ formatCurrency(totalStagesAmount) }}</span>
                    </li>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Swal from 'sweetalert2';
import axios from 'axios';
import { VueDraggableNext } from 'vue-draggable-next';
import { useStagePayment } from '../../stores/stage-payment';
import { usePaymentRequest } from '../../stores/payment-request';
import { useWorksheet } from '@/stores/worksheet-table';
import { usePage } from "@inertiajs/vue3";

export default {
    components: { draggable: VueDraggableNext },
    props: {
        worksheets: {
            typeof: Array,
            default: []
        },
        proposal_id: {
            typeof: Number,
            default: 0
        }
    },
    setup(){
        const paymentStore = usePaymentRequest();
        const stageStore = useStagePayment();
        const worksheetStore = useWorksheet();
        const page = usePage();
        
        return { stageStore, paymentStore, worksheetStore, page }
    },
    data(){
        const payment = {
            proposal_billing_id: 0,
            request_deposit: false,
            deposit: 0.0,
            deposit_type: 'amount',
            payment_due: 'upon',
            stages: 0,
            payment_due_day: 1,
            payment_method: 'credit',
            percentage: 0,
            stage_payments: [[]]
        }
        const asset_link = window.asset_link;
        const totalStagesAmount = 0;
        const editingStage = null;
        const editingStageIndex = null;
        const editingTitle = '';
        const editingPercent = 0;
        const editingAmount = 0;
        const editingField = 'default';

        return { payment, asset_link, totalStagesAmount, editingStage, editingStageIndex, editingTitle, editingPercent, editingAmount, editingField }
    },
    methods: {
        handleGenerateStages(){
            if(this.payment.stages != 0){
                Swal.fire({
                    title: 'Generate Stages?',
                    html: "This will generate a stage payment for you base on your worksheet, doing so will remove all you stages set below. <br><br><b>Do you wish to proceed?</b>",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.generateStagePayment();
                        this.recalculateTable();
                    }
                });
            }else{
                this.generateStagePayment();
                this.recalculateTable();
            }
        },
        getDifference(){
            const diff =  this.clientPrice - this.totalStagesAmount;
            const diffString = diff < 0 ? 'below' : 'above';
            const amount = Math.abs(diff);
            return `${this.formatCurrency(amount)} ${diffString}`;
        },
        handleFocusInput(type){
            this.editingField = type;
        },
        handleEditStage(stage, index, type = 'default'){
            if(this.editingStage !== null && this.editingStageIndex !== null){
                const details = this.payment.stage_payments[this.editingStage - 1][this.editingStageIndex];
                this.payment.stage_payments[this.editingStage - 1][this.editingStageIndex] = {
                    ...details,
                    stage_amount: this.editingAmount,
                    stage_name: this.editingTitle
                }
                
                this.recalculateTable();
            }

            this.editingField = type;
            this.editingStage = stage;
            this.editingStageIndex = index;

            const stageDetails = this.payment.stage_payments[stage - 1][index];
            this.editingTitle = stageDetails.stage_name;
            this.editingPercent = this.getPercentage(stageDetails.stage_amount);
            this.editingAmount = stageDetails.stage_amount;            
        },
        getPercentage(amount){
            const clientPrice = this.clientPrice;
            const percentage = (amount / clientPrice) * 100;
    
            return percentage.toFixed(2);
        },
        getAmount(percentage){    
            const clientPrice = this.clientPrice;
            const amount = (percentage / 100) * clientPrice;
            return amount.toFixed(2);
        },
        handleAutofill(){
            const clientPrice = this.clientPrice;
            const paymentSchedulePrice = this.worksheetStore.paymentSchedulePrice.toFixed(2);
            const balance = (clientPrice - paymentSchedulePrice).toFixed(2);

            let counter = 0;
            this.payment.stage_payments.forEach(stage_payment => {
                stage_payment.forEach(stage => {
                    if(stage.type === 'worksheet' && !stage.locked){
                        counter++;
                    }
                });
            });

            if(counter === 0){
                Swal.fire({
                    icon: 'danger',
                    title: 'Invalid!',
                    text: 'There should be atleast 1 unlocked worksheet item to feel into.',
                });
                return;
            }

            const extraDeduction = (balance/counter).toFixed(2);
            this.payment.stage_payments.map((stage_payment)  => {
                stage_payment.map((stage) => {
                    if(stage.type === 'worksheet' && !stage.locked){
                        stage.stage_amount = (parseFloat(stage.stage_amount) + parseFloat(extraDeduction)).toFixed(2);
                    }
                });
            });
            
            this.recalculateTable();
        },
        log(event){
            console.log(event);
        },
        handlePaymentRequestClicked(){
            this.paymentStore.toggleModal();
        },
        calculateStageTotal(stage) {
            const payments = this.payment.stage_payments[stage - 1];
            if (!payments) {
                return 0.0;
            }
            const total = payments.reduce((total, payment) => total + parseFloat(payment.stage_amount), 0.0);
            return Math.round((total + Number.EPSILON) * 100) / 100;  
        },
        handleDeleteStage(stage, index){
            if(index === null){
                this.payment.stage_payments.splice(stage - 1, 1);
                this.payment.stages--;
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Once removed, can't be reverted, do you wish proceed?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Proceed'
            }).then((result) => {
                if (result.isConfirmed) {
                    const item = this.payment.stage_payments[stage - 1][index];
                    if(item.type === 'deposit'){
                        this.paymentStore.setIncludeDeposit(false);
                        this.payment.request_deposit = false;
                    }
                    if(item.type === 'startup'){
                        this.paymentStore.setIncludeStartUp(false);
                    }
                    if(item.type === 'completion'){
                        this.paymentStore.setIncludeCompletion(false);
                    }
                    this.payment.stage_payments[stage - 1].splice(index, 1);

                    this.recalculateTable();
                }
            });
        },
        handleToggleLock(element, index, stage){
            console.log(element);
            this.payment.stage_payments[stage - 1][index] = {
                ...element,
                locked: !element.locked
            }
        },
        handleUpdateStage(element, index, stage){
            this.stageStore.setForm({
                ...element,
                update_index: index,
                update_stage: stage
            });
            this.stageStore.toggleModal();
        },
        handleAddStagePayment(){
            this.insertNewStagePayment(`Stage ${this.payment.stages}`, 0.0, 'stage');
        },
        incrementStage(){
            this.payment.stages++;
            this.payment.stage_payments.push([]);
            this.paymentStore.setStage(this.payment.stages);
            this.paymentStore.setStagePayments(this.payment.stage_payments);
        },
        decrementStage() {
            if (this.payment.stages > 1){
                const last = this.payment.stage_payments[(this.payment.stages - 1)];
                const check = last.length;
                const index = this.payment.stages - 1;

                if(check == 0){
                    this.payment.stage_payments.splice(index, 1);
                    this.payment.stages--;
                }else{
                    Swal.fire({
                        title: 'Not EMPTY Stage!',
                        text: "You have stage items in this stage, removing the stage means removing the items in it, do you wish to proceed?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Proceed'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.payment.stage_payments.splice(index, 1);
                            this.payment.stages--;
                        }
                    });
                }
                
                this.paymentStore.setStage(this.payment.stages);
                this.paymentStore.setStagePayments(this.payment.stage_payments);
            }
        },
        formatPaymentTotal(total){
            if(this.sumOwnerPrice){
                const totalOwnerPrice = this.sumOwnerPrice + '';
                const ownerPrice = parseFloat(totalOwnerPrice.replace(/[$,]/g, ''));
                const jobTotal = ownerPrice + parseFloat(total);

                return this.formatCurrency(jobTotal.toFixed(2));
            }else{
                return '$0.0';
            }
        },
        formatPaymentType(type, percentage){
            const deposit = parseFloat(this.payment.deposit);
                
            if(type === 'amount'){
                return this.formatCurrency(deposit) + ' (Amount)';
            }else{
                return `${this.formatCurrency(deposit)} : (${percentage}%)`;
            }
        },
        formatPaymentDue(due_type, days){
            if(due_type === 'upon'){
                return 'Upon approval';
            }else{
                return days + ' days after approval';
            }
        },
        formatPaymentMethod(method){
            if(method === 'credit-ach'){
                return 'Credit Card or ACH';
            }else if(method === 'credit'){
                return 'Credit Card';
            }else if(method === 'ach'){
                return 'ACH';
            }else{
                return 'N/A';
            }
        },
        getPaymentDue(due_type){
            const returnValue = {
                due_type: 'upon',
                days: 0
            }

            if(due_type !== 'upon'){
                returnValue.due_type = 'after';
                returnValue.days = parseInt(due_type.replace(' days after',''));
            }
            return returnValue;

        },
        getPaymentType(type){
            const returnValue = {
                type: 'amount',
                percentage: 0
            }
            
            if(type !== 'amount'){
                returnValue.type = 'percent';
                returnValue.percentage = parseFloat(type.replace('%',''));
            }
            return returnValue;
        },
        async getProposalPaymentRequest(proposal_id) {
            try {
                const response = await axios.get(`/api/getProposalPaymentRequest/${proposal_id}`, {}, {
                    headers: {
                        'Authorization': 'Bearer ' + this.page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = response.data;
                
                if(data.status === 'success'){
                    const billingData = data.data;
                    if(billingData){
                        const deposit_type = this.getPaymentType(billingData.deposit_type);
                        const payment_due = this.getPaymentDue(billingData.payment_due);
                        this.payment = {
                            proposal_billing_id: billingData.proposal_billing_id,
                            deposit: parseFloat(billingData.deposit).toFixed(2),
                            deposit_type: deposit_type.type,
                            percentage: parseFloat(deposit_type.percentage),
                            stages: billingData.stages,
                            payment_due: payment_due.due_type,
                            payment_due_day: payment_due.days,
                            payment_method: billingData.payment_method,
                            stage_payments: this.payment.stage_payments
                        }

                        this.payment.stage_payments = [];
                        for (let i = 0; i < billingData.stages; i++) {
                            this.payment.stage_payments.push([]);
                        }
                        
                        billingData.stages_detail.forEach(stage => {
                            const index = stage.stage_number - 1;
                            if (index >= 0 && index < this.payment.stage_payments.length) {
                                const newForm = {
                                    proposal_billing_stage_id: stage.proposal_billing_stage_id,
                                    proposal_billing_id: stage.proposal_billing_id,
                                    stage_name: stage.stage_name,
                                    stage_number: stage.stage_number,
                                    stage_amount: stage.stage_amount,
                                    update_stage: stage
                                };

                                this.payment.stage_payments[index].push(newForm);
                            }
                        });
                        // this.togglePaymentAmountValue(deposit_type.type);
                    }

                    this.paymentStore.setForm(this.payment);
                    this.recalculateTable();
                }
                // this.initialData = { ...this.payment };
                // this.initialPaymentRequest = { ...this.payment.payment_request};
                // this.fetchingData = false; //make sure to add this before the end of fetching DATA
            } catch (error) {
                console.error("Error fetching  payment request: ", error);
            }
        },
        insertNewStagePayment(stage_name, stage_amount, type, clientPrice = null, deduction = null, uid = null){
            this.incrementStage();

            const index = this.payment.stages - 1;
            const stage_number = this.payment.stages;
            this.payment.stage_payments[index].push({ stage_name, stage_amount, stage_number, type, client_price: clientPrice, deduction, uid });
            this.paymentStore.setStage(this.payment.stages);
            this.paymentStore.setStagePayments(this.payment.stage_payments);
        },
        resetTable(){
            this.payment.stages = 0;
            this.payment.stage_payments = [[]];
            this.paymentStore.setStage(this.payment.stages);
            this.paymentStore.setStagePayments(this.payment.stage_payments);
        },
        generateStagePayment(){
            this.paymentStore.setIncludeDeposit(true);

            this.resetTable();
            const depositAmount = parseFloat(this.clientPrice) * 0.10;  //CAN BE BASE ON SETTINGS

            let deposit = depositAmount <= 1000 ? depositAmount : 1000;
            this.paymentStore.setDepositType((depositAmount <= 1000) ? 'percent' : 'amount');
            this.paymentStore.setDeposit(deposit);
            this.payment.deposit = deposit;

            let startUpPercentage = 0.20 * 100;
            let completionPercentage = 0.10 * 100;
            let startUp = parseFloat(this.clientPrice) * 0.20; //CAN BE BASE ON SETTINGS 
            let completion = parseFloat(this.clientPrice) * 0.10; //CAN BE BASE ON SETTINGS 

            if(this.paymentStore.options.include_deposit){
                this.insertNewStagePayment(`Deposit`, deposit, 'deposit', true);
                this.totalStagesAmount += deposit;
            }else{
                deposit = 0;
            }
            
            if(this.paymentStore.options.include_startup){
                this.insertNewStagePayment(`Start Job & Rough Material (${parseFloat(startUpPercentage).toFixed(0)}%)`, startUp.toFixed(2), 'startup', true);
                this.totalStagesAmount += startUp;
            }else{
                startUp = 0;
            }

            if(!this.paymentStore.options.include_completion){
                completion = 0;
            }

            const deducted= (parseFloat(deposit) + parseFloat(startUp) + parseFloat(completion));
            const worksheetDeduction = deducted / this.worksheetStore.worksheet.length;
            this.worksheetStore.worksheet.forEach(worksheet => {
                const itemClientPrice = this.getClientPrice(worksheet);
                const amount = itemClientPrice - worksheetDeduction;

                this.insertNewStagePayment(`${worksheet.title}`, (amount).toFixed(2), 'worksheet', false, itemClientPrice, worksheetDeduction, worksheet.uid);
                this.totalStagesAmount += amount;
            });


            if(this.paymentStore.options.include_completion){
                this.insertNewStagePayment(`Upon Completion (${completionPercentage}%)`, completion.toFixed(2), 'completion', true);
                this.totalStagesAmount += completion;
            }
            this.worksheetStore.setPaymentSchedulePrice(this.totalStagesAmount);
        },
        recalculateTable(deposit = null){
            this.totalStagesAmount = 0;
            this.payment.stage_payments.map((stage_payment)  => {
                stage_payment.map((stage) => {
                    if(deposit && stage.type === 'deposit'){
                        stage.stage_amount = deposit;
                    }
                    this.totalStagesAmount += parseFloat(stage.stage_amount);
                });
            });
            this.worksheetStore.setPaymentSchedulePrice(this.totalStagesAmount);
        },
        getClientPrice(costitem){
            const unit_quantity = costitem.unit_quantity ? costitem.unit_quantity : 0;
            const unit_cost = costitem.unit_cost ? costitem.unit_cost : 0;
            const markup = costitem.unit_mark_up ? costitem.unit_mark_up : 0;
            const markup_type = costitem.unit_mark_up_type ? costitem.unit_mark_up_type : '--';
            const builderCost = unit_quantity * unit_cost;
            let totalMarkup = 0;

            if(markup_type){
                if(markup_type === '%'){
                    totalMarkup =  builderCost + ((builderCost) * (markup/100));
                }else if(markup_type === '$/'){
                    totalMarkup = (markup * unit_quantity) + builderCost;
                }else{
                    totalMarkup = parseFloat(markup) + parseFloat(builderCost);
                }
            }
                
            return totalMarkup;
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
    mounted(){
        if(this.worksheetStore.worksheet){
            if(this.paymentStore.form){
                this.payment = this.paymentStore.form;

                if(this.paymentStore.form.stages){
                    this.payment.stages = this.paymentStore.form.stages;
                    this.payment.stage_payments = this.paymentStore.form.stage_payments;
                    this.recalculateTable();
                }else{
                this.getProposalPaymentRequest(this.proposal_id);
                }
            }
        }
    },
    computed: {
        submitedRequest(){
            return this.paymentStore.submitForm;
        },
        submitedStage(){
            return this.stageStore.submitForm;
        },
        clientPrice(){
            return (this.worksheetStore.clientPrice - this.worksheetStore.discount).toFixed(2);
        }
    },
    watch: {
        submitedRequest: {
            handler(newValue){
                if(newValue){
                    this.payment = newValue;

                    let found = false;
                    this.payment.stage_payments.forEach(stage_payment => {
                        stage_payment.map(item => {
                            if(item.type === 'deposit'){
                                found = true;
                            }

                            const stage_amount = (item.type === 'deposit') ? this.payment.deposit : item.stage_amount;
                            return { ...item, stage_amount }
                        });
                    });
                    if(!found){
                        if(this.payment.stages){
                            this.payment.stages++;
                            this.payment.stage_payments.unshift([]);
                            this.payment.stage_payments[0].push({
                                stage_name: 'Deposit', 
                                stage_amount: this.payment.deposit, 
                                stage_number: 0, 
                                type: 'deposit', 
                            });

                            this.paymentStore.setStage(this.payment.stages);
                            this.paymentStore.setStagePayments(this.payment.stage_payments);
                        }else{
                            this.insertNewStagePayment(`Deposit`, this.payment.deposit, 'deposit');
                        }
                    }

                    this.paymentStore.setForm(this.payment);
                    this.paymentStore.clearSubmittedForm();
                    this.recalculateTable(this.payment.deposit);
                }
            }, 
            deep: true
        },
        submitedStage: {
            handler(newValue){
                if(newValue){
                    const stage = newValue;
                    if(stage.update_index === -1){
                        this.incrementStage();
                        this.payment.stage_payments[this.payment.stages - 1].push(stage);
                    }else{
                        this.payment.stage_payments[stage.update_stage - 1][stage.update_index] = stage;
                    }
                    this.paymentStore.setStage(this.payment.stages);
                    this.paymentStore.setStagePayments(this.payment.stage_payments);
                    this.stageStore.clearSubmittedForm();
                    this.recalculateTable();
                }
            }, 
            deep: true
        },
        editingPercent: {
            handler(newValue){
                if(newValue != null && this.editingField === 'percent'){
                    this.editingAmount = this.getAmount(newValue);
                }
            }
        },
        editingAmount: {
            handler(newValue){
                if(newValue != null && this.editingField === 'amount'){
                    this.editingPercent = this.getPercentage(newValue);
                }
            }
        }
    }
}
</script>