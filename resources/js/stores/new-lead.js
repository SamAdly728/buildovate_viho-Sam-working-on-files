import { defineStore } from 'pinia';

export const useNewLeadSidebar = defineStore('new-lead', {
    state: () => ({
        isOpen: false,
        formType: "lead",
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