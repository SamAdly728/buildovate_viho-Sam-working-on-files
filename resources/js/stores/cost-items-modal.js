import { defineStore } from 'pinia';

export const useCostItemsModal = defineStore('cost-items-modal', {
  state: () => ({
    isModalOpen: false,
    selectedItems: [],
  }),
  actions: {
    toggleModal() {
      this.isModalOpen = !this.isModalOpen;
    },
    closeModal() {
        this.isModalOpen = false;
    },
    setSelectedItems(selectedItems){
        this.selectedItems = selectedItems;
    }
  }
});