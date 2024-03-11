import { defineStore } from 'pinia';

export const useTransactionSidebar = defineStore('plaid-transaction', {
  state: () => ({
    isOpen: false
  }),
  actions: {
      open() {
        this.isOpen = true;
      },
      close() {
        this.isOpen = false;
      }
   }
});