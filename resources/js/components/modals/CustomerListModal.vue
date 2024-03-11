<template>
  <div class="modal fade" id="customerListModal" tabindex="-1" role="dialog" aria-labelledby="customerListModal" aria-hidden="true" style="overflow: hidden">
    <div class="modal-dialog" :class="{'modal-md': store.type === 'view', 'modal-lg': store.type !== 'view'}" role="document">
      <div class="modal-content" style="max-height: 92vh !important; overflow: hidden;">
        <div class="modal-body p-0 m-0">
          <div class="card mb-0">
            <div class="card-header d-flex justify-content-between" v-if="store.type === 'select'">
              <h5>Select Customer</h5><span class="f-14 pull-right mt-0">{{ list.length }} Customer</span>
            </div>
            <div class="card-header d-flex justify-content-between" v-else-if="store.type === 'top-view'">
              <h5>Customer Contacts</h5><span class="f-14 pull-right mt-0 cursor-pointer text-primary">Manange Customer</span>
            </div>
            <div class="card-header d-flex justify-content-between" v-else>
              <h5>Customer Details</h5>
              <button class="btn-close" type="button"  data-bs-dismiss="modal" aria-label="Close" id="customerListModalButton" @click="store.closeModal()"></button>
            </div>
            <div class="card-body p-0" style="overflow: hidden;">     
              <div class="m-0 p-0 row b-l-light " v-if="loading">
                <div class="col-md-12 d-flex flex-column align-items-center justify-content-center b-l-light " style="height: 100%; margin-top: 50px;">
                  <div style="height: 40px;">
                    <LoadingStyleMetric></LoadingStyleMetric>
                  </div>
                  <a class="f-w-600 mt-1 mb-5">Retreiving customer details ...</a>
                </div>
              </div>
              
              <div class="row m-0 p-0" id="addcon" style="overflow: hidden !important;" v-else>
                <div class="col-md-4 m-0 p-0" v-if="store.type !== 'view'" style="overflow: hidden !important;">
                  <input class="p-3 b-light w-100" type="text" placeholder="Search by name.." @change="handleSearch">
                  <div class="b-t-light contact-list slim-scroll-gray" 
                      :style="{
                        'overflow-y': 'auto !important',
                        'max-height': store.type === 'select' ? 'calc(92vh - (88.6px + 54.78px + 95.67px))' : 'calc(92vh - (88.6px + 54.78px))'
                      }">

                      <template v-for="item in filteredList">
                        <div class="p-3 d-flex align-items-center cursor-pointer bg-hover-primary b-b-light gap-2" @click="handleSelected(item)">
                          <span class="mr-3  rounded-circle text-center text-white circle_image_primary">
                            {{ item.display_name ? item.display_name.substring(0, 2).toUpperCase() : 'AA' }}
                          </span>
                          <div class="d-flex flex-column gap-0" style="overflow: hidden;">
                            <h6 class="f-16 m-0 truncate">{{ item.display_name ? item.display_name : 'N/A' }}</h6>
                            <small class="truncate">{{ item.email ? item.email : 'N/A' }}</small>
                          </div>
                        </div>
                      </template>

                  </div>
                </div>

                <div class="m-0 p-0" :class="store.type !== 'view' ? 'col-md-8' : 'col-md-12'">
                  <div class="b-t-light b-l-light p-5 pt-4">
                    <div class="media align-items-center">
                      <span class="avatar-circle img-100 m-r-20 img-fluid m-r-20 rounded-circle text-center text-white circle_image_primary_100">
                        {{ selected && selected.display_name ? selected.display_name.substring(0, 2).toUpperCase() : 'AA' }}
                      </span>

                      <input class="updateimg" type="file" name="img" onchange="readURL(this,0)">
                      <div class="media-body mt-0">
                        <h5 class="m-0 p-0 f-18 f-w-600">{{ selected && selected.display_name ? selected.display_name : 'N/A' }}</h5>
                        <p class="f-14 text-muted f-w-600">{{ selected && selected.email ? selected.email : 'N/A' }}</p>
                        <ul class="d-flex gap-3 m-0 p-0">
                          <li><a href="javascript:void(0)" @click="editContact">Edit</a></li>
                          <li><a href="javascript:void(0)" @click="deleteContact">Delete</a></li>
                          <li><a href="javascript:void(0)" @click="viewContact">View Profile</a></li>
                          </ul>
                      </div>
                    </div>
                      
                    <div class="mt-4 d-flex flex-column gap-4">
                      <h6 class="m-0">General</h6>
                      <ul class="d-flex flex-column gap-2">
                        <li class="f-w-600 text-muted row m-0 p-0"><span class="col-md-5 m-0 p-0">First Name: </span><span class="f-w-600 text-dark col-md-7 m-0 p-0">{{ selected && selected.first_name ? selected.first_name : 'N/A' }}</span></li>
                        <li class="f-w-600 text-muted d-flex"><span class="col-md-5 m-0 p-0">Last Name: </span><span class="f-w-600 text-dark col-md-7 m-0 p-0">{{ selected && selected.last_name ? selected.last_name : 'N/A' }}</span></li>
                        <li class="f-w-600 text-muted d-flex"><span class="col-md-5 m-0 p-0">Created On: </span><span class="f-w-600 text-dark col-md-7 m-0 p-0">{{ selected && selected.created_on ? formatDate(selected.created_on) : 'N/A' }}</span></li>
                        <li class="f-w-600 text-muted d-flex"><span class="col-md-5 m-0 p-0">Company: </span><span class="f-w-600 text-dark col-md-7 m-0 p-0">{{ selected && selected.company ? selected.company : 'N/A' }}</span></li>
                        <li class="f-w-600 text-muted d-flex"><span class="col-md-5 m-0 p-0">Address: </span><span class="f-w-600 text-dark  col-md-7 m-0 p-0">
                          {{ selected && selected.street_address ? selected.street_address : '' }} {{ selected && selected.city ? selected.city : '' }} {{ selected && selected.state ? selected.state : '' }} {{ selected && selected.zip_code ? selected.zip_code : '' }}
                        </span></li>
                        <li class="f-w-600 text-muted d-flex"><span class="col-md-5 m-0 p-0">Contact Number: </span><span class="f-w-600 text-dark col-md-7 m-0 p-0">{{ selected && selected.phone ? formatPhoneNumber(selected.phone) : 'N/A' }}</span></li>
                        <li class="f-w-600 text-muted d-flex"><span class="col-md-5 m-0 p-0">Email Address: </span><span class="f-w-600 text-dark col-md-7 m-0 p-0">{{ selected && selected.email ? selected.email : 'N/A' }}</span></li>
                        <li class="f-w-600 text-muted d-flex"><span class="col-md-5 m-0 p-0">Other Contact: </span><span class="f-w-600 text-dark col-md-7 m-0 p-0">{{ selected && selected.cell_phone ? formatPhoneNumber(selected.cell_phone) : 'N/A' }}</span></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
                
              <div class="card-footer b-t-light  d-flex justify-content-between" v-if="store.type === 'select' && !loading && selected && selected.cust_id">
                <button class="btn btn-light mr-2"  data-bs-dismiss="modal"  @close="store.closeModal()">Close</button>
                <button class="btn btn-primary-v2"  data-bs-dismiss="modal"  @click="handleSelectedCustomer">SELECT</button>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useCustomersModal } from '../../stores/customers-modal';
