import { defineStore } from 'pinia';

export const useSmartEstimateModal = defineStore('smart-estimate-modal', {
  state: () => ({
    isModalOpen: false,
    estimated_id: 0,
    selectedItems: [],
  }),
  actions: {
    toggleModal() {
      this.isModalOpen = !this.isModalOpen;
    }
  }
});
