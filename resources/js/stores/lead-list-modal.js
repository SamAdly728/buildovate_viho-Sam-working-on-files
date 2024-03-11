import { defineStore } from 'pinia';

export const useLeadsModal = defineStore('lead-list-modal', {
  state: () => ({
    isModalOpen: false,
    selectedLead: null
  }),
  actions: {
      toggleModal() {
        this.isModalOpen = !this.isModalOpen;
      },
      closeModal() {
        this.type = null;
        this.isModalOpen = false;
      },
      setSelected(lead) {
        this.selectedLead = lead;
      }
   }
});