import { usePage } from "@inertiajs/vue3";
import Swal from 'sweetalert2';
import LoadingStyleMetric from '../LoadingStyleMetric.vue';
import axios from 'axios';

export default {
  components: { LoadingStyleMetric },
  setup(){
    const page = usePage();
    const store = useCustomersModal()
    return { page, store }
  },
  data(){
    const searchQuery = '';
    const selected = null;
    const list = [];
    const loading = false;

    return {
      searchQuery,
      selected,
      list,
      loading
    }
  },
  computed: {
    filteredList() {
      return this.list.filter(item => 
        item.display_name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
    isModalOpen() {
      return this.store.isModalOpen;
    },
    selectedCustomers() {
      return this.store.selectedCustomers
    }
  },
  methods: {
    handleSearch(event) {
      this.searchQuery = event.target.value;
    },
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
    handleSelectedCustomer() {
      this.store.setSelected(this.selected);
      this.store.closeModal();
    },
    handleSelected(value) {
      this.selected = value;
    },
    editContact(){
      Swal.fire({
        icon: 'info',
        title: 'Coming soon!',
        text: 'Edit customer through this modal is coming soon ;)',
      });
    },
    deleteContact(){
      Swal.fire({
        icon: 'info',
        title: 'Coming soon!',
        text: 'Delete customer through this modal is coming soon ;)',
      });
    },
    viewContact(){
      Swal.fire({
        icon: 'info',
        title: 'Coming soon!',
        text: 'View customer through this modal is coming soon ;)',
      });
    },
    async fetchCustomers() {
      try {
        this.loading = true;
        const response = await axios.get('/api/userContacts', {
          params: {
            'type': 'customer'
          },
          headers: {
            'Authorization': 'Bearer ' + this.page.props.csrf_token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        const data = response.data;

        this.store.setCustomers(data.data);
        this.list = Object.values(data.data).filter(userDetails => userDetails.cust_id);

        this.loading = false;
      } catch (error) {
        console.error("Error fetching customers: ", error);
      }
    },
    updateModalVisibility() {
      const modalElement = document.getElementById('customerListModal');
      const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});

      if (this.store.isModalOpen) {
        if(this.store.customers.length === 0 && this.store.type !== 'view'){
          this.fetchCustomers();
        }
        modalInstance.show();
      } else { 
        $(".modal-backdrop").hide();
      }
    }
  },
  watch: {
    isModalOpen: {
      handler() {
        this.updateModalVisibility();
      }
    },
    selectedCustomers: {
      handler(value) {
        if(value){
          this.selected = value;
        }
      }
    }
  }

}
</script>