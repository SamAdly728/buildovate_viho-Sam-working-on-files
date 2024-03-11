import { defineStore } from 'pinia';

export const useScheduleAppointmentModal = defineStore('schedule-appointment', {
    state: () => ({
        isModalOpen: false,
        users: [],
        selectedLead: [],
        userOptions: [],
        type: 'add',
    }),
    actions: {
        toggleModal() {
            this.isModalOpen = !this.isModalOpen;
        },
        closeModal() {
            this.isModalOpen = false;
        },
        setUsers(users) {
            this.selectedLead = users;
        },
        setSelected(selectedLead) {
            this.selectedLead = selectedLead;
        },
        setType(type) {
            this.type = type;
        },
        setUserOptions(options) {
            this.userOptions = options;
        },
    }
});