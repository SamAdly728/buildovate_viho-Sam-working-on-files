<style scoped>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}

/*.fc .fc-button .fc-icon {
  font-size: 1.5em !important;
  margin-top: -11px;
}*/

/*.fc .fc-button-primary {
  background-color: #1E5BB2 !important;
  border-color: #1E5BB2 !important;
}*/

.fc >>> .fc-button-primary {
  background-color: #1E5BB2 !important;
  border-color: #1E5BB2 !important;
  padding: 5px 10px !important;
  font-size: 10px !important;
  text-transform: capitalize !important;
}

.fc-event {
  cursor: pointer !important;
  background-color: #1E5BB2 !important;
  color: #ffffff;
}

.fc >>> .fc-toolbar-title {
  font-size: 18px !important;
}

.fc >>> .fc-toolbar.fc-header-toolbar {
  margin-bottom: 0px !important;
}

/*.fc-list-event:hover td{
  cursor: pointer !important;
  background-color: #24695C !important;
  color: #ffffff;
}*/

/*.fc-event-main {
  background-color: #24695C;
}*/

.fc-timegrid-slot {
  cursor: crosshair;
}

/*.fc-timegrid-slot:hover{
  background-color: #24695C ;
  opacity: 0.6;
}*/

.fc-day:hover .fc-event {
  color: white;
  background-color: #1E5BB2;
  /* //opacity: 0.6; */
}

/*.fc-day:hover {
  background-color: #24695C ;
  opacity: 0.6;
}*/
.close-right-panel:hover {
  background-color: #1E5BB2;
  color: #FFFFFF;
}

input::placeholder {
  opacity: 0.5;
}

input::placeholder {
  opacity: .5;
}

#file-upload-label:hover {
  cursor: pointer;
}

input[type="range"] {
  accent-color: #1E5BB2;
}

.multiselect__option--highlight {
  background: #1E5BB2 !important;
}

/*
.dropzone__message:before{
  content: 'test'
}
*/

#meeting-description {
  font-size: 13px !important;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.errorBorder {
  border-color: #e99aa2 !important;
  /* //box-shadow: inset 0 0 10px #e99aa2;
  //margin: 0; */
}

.select2-container--default .select2-selection--multiple {
  border: 1px solid #e6edef !important;
  color: #717171;
}

.select2-dropdown {
  border: 1px solid #e6edef !important;
}

.select2-results__message {
  color: #717171 !important;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
  border: 1px solid #e6edef !important;
}

.custom-dropzone {
  border: 2px dashed #1E5BB2 !important;
  cursor: pointer;
}

.centered-on-screen {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 9999;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.5) !important;
}

backdrop {
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.5) !important;
}

.stage-options:hover {
  background-color: #1E5BB2 !important;
}

.pac-container {
  z-index: 10000 !important;
}

.daterangepicker {
  z-index: 100000 !important;
}

/*.multiselect__tags {
  border-color: #e99aa2 !important;
}*/

.time-slot-overlay {
  width: 200px;
  height: 50px;
  cursor: pointer !important;
  position: absolute !important;
  background-color: rgba(0, 0, 0, 0) !important;
  z-index: 99999 !important;
}

.custom-alert {
  background-color: #FFFADF; /* Custom color */
  color: #856404; /* Custom text color */
}

/*.fc-toolbar-chunk {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  text-align: center !important;
}*/

.fc-button-group {
  margin-left: 80px !important;
}

.fc-button-group .fc-today-button {
  margin-top: 20px !important;
}

.fc-col-header-cell {
  position: relative !important; /* If your SVGs are absolutely positioned */
}

.custom-icon {
  position: absolute !important;
  right: 5px !important; /* Adjust as needed */
  top: 5px !important; /* Adjust as needed */
}

.climacon_component .climacon_component-stroke .climacon_component-stroke_sunSpoke .climacon_component-stroke_sunSpoke-southEast {
  fill: #FDB813 !important;
}

/* Define your custom class */
.side-custom-scrollbar::-webkit-scrollbar {
  width: 5px; /* width of the scrollbar */
}

/* Track */
.side-custom-scrollbar::-webkit-scrollbar-track {
  background: transparent; /* background color of the track */
}

/*
!* Handle *!
.side-custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.3); !* color of the scrollbar *!
  border-radius: 5px; !* border radius *!
}

!* Handle on hover *!
.side-custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: rgba(0, 0, 0, 0.5); !* color of the scrollbar on hover *!
}
*/

/* Example usage */
.content {
  height: 200px; /* just for demonstration */
  overflow-y: auto; /* enable vertical scrollbar */
  /* Add your custom scrollbar class to the container */
  scrollbar-width: thin; /* Firefox */
  scrollbar-color: rgba(0, 0, 0, 0.3) transparent; /* Firefox */
}


.flex-container {
    display: flex;
    align-items: center; /* Align items vertically */
    justify-content: space-between; /* Space between the label and the button */
  }
  
  .flex-container small {
    flex-grow: 1; /* Allows the <small> tag to take up necessary space, pushing the button to the right */
  }
  
  .form-label {
    margin: 0; /* Adjust as needed */
  }

