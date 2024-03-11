import { defineStore } from 'pinia';

export const useCostItemModal = defineStore('cost-item-modal', {
  state: () => ({
    isModalOpen: false,
    selectedItem: null,
    updatedItem: null,
    itemObject: null,
    type: null, //object: return object of cost-item, database: process the actual save/update
  }),
  actions: {
      toggleModal() {
        this.isModalOpen = !this.isModalOpen;
        this.type = !this.isModalOpen ? null : this.type;
      },
      closeModal() {
          this.type = null;
          this.isModalOpen = false;
      },
      setSelectedItem(item) {
          this.selectedItem = item;
      },
      setType(type) {
          this.type = type;
      },
      setUpdateItem(item){
        this.updatedItem = item;
      },
      setSubmitedItem(item){
        this.itemObject = item;
      }
   }
});