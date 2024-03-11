import { defineStore } from 'pinia';

export const useUsersModal = defineStore('users-modal', {
  state: () => ({
    isModalOpen: false,
    users: [],
    selectedUsers: [],
    type: 'view',
  }),
  actions: {
    toggleModal() {
      this.isModalOpen = !this.isModalOpen;
    },
    closeModal() {
        this.isModalOpen = false;
    },
    setUsers(users){
        this.selectedUsers = users;
    },
    setSelected(selectedUsers){
        this.selectedUsers = selectedUsers;
    },
    setType(type){
        this.type = type;
    },
  }
});