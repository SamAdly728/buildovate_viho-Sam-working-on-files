import { defineStore } from 'pinia';

export const usePaymentRequest = defineStore('payment-request', {
  state: () => ({
    isModalOpen: false,
    form: {
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
    },
    options: {
        include_deposit: true,
        include_startup: true,
        include_completion: true
    },
    submitForm: null
  }),
  actions: {
      toggleModal() {
        this.isModalOpen = !this.isModalOpen;
      },
      closeModal() {
          this.isModalOpen = false;
      },
      setForm(form){
        this.form = form;
      },
      setSubmittedForm(form){
        this.submitForm = form;
      },
      clearSubmittedForm(){
        this.submitForm = null;
      },
      setDepositType(type){
        this.form.deposit_type = type;
        if(type === 'amount'){
            this.form.percentage = 0;
        }
      },
      setDeposit(deposit){
        this.form.deposit = deposit;
      },
      setStage(stage){
        this.form.stages = stage;
      },
      setStagePayments(stage_payments){
        this.form.stage_payments = stage_payments;
      },
      setIncludeDeposit(value){
        this.options.include_deposit = value;
        this.form.request_deposit = value;
      },
      setIncludeStartUp(value){
        this.options.include_startup = value;
      },
      setIncludeCompletion(value){
        this.options.include_completion = value;
      }
   }
   
});