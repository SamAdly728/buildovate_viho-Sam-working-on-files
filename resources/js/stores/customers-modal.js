import { defineStore } from 'pinia';

export const useCustomersModal = defineStore('customers-modal', {
  state: () => ({
    isModalOpen: false,
    customers: [],
    selectedCustomers: [],
    selected: null,
    type: 'view',
  }),
  actions: {
    toggleModal() {
      this.isModalOpen = !this.isModalOpen;
    },
    closeModal() {
        this.isModalOpen = false;
    },
    setCustomers(customers){
        this.customers = customers;
    },
    setType(type){
        this.type = type;
    },
    setSelectedCustomers(selectedCustomers){
        this.selectedCustomers = selectedCustomers;
    },
    setSelected(selected){
      this.selected = selected;
    }
  }
});