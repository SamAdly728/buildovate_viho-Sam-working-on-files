<template>
  <div class="modal fade" id="add-appointment" tabindex="-1" role="dialog" aria-labelledby="add-appointment" aria-hidden="true" style="overflow: hidden">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title d-flex justify-content-start text-center">
                <h5 class="text-muted">Schedule Appointment</h5>
            </div>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" @click="store.closeModal()"></button>
          </div>
          
          <div class="modal-body">
          <div class="row">
            <div class="col">
              <div class="row g-3" id="body-content">
                  <div class="col-md-12 mt-0">
                      <h5>LEAD</h5>
                  </div>

                  <div class="col-md-1 text-center">
                    <i class="fa fa-pencil-square-o fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <input id="title" type="text" class="form-control" placeholder="Title" name="appointment-title" v-model="formData.title">
                  </div>
                  
                  <div class="col-md-1 text-center">
                    <i class="fa fa-clock-o fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <input class="form-control digits" data-language="en" id="meetingDate" type="text" placeholder="Meeting Date" name="appointment-start-day" readonly>
                  </div>

                  <div class="col-md-1 text-center">
                    <i class="fa fa-location-arrow fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <!--                    <input id="streetAddress" type="text" class="form-control" placeholder="Street Address" name="appointment-location">-->
                    <VueGoogleAutocomplete
                        id="street_address_new_appointment"
                        name="street_address_new_appointment"
                        classname="form-control"
                        placeholder="Street Address"
                        @input="newAppointmentAddress"
                        v-on:placechanged="getAddressDataForNewAppointment"
                        :country="['us']"
                        :type="['address']">
                    </VueGoogleAutocomplete>
                  </div>

                  
                  <div class="col-md-1"></div>
                  <div class="col-md-4">
                    <input id="city" type="text" class="form-control" placeholder="City" v-model="formData.city">
                  </div>
                  <div class="col-md-4">
                    <input id="state" type="text" class="form-control" placeholder="State" v-model="formData.state">
                  </div>
                  <div class="col-md-3">
                    <input id="zipcode" type="number" class="form-control" placeholder="Zip Code" v-model="formData.zipcode">
                  </div>

                  <div class="col-md-1 text-center">
                    <i class="fa fa-user fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <VueMultiselect
                        placeholder="Select a user..."
                        label="display_name"
                        track-by="user_id"
                        id="assignedToUser"
                        :searchable="true"
                        :close-on-select="true"
                        v-model="formData.assignedToUser"
                        @select="getAssignedToId"
                        :options="store.userOptions">
                    </VueMultiselect>
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="fa fa-users fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <select class="" name="" id="appointment_guests" multiple="multiple" title="Include email addresses, separated by commas(,) to send to your guests that are outside your platform."></select>
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="fa fa-clipboard fa-lg" style="opacity: 0.5; margin-top: 5px"></i>
                  </div>
                  <div class="col-md-11">
                    <textarea class="form-control" name="appointment-note" id="description" rows="5" placeholder="Description" v-model="formData.description"></textarea>
                  </div>
              </div>

            </div>

            <div class="col">
              <div class="col-md-12">
                <div class="card mb-3 rounded-2">
                  <div class="card-body justify-content-between align-middle d-flex">
                    <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test"
                       data-bs-target="#email-and-sms-preview">Preview</p>
                    <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test"
                       data-bs-target="#edit-sms-email">Edit</p>
                    <p class="btn btn-danger btn-xs mt-1" style="cursor: context-menu">SMS</p>
                    <div class="media">
                      <div class="media-body text-end icon-state switch-outline">
                        <label class="switch">
                          <input type="checkbox" checked="">
                          <span class="switch-state"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card mb-3 rounded-2">
                  <div class="card-body justify-content-between d-flex">
                    <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test"
                       data-bs-target="#email-and-sms-preview">Preview</p>
                    <p class="btn btn-secondary btn-xs mt-1" data-bs-toggle="modal" data-original-title="test"
                       data-bs-target="#edit-sms-email">Edit</p>
                    <p class="btn btn-danger btn-xs mt-1" style="cursor: context-menu">Email</p>
                    <div class="media">
                      <div class="media-body text-end icon-state switch-outline">
                        <label class="switch">
                          <input type="checkbox" checked="">
                          <span class="switch-state"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <label for="custom-file-upload" class="w-100" id="file-upload-label" style="display: inline">
                <div class="card mb-0 custom-dropzone rounded" id="custom-dropzone">
                  <div class="card-body">
                    <input type="file" id="custom-file-upload" hidden multiple="multiple" @change="handleFileUpload">
                    <img id="upload-image" :src="uploadIcon" alt=""
                         style="display: block; margin-left: auto; margin-right: auto">
                  </div>
                </div>
              </label>
              <div id="image-container">
              </div>
              <!-- <button class="btn btn-primary w-100 mt-5">Create</button> -->
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" @click="closeModal">Close</button> -->
          <button type="button" class="btn btn-primary w-100 mt-5" @click="saveAppointment">Create</button>
        </div>
    </div>
</div>
</div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { useScheduleAppointmentModal } from '../../stores/schedule-appointment';
import VueMultiselect from 'vue-multiselect';
import VueGoogleAutocomplete from "vue-google-autocomplete";
import { toast } from 'vue3-toastify';

