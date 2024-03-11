import { defineStore } from 'pinia';

export const useProposalListModal = defineStore('proposal-list-modal', {
  state: () => ({
    isModalOpen: false,
    selectedProposals: [],
    options: {},
    proposals: []
  }),
  actions: {
    toggleModal() {
      this.isModalOpen = !this.isModalOpen;
    },
    setSelectedProposals(selected_proposals){
        this.selectedProposals = selected_proposals;
    },
    setProposals(proposals){
        this.proposals = proposals;
    },
    setOptions(options){
        this.options = options;
    }
  }
});
