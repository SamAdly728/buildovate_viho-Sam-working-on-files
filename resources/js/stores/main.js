import { defineStore } from "pinia";
import { getPros } from "@/api/api";

export const useMainStore = defineStore("main", {
  state: () => ({
    message: "",
    isOpenRighPanel: false,
    prosList: [],
    selectedPro: null,
    searchQuery:
      {
        search: "",
        specialties: "",
      } | null,
    isMinimize: false,
    isMaximize: false,
  }),
  getters: {
    getMessage: (state) => state.message,
  },
  actions: {
    setMessage(message) {
      this.message = message;
    },
    setRightPanel(isOpen) {
      this.isOpenRighPanel = isOpen;
    },
    minimizeProfile(mode) {
      this.isMinimize = mode;
    },
    maximizeProfile(mode) {
      this.isMaximize = mode;
      // this.minimizeProfile(false);
    },
    setSearchQuery(search) {
      this.searchQuery = search;
    },

    async getPros() {
      const response = await getPros(this.searchQuery);
      if (response && response.status == "success") {
        this.prosList = response.data;
      }
    },
    setSelectedPro(item) {
      this.selectedPro = item;
    },
  },
});