export default{
components: {
    VueMultiselect,
    VueGoogleAutocomplete,
},
setup(){
  const store = useScheduleAppointmentModal();
  
  return { store }
},
data(){
  const formData = {
      appointment_id: '',
      jobsite: '',
      leadId: '',
      lead: '',
      title: '',
      startDate: '',
      endDate: '',
      streetAddress: '',
      city: '',
      state: '',
      zipcode: '',
      assignedToUser: '',
      assignedToUserId: '',
      guest: '',
      description: '',
      fileName: '',
      reminder_sms: false,
      reminder_email: true,
      entityType: 'leads',
      entityId: 0,
      file: []
    };
    
    const uploadIcon = window.location.origin + '/assets/images/upload-100.png';
    const deleteIcon = window.location.origin + '/assets/images/delete.png';

  return { 
    formData, 
    uploadIcon,
    deleteIcon
  }
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
    const modalElement = document.getElementById('add-appointment');
    const modalInstance = new bootstrap.Modal(modalElement, {backdrop: 'static', keyboard: false});
    if (this.store.isModalOpen) {
      if(this.store.selectedLead.length != 0){
        // this.selectedLead = this.store.selectedLead;

        this.formData.entityId = this.store.selectedLead.lead_id;
        this.formData.title = this.store.selectedLead.opportunity_title;
        this.formData.streetAddress = this.store.selectedLead.street_address;
        $('#street_address_new_appointment').val(this.store.selectedLead.street_address);

        this.formData.city = this.store.selectedLead.city;
        this.formData.state = this.store.selectedLead.state;
        this.formData.zipcode = this.store.selectedLead.zipcode;

        this.formData.assignedToUserId = this.store.selectedLead.created_by;
        this.formData.assignedToUser = this.store.userOptions.find(item => item.user_id === this.store.selectedLead.created_by)
      }
      modalInstance.show();
    } else { 
      $(".modal-backdrop").hide();
      document.querySelector(`#add-appointment .btn-close`).click();
    }
  },
  newAppointmentAddress(event) {
    this.formData.streetAddress = event.target.value
    $('#street_address_new_appointment').val(event.target.value);
  },
  getAddressDataForNewAppointment: function(addressData, placeResultData, id) {
    const placeAddress = placeResultData.address_components
    let streetAddress = ''
    for (const component of placeAddress) {
      const componentType = component.types[0]
      switch (componentType) {
        case "street_number":
          streetAddress = component.long_name;
          break;
        case "route":
          streetAddress += ' ' + component.long_name;
          break;
        case "postal_code":
          if (id === "street_address_new_appointment")
            this.formData.zipcode = component.long_name;
          else
            this.formData.zipcode = component.long_name;
          break;
        case "administrative_area_level_1":
          if (id === "street_address_new_appointment")
            this.formData.state = component.long_name;
          else
            this.formData.state =  component.long_name
          break;
        case "administrative_area_level_2":
          if (id === "street_address_new_appointment")
            this.formData.state = component.long_name;
          else
            this.formData.state =  component.long_name
          break;
        case "neighborhood":
          if (id === "street_address_new_appointment")
            this.formData.city = component.long_name;
          else
            this.formData.city = component.long_name
          break;
      }
    }

    if(streetAddress){
      if (id === "street_address_new_appointment"){
        $('#street_address_new_appointment').val(streetAddress);
        this.formData.streetAddress = streetAddress;
      }
    }
  },
  async saveAppointment() {

    // console.log("Save Appointment...");

    // console.log(this.formData);

    var picker = $('#meetingDate').data('daterangepicker');
    this.formData.startDate = picker.startDate.format('YYYY-MM-DD  h:mm A');
    this.formData.endDate = picker.endDate.format('YYYY-MM-DD  h:mm A');

    this.formData.guest = $('#appointment_guests').val().join(', ')
    const form = new FormData()
    form.append('file[]', this.formData.file)
    try {
      //let errorCount = this.validateRequiredFields(this.formData, ['description','zipcode', 'state', 'city', 'streetAddress', 'meetingDate', 'jobsite', 'leadId', 'lead', 'guest', 'fileName', 'file'])
      let errorCount = 0;
      if(errorCount > 0) {
        if(errorCount === 1) {
          toast.error('Field is required!')
        } else {
          toast.error('Fields are required!')
        }
      } else {
        await axios.post('/calendar/save-appointment', this.formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        }).then((response) => {
          if (response.status == 201 || response.status == 200) {
            $('#add-appointment').modal('hide')
            toast.success('Appointment Added!')
            location.reload()
          }
        })
            .catch((error) => {
              console.log(error)
            })
      }
    } catch (error) {
      console.log(error)
    }

  },
  getAssignedToId: function(info) {
    this.formData.assignedToUserId = info.user_id
  },
},
computed: {
  isModalOpen() {
    return this.store.isModalOpen;
  },
  selectedLead(){
    return this.store.selectedLead;
  },
},
watch: {
  isModalOpen: {
    handler() {
      this.updateModalVisibility();
    }
  },
},
mounted() {
  let selfie = this
  $('#meetingDate').daterangepicker({
    language: "en",
    autoClose: true,
    timePicker: true,
    timePickerIncrement: 30,
    locale: {
      format: 'MM/DD/YYYY h:mm A'
    }
  }, function(start, end, label) {
    console.log("Selected range: " + start.format('MM/DD/YYYY h:mm A') + ' - ' + end.format('MM/DD/YYYY h:mm A'));
    selfie.formData.startDate =start.format('MM/DD/YYYY h:mm A');
    selfie.formData.endDate = end.format('MM/DD/YYYY h:mm A');
  });

  $('#appointment_guests').select2({
    tags: true,
    tokenSeparators: [','],
    createTag: function(params) {
      let term = $.trim(params.term);

      if (term === '') {
        return null;
      }

      return {
        id: term,
        text: term
      };
    }
  });

}
}

</script>

<style>
.daterangepicker {
z-index: 1100 !important;
}
</style>