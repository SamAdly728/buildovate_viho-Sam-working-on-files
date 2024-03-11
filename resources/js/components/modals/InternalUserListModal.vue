<template>
    <div class="modal fade" id="salespeopleModal" tabindex="-1" role="dialog" aria-labelledby="salespeopleModal" aria-hidden="true" style="overflow: hidden">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-body p-0 m-0">
                <div class="card mb-0">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ store.selectedUsers.length == 1 ? 'Salesperson' : 'Salespeople' }}</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" @click="store.closeModal()"></button>
                    </div>
                    <div class="card-body p-0" style="overflow: hidden;">
                      <div class="row list-persons m-0 p-0" id="addcon">
                        <div class="col-md-4  m-0 p-0" v-if="store.selectedUsers.length != 1">
                          <div class="customer-list b-t-light">
                            <template v-for="item in store.selectedUsers">
                              <div class="p-3 d-flex gap-3 align-items-center bg-hover-primary b-b-light" style="cursor: pointer;" @click="handleSelected(item)">
                                <span class="mr-3 rounded-circle text-center text-white circle_image_primary">
                                  {{ item.display_name ? item.display_name.substring(0, 2).toUpperCase() : 'AA' }}
                                </span>
                                <div class="d-flex flex-column gap-0" style="overflow: hidden;">
                                  <h6 class="f-16 m-0 truncate">{{ item.display_name ? item.display_name : 'N/A' }}</h6>
                                  <small>{{ item.email ? item.email : 'N/A' }}</small>
                                </div>
                              </div>
                            </template>
                          </div>
                        </div>

                        <div class="m-0 p-0" :class="store.selectedUsers.length != 1 ? 'col-md-8' : 'col-md-12'">
                          <div class="profile-mail b-t-light b-l-light p-5 pt-4">
                            <div class="d-flex align-items-center">
                              <!-- <img class="img-100 img-fluid m-r-20 rounded-circle update_img_0" src="../../assets/test-images/user/4.jpg" alt=""  style="border: 5px solid #24694c;"> -->
                              <span class="avatar-circle img-100 m-r-20 img-fluid m-r-20 rounded-circle text-center text-white circle_image_primary_100">
                                  {{ selected && selected.display_name ? selected.display_name.substring(0, 2).toUpperCase() : 'AA' }}
                              </span>

                              <input class="updateimg" type="file" name="img" onchange="readURL(this,0)">
                              <div>
                                <h5 class="f-w-700 text-dark m-0 p-0">{{ selected && selected.display_name ? selected.display_name : 'N/A' }}</h5>
                                <p class="f-18 f-w-600 text-muted">{{ selected && selected.email ? selected.email : 'N/A' }}</p>
                                <ul class="d-flex gap-3">
                                  <li class="f-14 text-primary f-w-600" style="cursor: pointer;"><a @click="messageUser">Message</a></li>
                                  <li class="f-14 text-primary f-w-600" style="cursor: pointer;"><a @click="emailUser">Email</a></li>
                                  <li class="f-14 text-primary f-w-600" style="cursor: pointer;"><a @click="vieweUserTasks">View Tasks</a></li>
                                </ul>
                              </div>
                          </div>
                          <div class="email-general">
                            <h6 class="mb-3">General</h6>
                            <ul>
                              <li>First Name <span class="text-primary f-w-600">{{ selected && selected.first_name ? selected.first_name : 'N/A' }}</span></li>
                              <li>Last Name <span class="text-primary f-w-600">{{ selected && selected.last_name ? selected.last_name : 'N/A' }}</span></li>
                              <li>Created On<span class="text-primary f-w-600">{{ selected && selected.created_on ? formatDate(selected.created_on) : 'N/A' }}</span></li>
                              <li>Contact Number<span class="text-primary f-w-600">{{ selected && selected.phone ? formatPhoneNumber(selected.phone) : 'N/A' }}</span></li>
                              <li>Email Address <span class="text-primary f-w-600">{{ selected && selected.email ? selected.email : 'N/A' }}</span></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
      </div>
  </div>
</div>
</template>

<script>
import Swal from 'sweetalert2';
import { useUsersModal } from '../../stores/users-modal';

export default{
  setup(){
    const store = useUsersModal();
    
    return { store }
  },
  data(){
    const selected = null;

    return { selected }
  },
  methods: {
    formatDate(date){
      if(date){
      const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
      
      const d = new Date(date);
      const monthName = months[d.getMonth()];
      const day = d.getDate();
      const year = d.getFullYear();
      
        return `${monthName} ${day}, ${year}`;
      }else{
        return 'INVALID DATE';
      }
    },
    formatPhoneNumber(number) {
      const cleaned = ('' + number).replace(/\D/g, '');
      const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
      if (match) {
          return '(' + match[1] + ') ' + match[2] + '-' + match[3];
      }
      return number;
    },
    handleSelected(value) {
      this.selected = value;
    },
    messageUser() {
      Swal.fire({
          icon: 'info',
          title: 'Coming soon!',
          text: 'Send message to this user through this modal is coming soon ;)',
      });
    },
    emailUser() {
        Swal.fire({
            icon: 'info',
            title: 'Coming soon!',
            text: 'Send email to this user through this modal is coming soon ;)',
        });
    },
    vieweUserTasks() {
        Swal.fire({
            icon: 'info',
            title: 'Coming soon!',
            text: 'View users pending task through this modal is coming soon ;)',
        });
    },
    updateModalVisibility() {
      const modalElement = document.getElementById('salespeopleModal');
      const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});

      if (this.store.isModalOpen) {
        if(this.store.selectedUsers.length != 0){
          this.selected = this.store.selectedUsers[0];
        }
        modalInstance.show();
      } else { 
        $(".modal-backdrop").hide();
        document.querySelector(`#salespeopleModal .btn-close`).click();
      }
    }
  },
  computed: {
    isModalOpen() {
      return this.store.isModalOpen;
    },
    selectedUser(){
      return this.store.selectedUsers;
    }
  },
  watch: {
    isModalOpen: {
      handler() {
        this.updateModalVisibility();
      }
    },
    selectedUser: {
      handler(newValue){
        if(newValue && newValue.length != 0){
          this.selected = newValue[0];
        }
      },
      deep: true
    }
  }
}

</script>