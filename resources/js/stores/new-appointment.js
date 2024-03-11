import { defineStore } from 'pinia';

export const useNewAppointmentSidebar = defineStore('new-appointment', {
    state: () => ({
        isOpen: false,
        formType: "On-Site Estimate", // On-Site Estimate, Site Visit, Project Walkthrough, Scope Clarification, Quality Control, Payment Collection
    }),
    actions: {
        open() {
            this.isOpen = true;
        },
        close() {
            this.isOpen = false;
        },
        setFormType(newValue){
            this.formType = newValue;
        }
    }
});