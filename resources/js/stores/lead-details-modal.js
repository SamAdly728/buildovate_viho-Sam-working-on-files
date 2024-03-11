import { defineStore } from 'pinia';

export const useLeadDetails = defineStore('lead-details-modal', {
  state: () => ({
    isModalOpen: false,
    lead: null,
  }),
  actions: {
    toggleModal() {
      this.isModalOpen = !this.isModalOpen;
    },
    closeModal() {
        this.isModalOpen = false;
    },
    setSelected(lead){
      this.lead = lead;
    }
  }
});