</style>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<template>

  <div class="centered-on-screen" v-if="showLoader">
    <div class="backdrop"></div>
    <div class="d-flex flex-column align-items-center">
      <div style="height: 400px; margin-top: 15%">
        <LoadingMetric></LoadingMetric>
      </div>
    </div>
  </div>

  <div class="row m-t-10 m-r-15 m-l-5 m-b-15" style="overflow-y: hidden; overflow-x: hidden">
    <div id="full-cal-container" class="col-md-10 h-100" style="padding-right: 0px !important;">
      <div class="card vh-100">
        <!--        <div class="card-body pb-0">-->
        <!--          <div class="row">-->
        <!--            <div class="col">-->
        <!--              <userInstaller></userInstaller>-->
        <!--            </div>-->
        <!--            <div class="col">-->

        <!--            </div>-->
        <!--          </div>-->
        <!--        </div>-->
        <div class="card-body pt-2">
          <div class="d-flex flex-row-reverse mt-0">
            <i class="icofont icofont-gear h4 mt-1" style="cursor: pointer; color: #1E5BB2" data-bs-toggle="modal"
               data-original-title="test" data-bs-target="#calendar-settings"></i>
            <div class="media mb-1">
              <div class="media-body text-end switch-sm mr-1 icon-state">
                <label class="switch m-r-5">
                  <input id="schedule-offline" type="checkbox" v-model="isChecked">
                  <span id="so-color-state" class="switch-state" @mouseenter="showInfoOrNot('enter')"
                        @mouseleave="showInfoOrNot('leave')"></span>
                </label>
                <div style="position: absolute; margin-left: -100px; margin-top: -2px" v-if="showInfo">
                  <div class="bg-white easycreate-dropdown shadow-lg d-flex flex-column" style=" width: 300px">
                    <span class="text-dark f-14 f-w-600 px-3 py-2 d-flex gap-3 align-items-center">
                      <i class="icofont icofont-exclamation-circle h5" style="color: #1E5BB2"></i>
                      <div class="d-flex flex-column text-start">
                        <span class="text-muted f-12" style="font-family: Montserrat, sans-serif">Your schedule is offline and is unavailable to subs and clients. Notifications will not be sent.</span>
                      </div>
                    </span>
                  </div>
                </div>
              </div>
              <span class="col-form-label m-r-10">Schedule <span id="offline-online"></span></span>
            </div>
          </div>
          <div id="full-calendar"></div>
        </div>
      </div>
    </div>
    <div class="col-md-2 p-0 m-0">
      <div class="card vh-100 p-l-5 side-custom-scrollbar" style="overflow-y: auto !important;">
        <div class="card-body p-2" style="margin-bottom: 5rem !important">
          <!-- Google calendar -->
          <googleMap></googleMap>


          <!-- Upcoming meeting -->
          <div class="mt-4">
            <small>No Upcoming meeting</small>
          </div>
          <hr>
          <div id="select-appointment" class="alert alert-light dark p-2" role="alert">
            <span class="text-muted"><i class="icofont icofont-exclamation-circle h5" style="color: #1E5BB2"></i><small>Select an appointment to view more details.</small></span>
          </div>
          <div id="right-section">
            <div class="mt-2 row">
              <!-- <div class="col"></div>
              <div class="col-auto">
                <button id="exit-right-section" type="button" class="btn-close btn-xs" aria-label="Close"></button>
              </div> -->
              <div class="flex-container">
                <a href="#" class="form-label" >Edit</a> | <a href="#">Send</a>
                <button id="exit-right-section" type="button" class="btn-close btn-xs" aria-label="Close"></button>
              </div>
            </div>
            <div class="card-title">
              <p><span class="txt-success f-w-700" id="appointment-title"></span></p>
            </div>
            <hr>
            <div>
              <p class="m-0"><small><span class="txt-success f-w-700">Full Name: </span><span id="full-name"></span></small></p>
              <p class="m-0"><small><span class="txt-success f-w-700">Phone Number:</span> <span id="phonenumber">+123456789</span></small></p>
              <p class="m-0"><small><span class="txt-success f-w-700">E-mail:</span> <span id="email" class="text-danger">email@email.com</span></small></p>
              <p class="m-0"><small><span class="txt-success f-w-700">Meeting Date:</span> <span id="meeting-date">Nov. 7, 2023</span></small></p>
              <p class="m-0"><small><span class="txt-success f-w-700">Description:</span> <span id="meeting-description"></span></small></p>
              <p class="m-0"><small><span class="txt-success f-w-700">Address:</span> <span id="street-address"></span></small></p>
              <p class="m-0"><small><span class="txt-success f-w-700">Assigned To:</span> <span id="assignee"></span></small></p>
              <p class="m-0"><small><span class="txt-success f-w-700">Guest:</span> <span id="guest"></span></small></p>
            </div>
            <hr>
            <h6 class="card-title mt-2 txt-success">Lead Management</h6>
            <div class="flex-container mb-2">
              <small> <label class="form-label" for="">Stage:</label> </small>
              <button type="button" class="btn-xs btn-primary-v2 btn m-r-5" data-bs-toggle="modal" data-original-title="notesModals"
                      data-bs-target="#notes-modal">Note</button>
              <button type="button" class="btn-xs btn-primary-v2 btn">Edit</button>
            </div>
            <select class="form-select" v-model="leadManagement.stage" @change="handleStage">
              <option class="stage-options" value="create">Create Proposal</option>
              <option class="stage-options" value="followup">Follow Up</option>
              <option class="stage-options" value="sold">Sold</option>
              <option class="stage-options" value="pns">PNS</option>
            </select>
            <!-- <small>
              <label class="form-label" for="">Stage:</label>
              <select id="stage-options-select" class="form-select" v-model="leadManagement.stage"
                      @change="handleStage">
                <option class="stage-options" value="In Progress">In Progress</option>
                <option class="stage-options" value="Follow Up">Follow Up</option>
                <option class="stage-options" value="Sold">Sold</option>
              </select>
            </small> -->
            <p class="mb-0 mt-1 mb-1"><small>Reminder:</small></p>
            <div class="mt-0">
              <small class="">
                <label class="d-block" for="no-reminder">
                  <input class="radio_animated" id="no-reminder" type="radio" name="no-reminder" value="0"
                         v-model="withReminder" v-on:change="withReminderYesOrNo">
                  <span class="mt-0">No Reminder</span>
                </label>
              </small>
              <small class="">
                <label class="d-block" for="with-reminder">
                  <input class="radio_animated" id="with-reminder" type="radio" name="with-reminder" value="1"
                         v-model="withReminder" v-on:change="withReminderYesOrNo">
                  <span class="mt-0">Schedule a Reminder</span>
                </label>
                <Transition>
                  <div class="schedule-time-and-note" v-if="hideSchedReminder">
                    <div class="form-check">
                      <small>Title:</small>
                      <div class="input-group input-group-sm">
                        <input class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-check">
                      <small>Schedule Day time:</small>
                      <div class="input-group input-group-sm">
                        <input class="form-control" type="text" id="schedule-reminder-date-and-time">
                      </div>
                    </div>
                  </div>
                </Transition>
              </small>
            </div>
            <p class="mb-0"><small>Appointment SMS and Email reminder</small></p>
            <p class="mb-0"><small>Notes</small></p>
            <p class="mb-0"><small>Lead Added on 2023-06-10</small></p>
            <hr>
            <!--          <label for="file-upload" class="w-100" id="file-upload-label" style="display: inline">-->
            <!--            <div class="card rounded-3">-->
            <!--              <div class="card-body text-center">-->
            <!--                <i class="fa fa-cloud-upload" style="font-size: 50px; color: #24695C"></i>-->
            <!--                <input type="file" id="file-upload" hidden v-on:change="uploadFileName">-->
            <!--                <small><input class="w-100 text-center text-muted" placeholder="Upload..." type="text" v-model="fileName" readonly></small>-->
            <!--              </div>-->
            <!--            </div>-->
            <!--          </label>-->

            <button class="btn btn-primary-v2 btn-xs w-100" data-bs-toggle="modal" data-original-title="uploadsModals"
                    data-bs-target="#uploads-modal">View Uploads
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="add-appointment" tabindex="-1" role="dialog" aria-labelledby="add-appointment"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex justify-content-start text-center">
            <h5 class="text-muted">Schedule Appointment</h5>
          </div>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form @submit.prevent="saveAppointment" method="POST">
          <div class="modal-body pt-4 pb-4">
            <div class="row">
              <div class="col">
                <div class="row g-3" id="body-content">
                  <div class="col-md-1 mt-0"></div>
                  <div class="col-md-4 mt-0">
                    <input @change="toggleBindJob" class="checkbox_animated mt-3" id="bindJob" type="checkbox">
                    <span class="text-muted">Job</span>
                  </div>
                  <div class="col-md-4 mt-0">
                    <input @change="toggleBindLead" class="checkbox_animated mt-3" id="bindLead" type="checkbox">
                    <span class="text-muted">Lead</span>
                  </div>
                  <div class="col-md-3 mt-0">
                    <input @change="toggleNonWork" class="checkbox_animated mt-3" id="unbindLead" type="checkbox">
                    <span class="text-muted">Non-Work</span>
                  </div>
                  <div v-show="bindLead" class="col-md-1 text-center">
                    <i class="fa fa-search fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div v-show="bindLead" class="col-md-11">
                    <VueMultiselect
                        id="select-lead"
                        placeholder="Select a lead..."
                        label="opportunity_title"
                        track-by="lead_id"
                        :searchable="true"
                        :close-on-select="true"
                        v-model="formData.lead"
                        @select="getLeadId"
                        :options="leadOptions">
                    </VueMultiselect>
                  </div>

                  <div v-show="bindJob" class="col-md-1 text-center">
                    <i class="fa fa-search fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div v-show="bindJob" class="col-md-11">
                    <VueMultiselect
                        id="select-job"
                        placeholder="Select a job..."
                        label="jobsite_name"
                        track-by="lead_id"
                        :searchable="true"
                        :close-on-select="true"
                        :ref="jobsiteName"
                        v-model="formData.jobsite"
                        @select=""
                        :options="jobsiteOptions">
                    </VueMultiselect>
                  </div>

                  <div class="col-md-1 text-center">
                    <i class="fa fa-pencil-square-o fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <input id="title" type="text" class="form-control" placeholder="Title" name="appointment-title"
                           v-model="formData.title">
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="fa fa-clock-o fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <input class="form-control digits" data-language="en" id="meetingDate" type="text"
                           placeholder="Meeting Date" name="appointment-start-day" readonly>
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="fa fa-location-arrow fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <vue-google-autocomplete
                        id="street_address_new_appointment"
                        name="street_address_new_appointment"
                        classname="form-control"
                        placeholder="Street Address"
                        @input="newAppointmentAddress"
                        v-on:placechanged="getAddressDataForNewAppointment"
                        :country="['us']"
                        :type="['address']">
                    </vue-google-autocomplete>
                  </div>
                  <div class="col-md-1"></div>
                  <div class="col-md-4">
                    <input id="city" type="text" class="form-control" placeholder="City" v-model="formData.city">
                  </div>
                  <div class="col-md-4">
                    <input id="state" type="text" class="form-control" placeholder="State" v-model="formData.state">
                  </div>
                  <div class="col-md-3">
                    <input id="zipcode" type="number" class="form-control" placeholder="Zip Code"
                           v-model="formData.zipcode">
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
                        :options="userOptions">
                    </VueMultiselect>
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="fa fa-users fa-lg" style="opacity: 0.5; margin-top: 12px"></i>
                  </div>
                  <div class="col-md-11">
                    <select class="" name="" id="appointment_guests" multiple="multiple"
                            title="Include email addresses, separated by commas(,) to send to your guests that are outside your platform."></select>
                  </div>
                  <div class="col-md-1 text-center">
                    <i class="fa fa-clipboard fa-lg" style="opacity: 0.5; margin-top: 5px"></i>
                  </div>
                  <div class="col-md-11">
                    <textarea class="form-control" name="appointment-note" id="description" rows="5"
                              placeholder="Description" v-model="formData.description"></textarea>
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
                <button class="btn btn-primary w-100 mt-5">Create</button>
              </div>

            </div>
          </div>
          <!--          <div class="modal-footer">-->
          <!--            <button class="btn btn-primary w-100">Create</button>-->
          <!--          </div>-->
        </form>
      </div>
    </div>
  </div>

  <!-- uploads modal  -->
  <div class="modal fade" id="uploads-modal" tabindex="-1" role="dialog" aria-labelledby="uploadsModals"
       aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-muted" id="uploadsModals">Uploads</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row" id="file-holder">

          </div>
        </div>
        <!--        <div class="modal-footer">-->
        <!--          <div class="col-md-12" id="add-new-upload"><button class="btn btn-primary w-100" >Add</button></div>-->
        <!--          <div class="col-md-12" id="save-new-upload"><button class="btn btn-primary w-100" >Save</button></div>-->
        <!--        </div>-->
      </div>
    </div>
  </div>

  <!-- Settings Modal -->
  <div class="modal fade" id="calendar-settings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-muted" id="exampleModalLabel">Settings</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
