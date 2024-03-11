import { defineStore } from 'pinia';

export const useStagePayment = defineStore('stage-payment', {
  state: () => ({
    isModalOpen: false,
    clientPrice: 0.0,
    form: {
        proposal_billing_stage_id: 0,
        proposal_billing_id: 0,
        stage_name: '',
        stage_number: 1,
        stage_amount: 0.0,
        update_index: -1,
        update_stage: 0,
        locked: false
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
      toggleLock(){
        this.form.locked = !this.form.locked;
      }
   }
});