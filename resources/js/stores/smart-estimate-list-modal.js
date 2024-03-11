import { defineStore } from 'pinia';

export const useSmartEstimateListModal = defineStore('smart-estimate-list-modal', {
  state: () => ({
    isModalOpen: false,
    selectedEstimates: [],
  }),
  actions: {
    toggleModal() {
      this.isModalOpen = !this.isModalOpen;
    },
    setSelectedEstimates(selectedItems){
        this.selectedEstimates = selectedItems;
    }
  }
});