<!--          <div class="card rounded">-->
<!--            <div class="card-header p-3">-->
<!--              <div class="card-title m-0 flex">-->
<!--                <img class="mr-1" src="../../../public/assets/images/google_logo.png" style="width: 22px" alt=""> <span>Google</span>-->
<!--              </div>-->
<!--            </div>-->
<!--            <hr class="p-0 m-0">-->
<!--            <div class="card-body">-->
<!--              <div class="row d-flex align-items-center">-->
<!--                <div class="col">-->
<!--                  <div class="d-flex align-items-center m-0">-->
<!--                    <div class="mr-2 d-flex align-items-center"-->
<!--                         style="border-radius: 50%; width: 60px; height: 60px; box-shadow: 0px 1px 4px 1px rgba(0,0,0,0.19); -webkit-box-shadow: 0px 1px 4px 1px rgba(0,0,0,0.19);-moz-box-shadow: 0px 1px 4px 1px rgba(0,0,0,0.19);">-->
<!--                      <img class="" src="../../../public/assets/images/calendar_icon.png" style="margin-left: 10px; margin-top: 4px; width: 40px" alt="">-->
<!--                    </div>-->
<!--                    <span>Google Calendar</span>-->
<!--                  </div>-->
<!--                </div>-->
<!--                <div class="col">-->
<!--                  <div class="d-flex align-items-center">-->
<!--                    <span>Gmail, G Suite</span>-->
<!--                  </div>-->
<!--                </div>-->
<!--                <div class="col text-end">-->
<!--                  <a href="/auth/google" class="btn btn-pill" style="background-color: #0b5ed7; color: #FFFFFF" v-if="!db_check">Connect</a>-->
<!--                  <a href="/google/disconnect" class="btn btn-pill" style="background-color: red; color: #FFFFFF" v-if="db_check">Disconnect</a>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->

          <div class="row">
            <div class="col-sm-3 tabs-responsive-side">
              <div class="nav flex-column nav-pills border-tab nav-left" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <div class="text-muted"><i class="icofont icofont-calendar h4"></i>Calendar</div>
                  <a class="nav-link m-l-20 mt-3 active" id="v-pills-general-tab" data-bs-toggle="pill" href="#v-pills-general" role="tab" aria-controls="v-pills-general" aria-selected="true">General</a>
                  <div class="text-muted mt-3"><i class="icofont icofont-wall h4"></i>Integrations</div>
                  <a class="nav-link m-l-20 mt-3" id="v-pills-calendar-tab" data-bs-toggle="pill" href="#v-pills-calendar" role="tab" aria-controls="v-pills-calendar" aria-selected="true">Calendar</a>
                  <div class="text-muted mt-3"><i class="icofont icofont-user-alt-7 h4"></i>Accounts</div>
                  <a class="nav-link m-l-20 mt-3 " id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">Profile</a>
              </div>
            </div>
            <div class="col-sm-9">
              <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                  <span class="h6">Calendar View</span>
                  <div class="media">
                    <div class="text-start switch-sm icon-state">
                      <label class="switch">
                        <input type="checkbox"><span class="switch-state"></span>
                      </label>
                    </div>
                    <span class="col-form-label m-l-10">Weekends</span>
                  </div>
                  <div class="media">
                    <div class="text-start switch-sm icon-state ">
                      <label class="switch">
                        <input type="checkbox"><span class="switch-state"></span>
                      </label>
                    </div>
                    <span class="col-form-label m-l-10">Declined Events</span>
                  </div>
                  <div class="media">
                    <div class="text-start switch-sm icon-state">
                      <label class="switch">
                        <input type="checkbox"><span class="switch-state"></span>
                      </label>
                    </div>
                    <span class="col-form-label m-l-10">Week numbers</span>
                  </div>
                  <div class="mt-3 col-sm-4">
                    <span class="d-block h6">Start week on:</span>
                    <select class="form-control" name="" id="">
                      <option value="" selected>Sunday</option>
                    </select>
                  </div>
                  <hr>
                  <span class="mt-3 d-block h6">Meetings</span>
                  <small class="text-muted">Events with participants are considered meetings.</small>
                  <p class="mt-1 mb-0">Show upcoming meeting in context panel.</p>
                  <div class="col-sm-4">
                    <select class="form-control" name="" id="">
                      <option value="">Always</option>
                    </select>
                  </div>
                  <hr>
                  <span class="mt-3 d-block h6">Language</span>
                  <div class="col-sm-4">
                    <select class="form-control" name="" id="">
                      <option value="">English</option>
                    </select>
                  </div>
                  <span class="mt-3 d-block h6">Time Format</span>
                  <div class="col-sm-4">
                    <select class="form-control" name="" id="">
                      <option value="">12-hour-time 1:10 AM</option>
                    </select>
                  </div>
                </div>
                <div class="tab-pane fade" id="v-pills-calendar" role="tabpanel" aria-labelledby="v-pills-calendar-tab">
                  <span class="h6 d-block">Default calendar</span>
                  <small class="text-muted">Events and availabilities will be created on this calendar by default. You can also change this in the left-hand calendar list.</small>
                  <div class="col-sm-4 mt-2">
                    <select class="form-control" name="" id="">
                      <option value="">-Dev Team</option>
                    </select>
                  </div>
                  <hr>
                  <span class="h6">Calendar accounts</span>
                  <div class="card rounded">
                    <div class="card-body p-3">
                      <div class="row">
                        <div class="col-sm-1 mt-1">
                          <svg style="width: 30px" class="m-r-15" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.72 8.16c0-.497-.045-.975-.127-1.433H8v2.708h3.767a3.22 3.22 0 0 1-1.396 2.113v1.756h2.262c1.323-1.219 2.087-3.013 2.087-5.145Z" fill="#4285F4"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8 15c1.89 0 3.475-.627 4.633-1.696l-2.262-1.756c-.627.42-1.43.668-2.37.668-1.824 0-3.367-1.231-3.918-2.886H1.745v1.814A6.997 6.997 0 0 0 8 15Z" fill="#34A853"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.083 9.33c-.14-.42-.22-.869-.22-1.33 0-.461.08-.91.22-1.33V4.856H1.745a6.997 6.997 0 0 0 0 6.288L4.083 9.33Z" fill="#FBBC05"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8 3.784c1.028 0 1.95.353 2.676 1.047l2.008-2.008C11.472 1.693 9.887 1 8 1a6.997 6.997 0 0 0-6.255 3.856L4.083 6.67C4.633 5.015 6.177 3.784 8 3.784Z" fill="#EA4335"></path>
                          </svg>
                        </div>
                        <div class="col-sm-6 mt-2">
                          <span>Add Google Calendar account</span>
                        </div>
                        <div class="col-sm-3 mt-2">
                          <span>Learn more</span>
                            <svg style="width: 15px" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-muted m-l-5">
                              <path class="" d="M11 7a.5.5 0 0 0-1 0h1ZM5 2a.5.5 0 0 0 0-1v1Zm5 5v2h1V7h-1Zm-1 3H3v1h6v-1ZM2 9V3H1v6h1Zm1-7h2V1H3v1ZM2 3a1 1 0 0 1 1-1V1a2 2 0 0 0-2 2h1Zm1 7a1 1 0 0 1-1-1H1a2 2 0 0 0 2 2v-1Zm7-1a1 1 0 0 1-1 1v1a2 2 0 0 0 2-2h-1Z" fill="currentColor"></path>
                              <path class="" d="M4.146 7.146a.5.5 0 1 0 .708.708l-.708-.708ZM10.5 1.5h.5a.5.5 0 0 0-.5-.5v.5Zm-3-.5a.5.5 0 0 0 0 1V1ZM10 4.5a.5.5 0 0 0 1 0h-1ZM4.854 7.854l6-6-.708-.708-6 6 .708.708ZM10.5 1h-3v1h3V1Zm-.5.5v3h1v-3h-1Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <div class="col mt-2">
                          <button class="btn btn-xs btn-primary-v2">Connect</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <small class="text-muted">Per-calendar settings of connected accounts are configured by selecting them in the left-hand calendar list.</small>
                  <div class="card rounded mt-2">
                    <div class="card-body p-3">
                      <div class="row">
                        <div class="col-sm-1 mt-1">
                          <svg style="width: 30px" class="m-r-15" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.72 8.16c0-.497-.045-.975-.127-1.433H8v2.708h3.767a3.22 3.22 0 0 1-1.396 2.113v1.756h2.262c1.323-1.219 2.087-3.013 2.087-5.145Z" fill="#4285F4"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8 15c1.89 0 3.475-.627 4.633-1.696l-2.262-1.756c-.627.42-1.43.668-2.37.668-1.824 0-3.367-1.231-3.918-2.886H1.745v1.814A6.997 6.997 0 0 0 8 15Z" fill="#34A853"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.083 9.33c-.14-.42-.22-.869-.22-1.33 0-.461.08-.91.22-1.33V4.856H1.745a6.997 6.997 0 0 0 0 6.288L4.083 9.33Z" fill="#FBBC05"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8 3.784c1.028 0 1.95.353 2.676 1.047l2.008-2.008C11.472 1.693 9.887 1 8 1a6.997 6.997 0 0 0-6.255 3.856L4.083 6.67C4.633 5.015 6.177 3.784 8 3.784Z" fill="#EA4335"></path>
                          </svg>
                        </div>
                        <div class="col-sm-6 mt-2">
                          <span>Google Calendar</span>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-6 mt-2">dev@buildovate.com</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                  <div class="row">
                    <div class="col-sm-2">
                      <img class="img-90 rounded-circle" src="https://dev2.buildovate.io/assets/images/dashboard/1.png" alt="">
                    </div>
                    <div class="col-sm-6">
                      <div class="row mt-3">
                        <div class="col">
                          <span>Change photo</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <span class="text-danger">Remove photo</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-sm-6">
                      <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput1">First Name</label>
                        <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput1">Last Name</label>
                        <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="...">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput1">Address</label>
                        <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="...">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput1">City</label>
                        <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="...">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput1">Postal Code</label>
                        <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="...">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-4">
                        <label class="form-label" for="exampleFormControlInput1">Country</label>
                        <input class="form-control input-sm" id="exampleFormControlInput1" type="text" placeholder="...">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <button class="btn btn-primary-v2" type="button" data-bs-dismiss="modal">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary-v2" type="button" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for schedule-offline -->
  <div class="modal fade" id="schedule-offline-modal" tabindex="-1" role="dialog" aria-labelledby="scheduleOffline"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body p-5">
          <h6 class="mb-3 d-flex items-center"><i class="fa fa-check-circle mr-4 h4" style="color: #47cf73"></i><span
              class="mb-1">Your Schedule is now online</span></h6>
          <ul style="margin-left: 50px">
            <li style="list-style-type: circle">Notifications and reminders will be sent as scheduled</li>
            <li style="list-style-type: circle">Subs/Vendors and the Owner can see schedule items if permitted</li>
            <li style="list-style-type: circle">Schedule items cannot be modified directly in the Calendar and Gantt
              tabs
            </li>
          </ul>
          <label class="d-block mt-3" for="chk-ani">
            <input class="checkbox_animated" id="chk-ani" type="checkbox">
            <small>Hide future online/offline alerts</small>
          </label>
        </div>
        <div class="modal-footer border-0 mt-0 pt-0">
          <button class="btn" style="background-color: #0b5ed7 !important; color: white" type="button"
                  @click="toggleSchedule">Ok
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal preview for SMS and Email template -->
  <div class="modal fade" id="email-and-sms-preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">SMS / E-Mail</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Modal preview of SMS and Email template here...
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="edit-sms-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit SMS / Email </h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <templates></templates>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<!-- Notes Modal -->
  <div class="modal fade" id="notes-modal" tabindex="-1" role="dialog" aria-labelledby="notesModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Notes</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Sticky Notes here
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</template>

