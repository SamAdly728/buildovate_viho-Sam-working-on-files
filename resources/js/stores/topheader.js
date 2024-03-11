import { defineStore } from 'pinia';

export const useTopHeader = defineStore('topheader', {
  state: () => ({
    selectedMenu: null,
  }),
  actions: {
    setSelectedMenu(menu) {
      this.selectedMenu = menu;
    }
  }
});