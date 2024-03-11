import { defineStore } from 'pinia';

export const useSideBar = defineStore('sidebar', {
  state: () => ({
    isOpen: true,
    disabled: false,
    component: 'default',
    selectedJobsites: [],
    proposals: null, //Proposal Side
    leads: null, //Proposal Side
    selectedLead: null, //Proposal Side
    selectedProposal: null, //Proposal Side
    selectEstimate: null //Proposal Side
  }),
  actions: {
    toggle() {
      this.isOpen = !this.isOpen;
    },
    close() {
        this.isOpen = false;
    },
    open() {
        this.isOpen = true;
    },
    setDisabled(disabled){
      this.disabled = disabled;
    },
    setComponent(name){
      this.component = name;
    },
    setSelectedJobsite(jobsites){
      if(jobsites.length === 1 && this.selectedJobsites.length === 1){
        if(this.selectedJobsites[0].jobsite_id === jobsites[0].jobsite_id){
          this.selectedJobsites = [];
        }else{
          this.selectedJobsites = jobsites;
        }
      }else{
        this.selectedJobsites = jobsites;
      }
    },
    setProposals(proposals){
      this.proposals = proposals;
    },
    setLeads(leads){
      this.leads = leads;
    },
    setSelectedProposal(proposal){
      this.selectedProposal = proposal;
    },
    setSelectedLead(lead){
      this.selectedLead = lead;
    },
    setSelectedEstimate(estimate){
      this.selectEstimate = estimate;
    }
  }
});