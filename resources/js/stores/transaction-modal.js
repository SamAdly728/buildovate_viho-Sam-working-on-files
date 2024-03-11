import { defineStore } from 'pinia';

export const useTransactionModal = defineStore('transaction-modal', {
  state: () => ({
    isModalOpen: false
  }),
  actions: {
      toggleModal() {
        this.isModalOpen = !this.isModalOpen;
      },
      closeModal() {
          this.type = null;
          this.isModalOpen = false;
      }
   }
});