<script setup>
import LoadingMetric from '@/components/LoadingStyleMetric.vue';
import templates from '@/Pages/Templates.vue';
import VueGoogleAutocomplete from "vue-google-autocomplete";
import {reload_jobsite_list, selected_jobsite} from '../globalState';
import {ref, watch} from "vue";

const blockPage = ref(true)
let jobsiteName = ''

if (selected_jobsite.value != null) {
  jobsiteName = ref(selected_jobsite.value.jobsite_name)
} else {
  blockPage.value = false
}

watch(selected_jobsite, (val) => {
  jobsiteName = val.jobsite_name
  blockPage.value = true
})

watch(reload_jobsite_list, (newValue) => {
  // console.log(newValue)
  jobsiteName = val.jobsite_name
  blockPage.value = true
}, {deep: true});

</script>

<script>

import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';
import axios from "axios";
import Datepicker from 'vue3-datepicker';
import VueMultiselect from 'vue-multiselect';
import {router} from '@inertiajs/vue3';
import {toast} from 'vue3-toastify';
import Dropzone from "dropzone";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import Swal from "sweetalert2";
import userInstaller from '../components/calendar/UserInstaller.vue'
import googleMap from '../components/calendar/GoogleMap.vue'

export default {
  components: {
    Datepicker,
    VueMultiselect,
    userInstaller,
    googleMap
  },
  props: ['customData', 'leads', 'users', 'jobsites', 'google_cal', 'db_check', 'check_dis'],
  data() {
    return {
      uploadIcon: window.location.origin + '/assets/images/upload-100.png',
      deleteIcon: window.location.origin + '/assets/images/delete.png',
      showInfo: null,
      isChecked: false,
      showLoader: false,
      bindLead: false,
      bindJob: false,
      nonWork: false,
      selected: null,
      leadOptions: this.leads,
      userOptions: this.users,
      jobsiteOptions: this.jobsites,
      showCalendar: false,
      show: false,
      toggleIsAllDay: true,
      withReminder: 0,
      hideSchedReminder: false,
      formData: {
        jobsite: '',
        leadId: '',
        lead: '',
        title: '',
        startDate: '',
        endDate: '',
        meetingDate: '',
        // dateStartTime: '',
        // dateEnd: '',
        // dateEndTime: '',
        streetAddress: '',
        city: '',
        state: '',
        zipcode: '',
        // isAllDay: '',
        assignedToUser: '',
        assignedToUserId: '',
        guest: '',
        description: '',
        fileName: '',
        file: [],
        entityType: 'non-work',
        entityId: 0,
        reminder_sms: false,
        reminder_email: true
      },
      leadManagement: {
        stage: ''
      },
      additionalUpload: {
        saveIsOn: true,
        onSave: false
      },
      calendarSelect: true
    }
  },
  methods: {
    showInfoOrNot(key) {
      if (key == 'enter' && !this.isChecked) {
        this.showInfo = true
      }

      if (key == 'leave') {
        this.showInfo = false
      }
    },
    showRequestSchedInfo() {
      alert('test')
    },
    extractStartAndEndDate(date) {
      let dates = date.split(' - ');
      let startDateWithTime = dates[0];
      let endDateWithTime = dates[1];
      this.formData.startDate = startDateWithTime.split(' ')[0];
      this.formData.endDate = endDateWithTime.split(' ')[0];
    },
    toggleSchedule: function () {
      $('#schedule-offline-modal').modal('hide')
      $('#calendar-alert').hide()
    },
    getAddressDataForNewAppointment: function (addressData, placeResultData, id) {
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
              this.formData.state = component.long_name
            break;
          case "administrative_area_level_2":
            if (id === "street_address_new_appointment")
              this.formData.state = component.long_name;
            else
              this.formData.state = component.long_name
            break;
          case "neighborhood":
            if (id === "street_address_new_appointment")
              this.formData.city = component.long_name;
            else
              this.formData.city = component.long_name
            break;
        }
      }

      if (streetAddress) {
        if (id === "street_address_new_appointment") {
          $('#street_address_new_appointment').val(streetAddress);
          this.formData.streetAddress = streetAddress;
        }
      }
    },
    newAppointmentAddress: function () {
      this.formData.streetAddress = event.target.value
    },
    addNewUpload: function () {
      $('.info-message').hide()
      this.additionalUpload.onSave = !this.additionalUpload.onSave
      this.additionalUpload.saveIsOn = !this.additionalUpload.saveIsOn
    },
    saveNewUpload: function () {

    },
    handleStage: function (info) {
      // console.log(this.leadManagement.stage)
    },
    fileChange: function (e) {
      this.file = e.target.files[0]
    },
    saveUpload: function () {
      // const formData = new FormData()
      // formData.append('file[]', this.formData.file)

      // axios.post('/calendar/save-file-upload', formData).then((res) => {
      //   console.log(res)
      // })
    },
    async saveAppointment() {
      this.extractStartAndEndDate($('#meetingDate').val())
      this.formData.guest = $('#appointment_guests').val().join(', ')
      const form = new FormData()
      form.append('file[]', this.formData.file)

      try {
        this.showLoader = true
        let errorCount = this.validateRequiredFields(this.formData, ['description', 'zipcode', 'state', 'city', 'streetAddress', 'endDate', 'startDate', 'meetingDate', 'jobsite', 'leadId', 'lead', 'guest', 'fileName', 'file'])
        if (errorCount > 0) {
          if (errorCount === 1) {
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
            if (response.status == 201) {
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
      } finally {
        this.showLoader = false
      }

    },
    isAllDayChecked: function () {
      this.toggleIsAllDay = !this.toggleIsAllDay;
    },
    withReminderYesOrNo: function (info) {
      if (info.target.value == 1)
        this.hideSchedReminder = true
      else
        this.hideSchedReminder = false
    },
    uploadFileName: function (info) {
      this.formData.fileName = info.target.files[0].name
    },
    getLeadId: function (info) {
      this.formData.leadId = info.lead_id
    },
    getAssignedToId: function (info) {
      this.formData.assignedToUserId = info.user_id
    },
    toggleBindLead: function (info) {
      $('#street_address_new_appointment').val('')
      this.formData.city = ''
      this.formData.state = ''
      this.formData.zipcode = ''
      this.bindLead = !this.bindLead
      this.bindJob = false
      $('#unbindLead').prop('checked', false)
      $('#bindJob').prop('checked', false)
    },
    toggleBindJob: function () {
      if (selected_jobsite.value) {
        $('#street_address_new_appointment').val(selected_jobsite.value.street)
        this.formData.city = selected_jobsite.value.city
        this.formData.state = selected_jobsite.value.state
        this.formData.zipcode = selected_jobsite.value.zipcode
      }

      this.bindJob = !this.bindJob
      this.bindLead = false
      $('#bindLead').prop('checked', false)
      $('#unbindLead').prop('checked', false)
    },
    toggleNonWork: function () {
      if (this.bindLead) {
        $('#street_address_new_appointment').val('')
        this.formData.city = ''
        this.formData.state = ''
        this.formData.zipcode = ''
        this.bindLead = !this.bindLead
        $('#bindLead').prop('checked', false)
      }
      if (this.bindJob) {
        $('#street_address_new_appointment').val('')
        this.formData.city = ''
        this.formData.state = ''
        this.formData.zipcode = ''
        this.bindJob = !this.bindJob
        $('#bindJob').prop('checked', false)
      }
      if (this.bindLead && this.bindJob) {
        $('#street_address_new_appointment').val('')
        this.formData.city = ''
        this.formData.state = ''
        this.formData.zipcode = ''
        this.bindLead = !this.bindLead
        this.bindJob = !this.bindJob
        $('#bindLead').prop('checked', false)
        $('#bindJob').prop('checked', false)
      }
    },
    validateRequiredFields: function (fields, exceptKey) {
      let countError = 0;

      $.each(fields, function (key, value) {
        let i = $.inArray(key, exceptKey)
        if (i === -1 && value.length === 0) {
          console.log(key, exceptKey)
          countError++
          if (key == 'assignedToUser') {
            $('.multiselect__tags').addClass('errorBorder')
          }
          $('#' + key).addClass('errorBorder')
        } else {
          if (key == 'assignedToUser') {
            $('.multiselect__tags').removeClass('errorBorder')
          }
          $('#' + key).removeClass('errorBorder')
        }
      })
      return countError
    },
    manageFileUpload: function () {
      let thisInstance = this
      $(document).on('click', '.delete-icon', function () {
        $(this).parent().remove();

        let dataArray = thisInstance.formData.file
        let keyId = $(this).attr('image-name')

        $.each(dataArray, function (key, val) {
          let keyTobeRemove = dataArray.indexOf(key)
          if (val.name == keyId) {
            dataArray.splice(keyTobeRemove, 1)
          }
        })
      })

      $(document).on('mouseover', '.delete-icon', function () {
        $(this).siblings().addClass('opacity');
      })

      $(document).on('mouseout', '.delete-icon', function () {
        $(this).siblings().removeClass('opacity');
      })

      document.getElementById('custom-dropzone').addEventListener('drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let file = e.dataTransfer.files;
        // uploadFile(file);
        filePreview(file)
      });

      document.getElementById('custom-dropzone').addEventListener('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let file = e.dataTransfer.files;
        // uploadFile(file);
        filePreview(file)
      });

      let keyId = []
      document.getElementById('custom-file-upload').addEventListener('change', function (e) {
        let file = e.target.files;
        // uploadFile(file);
        filePreview(file)
      });

      function filePreview(file) {
        let imageCount = 0
        for (let i = 0; i < file.length; i++) {
          imageCount++
          let uniqueId = Math.floor(Math.random() * (0x10FFFF - 0x20 + 1)) + 0x20
          let reader = new FileReader();
          reader.onload = function (e) {
            let img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.marginRight = '5px'
            img.style.marginBottom = '5px'
            img.style.borderRadius = '10px'
            img.style.position = 'relative'
            img.classList.add('images-item')

            let removeItem = document.createElement('a')
            removeItem.innerText = 'Remove'
            removeItem.setAttribute('image-name', file[0].name)
            removeItem.style.marginLeft = '18px'
            removeItem.classList.add('delete-icon')

            let imageContainer = document.createElement('div')
            imageContainer.style.position = 'relative'
            imageContainer.style.display = 'inline-block'
            imageContainer.style.zIndex = '99999'
            imageContainer.style.padding = '10px'
            imageContainer.setAttribute('id', 'image-block-container-' + uniqueId)

            document.getElementById('image-container').appendChild(imageContainer);
            document.getElementById('image-block-container-' + uniqueId).appendChild(img);
            document.getElementById('image-block-container-' + uniqueId).appendChild(removeItem);
          };
          reader.readAsDataURL(file[i]);
        }
      }
    },
    handleFileUpload: function () {
      let files = event.target.files

      for (let i = 0; i < files.length; i++) {
        this.formData.file.push(files[i]);
      }
    },
    handlePreviewOrAddUpload: function (appointmentId) {
      $('#file-holder').empty()
      axios.get('/calendar/get-upload', {params: {appointmentId: appointmentId}}, {
        timeout: 1000,
        headers: {
          'Content-Type': 'multipart/form-data',
          'Access-Control-Allow-Origin': '*'
        }
      }).then(response => {

        if (response.data.length <= 0 && !$('#file-holder').has('.info-message').length) {
          $('#file-holder').append('<div class="col-md-12 info-message"><div class="alert alert-light dark mb-0" role="alert"><p class="text-muted">No files available.</p></div></div>')
        }

        $.each(response.data, function (key, val) {
          $('#file-holder').append('<div class="col-md-4"><img class="rounded mb-2" style="width: 200px; height: 200px;" src="' + val + '" alt=""></div>')
          $('#save-new-upload').hide()
        })

      });
    }
  },
  beforeMount: function () {
  },
  mounted: function () {

    $('div.page-body').css({
      overflow: 'hidden !important',
      height: '100% !important'
    });

    if (this.google_cal) {
      Swal.fire({
        text: "Success! Google Calendar is now connected.",
        icon: "success",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
          confirmButton: "btn btn-success"
        }
      })
    }

    if (this.check_dis) {
      Swal.fire({
        text: "Success! Google Calendar is now Disconnected.",
        icon: "success",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
          confirmButton: "btn btn-success"
        }
      })
    }

    let preSelectedJob = ''
    if (selected_jobsite.value) {
      preSelectedJob = selected_jobsite.value.jobsite_name
    }

    this.formData.jobsite = this.jobsiteOptions.find(option => option.jobsite_name === preSelectedJob);

    let selfie = this

    $('#save-new-upload').hide()

    $(document).on('click', '#add-new-upload', function () {
      $('#save-new-upload').show()
      $('.info-message').hide()
      $('#additional-file-upload-label').show()
      $('#file-holder').append('<label for="additional-upload" class="w-100" id="additional-file-upload-label" style="display: inline">\n' +
          '              <div class="card mb-0 custom-dropzone rounded" id="additional">\n' +
          '                <div class="card-body">\n' +
          '                  <input type="file" id="additional-upload" hidden multiple="multiple" @change="handleFileUpload">\n' +
          '                  <img id="upload-image" src="' + selfie.uploadIcon + '" alt="" style="display: block; margin-left: auto; margin-right: auto">\n' +
          '                </div>\n' +
          '              </div>\n' +
          '            </label>\n' +
          '            <div id="image-container">\n' +
          '            </div>')
      $(this).hide()
    })

    this.manageFileUpload()
    $('#appointment_guests').select2({
      tags: true,
      tokenSeparators: [','],
      createTag: function (params) {
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


    let calCon = $('#full-cal-container')
    let rightSection = $('#right-section')

    rightSection.hide()

    // $('#custom-datepicker').datepicker()
    //Initialize datepicker
    $('#custom-datepicker').datepicker({
      language: "en",
      format: "yyyy-mm-dd",
      weekStart: 0,
      // defaultDate: '2023-09-22',
      minDate: new Date(new Date().setDate(new Date().getDate() - 730)),
      maxDate: new Date(new Date().setDate(new Date().getDate() + 730)),
      maxViewMode: 2,
      minViewMode: 0,
      todayHighlight: true,
      onSelect: function (selectedDate) {
        // let selected = date.datepicker("getDate")
        if ($('#custom-datepicker').val()) {
          calendar.gotoDate(new Date(selectedDate))
          calendar.select(new Date(selectedDate))
        }
      }
    });

    $('#meetingDate').daterangepicker({
      language: "en",
      autoClose: true,
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY h:mm A'
      },
      onSelect: function (date) {
        console.log(date)
        // selfie.formData.meetingDate = new Date(date)
      }
    })

    let dateId = null
    let lastSelectionInfo = null
    let dateClick = null
    // Initialize full calendar
    let calendarEl = document.getElementById('full-calendar')
    let calendar = new Calendar(calendarEl, {
      plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
      initialView: 'timeGridWeek',
      allDaySlot: false,
      height: $(window).height() - 130,
      stickyHeaderDates: true,
      selectable: selfie.calendarSelect,
      selectMirror: true,
      dayMaxEvents: true,
      weekends: true,
      headerToolbar: {
        left: 'addEvent requestSchedule addPros',
        center: 'title prev,next today',
        right: 'pros staff all dayGridMonth,timeGridWeek,listWeek'
      },
      customButtons: {
        addEvent: {
          text: 'Add Schedule',
          click: function (ev, element) {
            $('#add-appointment').modal('show')
            let selectedJob = ''
            if (selected_jobsite.value) {
              $('#street_address_new_appointment').val(selected_jobsite.value.street)
              selfie.formData.city = selected_jobsite.value.city
              selfie.formData.state = selected_jobsite.value.state
              selfie.formData.zipcode = selected_jobsite.value.zipcode
              selectedJob = selected_jobsite.value.jobsite_id
            }
            selfie.formData.jobsite = selfie.jobsiteOptions.find(option => option.jobsite_id === selectedJob);
          }
        },
        requestSchedule: {
          text: 'Request Schedule',
          click: function() {
            alert('test')
          }
        },
        addPros: {
          text: 'Add Pros',
          click: () => {alert('add pros')}
        },
        pros: {
          text: 'Pros'
        },
        staff: {
          text: 'Staff'
        },
        all: {
          text: 'All'
        }
      },
      events: this.customData,
      select: function (info) {
        let element = document.querySelector('.fc-event-main');
        let overlay = document.createElement('div');
        overlay.className = 'time-slot-overlay';
        overlay.style.top = element.getBoundingClientRect().y + 'px';
        overlay.style.left = element.getBoundingClientRect().x + 'px';
        overlay.style.width = '210px';
        overlay.style.height = '20px';
        document.body.appendChild(overlay);

        $('.time-slot-overlay').on('click', function () {
          let selectedJob = ''
          if (selected_jobsite.value) {
            // $('#street_address_new_appointment').val(selected_jobsite.value.street)
            // selfie.formData.city = selected_jobsite.value.city
            // selfie.formData.state = selected_jobsite.value.state
            // selfie.formData.zipcode = selected_jobsite.value.zipcode
            selectedJob = selected_jobsite.value.jobsite_id
          }
          selfie.formData.jobsite = selfie.jobsiteOptions.find(option => option.jobsite_id === selectedJob);
          $('#add-appointment').modal('show')
          calendar.unselect();
          $(this).remove()
        })
      },
      dateClick: function (calDate) {
        dateClick = calDate.date
        // console.log(new Date(calDate.date).toLocaleDateString())
        // let stDate = new Date(calDate.date).toLocaleDateString('en-US', {
        //   day: '2-digit',
        //   month: '2-digit',
        //   year: 'numeric',
        // })
        //
        //  $('#appointment-start-day').val(stDate)
        // $('#add-appointment').modal('show')
        let selectedJob = ''
        if (selected_jobsite.value) {
          selectedJob = selected_jobsite.value.jobsite_name
        }
        selfie.formData.jobsite = selfie.jobsiteOptions.find(option => option.jobsite_name === selectedJob);
        // date.datepicker({dateFormat: 'yy-mm-dd'})
        // $('#custom-datepicker').datepicker("setDate", new Date(calDate.date).toLocaleDateString())
        // console.log($('#custom-datepicker').datepicker('getDates'))
        // date.datepicker("setDate", new Date('2023-20-09'))
      },
      eventClick: function (info) {
        // console.log(info.event._def)
        // console.log(info.event._def.extendedProps)
        selfie.handlePreviewOrAddUpload(info.event._def.extendedProps.appointment_id)
        calCon.removeClass('col-md-12').addClass('col-md-10')
        $('#select-appointment').fadeOut().hide()
        rightSection.fadeIn().show()
        $('#full-name').text(info.event._def.extendedProps.cx_name)
        $('#phonenumber').text(info.event._def.extendedProps.opportunity_phone)
        $('#email').text(info.event._def.extendedProps.email)
        $('#appointment-title').text(info.event._def.title)
        $('#meeting-description').text(info.event._def.extendedProps.description)
        $('#state').text(info.event._def.extendedProps.state)
        $('#street-address').text(info.event._def.extendedProps.street + ' ' + info.event._def.extendedProps.city + ' ' + info.event._def.extendedProps.state + ' ' + info.event._def.extendedProps.zipcode)
        $('#city').text(info.event._def.extendedProps.city)
        $('#zip-code').text(info.event._def.extendedProps.zipcode)
        $('#assignee').text(info.event._def.extendedProps.assign_to)
        $('#guest').text(info.event._def.extendedProps.guests)
        $('#stage-options-select').text(info.event._def.extendedProps.stage)
      },
      datesSet: function () {
        let dayHeaders = document.querySelectorAll('.fc-col-header-cell');

        dayHeaders.forEach(function (header) {
          var existingIcon = header.querySelector('.weather_icon');
          // Create your SVG element or any other custom content here
          if (!existingIcon) {
            var customContent = document.createElement('span'); // For example, a span element
            customContent.innerHTML = '<svg class="climacon climacon_sun" id="sun" version="1.1" viewBox="15 15 70 70" style="width: 50px; height: 50px">\n' +
                '                          <clippath id="sunFillClip">\n' +
                '                            <path d="M0,0v100h100V0H0z M50.001,57.999c-4.417,0-8-3.582-8-7.999c0-4.418,3.582-7.999,8-7.999s7.998,3.581,7.998,7.999C57.999,54.417,54.418,57.999,50.001,57.999z"></path>\n' +
                '                          </clippath>\n' +
                '                          <g class="climacon_iconWrap climacon_iconWrap-sun">\n' +
                '                            <g class="climacon_componentWrap ">\n' +
                '                              <g class="climacon_componentWrap climacon_componentWrap-sunSpoke">\n' +
                '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-east" d="M72.03,51.999h-3.998c-1.105,0-2-0.896-2-1.999s0.895-2,2-2h3.998c1.104,0,2,0.896,2,2S73.136,51.999,72.03,51.999z"></path>\n' +
                '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-northEast" d="M64.175,38.688c-0.781,0.781-2.049,0.781-2.828,0c-0.781-0.781-0.781-2.047,0-2.828l2.828-2.828c0.779-0.781,2.047-0.781,2.828,0c0.779,0.781,0.779,2.047,0,2.828L64.175,38.688z"></path>\n' +
                '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-north" d="M50.034,34.002c-1.105,0-2-0.896-2-2v-3.999c0-1.104,0.895-2,2-2c1.104,0,2,0.896,2,2v3.999C52.034,33.106,51.136,34.002,50.034,34.002z"></path>\n' +
                '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-northWest" d="M35.893,38.688l-2.827-2.828c-0.781-0.781-0.781-2.047,0-2.828c0.78-0.781,2.047-0.781,2.827,0l2.827,2.828c0.781,0.781,0.781,2.047,0,2.828C37.94,39.469,36.674,39.469,35.893,38.688z"></path>\n' +
                '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-west" d="M34.034,50c0,1.104-0.896,1.999-2,1.999h-4c-1.104,0-1.998-0.896-1.998-1.999s0.896-2,1.998-2h4C33.14,48,34.034,48.896,34.034,50z"></path>\n' +
                '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-southWest" d="M35.893,61.312c0.781-0.78,2.048-0.78,2.827,0c0.781,0.78,0.781,2.047,0,2.828l-2.827,2.827c-0.78,0.781-2.047,0.781-2.827,0c-0.781-0.78-0.781-2.047,0-2.827L35.893,61.312z"></path>\n' +
                '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-south" d="M50.034,65.998c1.104,0,2,0.895,2,1.999v4c0,1.104-0.896,2-2,2c-1.105,0-2-0.896-2-2v-4C48.034,66.893,48.929,65.998,50.034,65.998z"></path>\n' +
                '                                <path class="climacon_component climacon_component-stroke climacon_component-stroke_sunSpoke climacon_component-stroke_sunSpoke-southEast" d="M64.175,61.312l2.828,2.828c0.779,0.78,0.779,2.047,0,2.827c-0.781,0.781-2.049,0.781-2.828,0l-2.828-2.827c-0.781-0.781-0.781-2.048,0-2.828C62.126,60.531,63.392,60.531,64.175,61.312z"></path>\n' +
                '                              </g>\n' +
                '                              <g class="climacon_componentWrap climacon_componentWrap_sunBody" clip-path="url(#sunFillClip)">\n' +
                '                                <circle class="climacon_component climacon_component-stroke climacon_component-stroke_sunBody" style="fill:#FDB813" cx="50.034" cy="50" r="11.999"></circle>\n' +
                '                              </g>\n' +
                '                            </g>\n' +
                '                          </g>\n' +
                '                        </svg>'; // Your SVG content goes here
            customContent.classList.add('weather_icon')

            // Append your custom content to the header
            header.prepend(customContent);
          }
        });
      }
    });

    $('#exit-right-section').on('click', function () {
      // router.reload()
      rightSection.hide()
      $('#select-appointment').fadeIn().show()
      // calendar.updateSize()
      // calCon.removeClass('col-md-10').addClass('col-md-12')
    });

    $('#appointment-date-end').datepicker({
      language: "en"
    })

    $('#schedule-reminder-date-and-time').datepicker()

    calendar.render()

    let filter = '<div class="form-group m-checkbox-inline mt-0 mb-1">\n' +
        '                          <div class="checkbox checkbox-dark float-end">\n' +
        '                            <input id="inline-1" type="checkbox">\n' +
        '                            <label for="inline-1">All</label>\n' +
        '                          </div>\n' +
        '                          <div class="checkbox checkbox-dark float-end">\n' +
        '                            <input id="inline-2" type="checkbox">\n' +
        '                            <label for="inline-2">Users</label>\n' +
        '                          </div>\n' +
        '                          <div class="checkbox checkbox-dark float-end">\n' +
        '                            <input id="inline-3" type="checkbox">\n' +
        '                            <label for="inline-3">Installers</label>\n' +
        '                          </div>\n' +
        '                        </div>';
    $('.fc-header-toolbar').after(filter)

    $('.fc-requestSchedule-button').removeAttr('title');

    let tooltip = '<div id="requestSchedToolTip" style="position: absolute; z-index: 9999; margin-left: 400px; margin-top: -2px">\n' +
        '                  <div class="bg-white easycreate-dropdown-reverse shadow-lg d-flex flex-column" style=" width: 300px">\n' +
        '                    <span class="text-dark f-14 f-w-600 px-3 py-2 d-flex gap-3 align-items-center">\n' +
        '                      <i class="icofont icofont-exclamation-circle h5" style="color: #1E5BB2"></i>\n' +
        '                      <div class="d-flex flex-column text-start">\n' +
        '                        <span class="text-muted f-12" style="font-family: Montserrat, sans-serif">Request the schedule by asking your installers to fill in their work schedule for Project. [project name] via text and email.</span>\n' +
        '                      </div>\n' +
        '                    </span>\n' +
        '                  </div>\n' +
        '                </div>'

    let buttonEl = document.querySelector('.fc-requestSchedule-button')

    if (buttonEl) {
      buttonEl.addEventListener('mouseenter', function () {
        $('.fc-requestSchedule-button').after(tooltip)
      });
    }

    buttonEl.addEventListener('mouseleave', function () {
      $('#requestSchedToolTip').remove()
    });

    $('#add-appointment').on('hidden.bs.modal', function (e) {
      selfie.bindLead = false
      selfie.bindJob = false
      selfie.nonWork = false
      $('#bindJob').prop('checked', false)
      $('#bindLead').prop('checked', false)
      $('#unbindLead').prop('checked', false)
      $('#street_address_new_appointment').val('')
      selfie.formData.city = ''
      selfie.formData.state = ''
      selfie.formData.zipcode = ''
    })

    $('#so-color-state').addClass('bg-info')
    $('#offline-online').text('Offline')
    $('#schedule-offline').on('change', function () {
      if (this.checked) {
        $('#offline-online').text('Online')
        $('#schedule-offline-modal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#schedule-offline-modal').modal('show')
        $('#so-color-state').removeClass('bg-info').css('background-color', '#0b5ed7')
      } else {
        $('#offline-online').text('Offline')
        $('#calendar-alert').show()
        $('#so-color-state').addClass('bg-info')
      }
    })

  },
  beforeUnmount() {
    let buttonEl = document.querySelector('.fc-requestSchedule-button')
    if (buttonEl) {
      buttonEl.removeEventListener('mouseover', this.showInfoOrNot);
    }
  },
  created() {
    $('div.page-body').css({
      overflow: 'hidden !important',
      height: '100% !important'
    });
    axios.interceptors.request.use(
        config => {
          let token = document.head.querySelector('meta[name="csrf-token"]');
          if (token) {
            config.headers['X-CSRF-TOKEN'] = token.content;
          }
          return config;
        },
        error => Promise.reject(error)
    );
  }
}


</script>
