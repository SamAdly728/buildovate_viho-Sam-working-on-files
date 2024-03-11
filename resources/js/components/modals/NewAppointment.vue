<template>
    <div class="modal-transparent d-flex" style="position: absolute; left: 0; top: 0; bottom: 0; right: 0; z-index: 500;" v-if="showing">
        <div style="width: 50%;" class="bg-white shadow-lg d-flex flex-column" :class="this.isOpen ? 'right-slide-animation-in' : 'right-slide-animation-out'">
            <div class="d-flex align-items-center">
                <h5 class="p-3 f-w-600 text-dark m-0 p-0 flex-grow-1" style="height: 55px;">New {{ this.formType }}</h5>
                <a style="cursor: pointer;" @click="store.close()" class="p-3"><i class="icon-close"></i></a>
            </div>
            <div class="flex-grow-1 bg-main" style="max-height: calc(100vh - 51px); overflow-y: auto;">
              <div class="row">
                <div class="col-xl-12">
                  <div class="card b-primary-v2">
                    <div class="card-body m-0 pt-2">
                      <div class="row mb-3">
                        <div class="col-sm-6 col-md-6">
                          <div class="mb-3">
                              <label for="eventColor"  class="form-label f-w-600">Event Color</label>
                              <select id="eventColor" class="form-select  b-primary-v2"  v-model="appointmentDetails.selectedColor" @change="updateBackgroundColor" :style="{ backgroundColor: appointmentDetails.selectedColor, color: textColor(appointmentDetails.selectedColor) }">
                                <option v-for="color in eventColors" :value="color.value" :style="{ backgroundColor: color.value, color: color.textColor }">{{ color.text }}</option>
                              </select>
                          </div>
                        </div>
                        
                        <div class="col-sm-6 col-md-6">
                          <div class="mb-3">
                              <label class="form-label f-w-600">Assign To</label>
                              <select ref="selectInstance" id="salesperson" v-model="appointmentDetails.selectedSalesId" placeholder="Select Crew Member" class="form-select b-primary-v2">
                                  <option value="0" disabled selected>Select Crew Member</option>
                                  <option v-for="item in salespersons" :key="item.id" :value="item.id">{{ item.text }}</option>
                              </select>
                          </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                          <div class="mb-3">
                            <label class="form-label f-w-600">Scheduled Date</label>
                            <flat-pickr
                              ref="flatpickr"
                              class="form-control b-primary-v2 bg-white"
                              v-model="appointmentDetails.apptDate"
                              :config="apptDateConfig"
                              placeholder="Select date and time"
                              name="appointment_date"
                              :disabled="processing"
                            ></flat-pickr>
                          </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                          <div class="mb-3">
                            <label class="form-label f-w-600">Scheduled Time</label>
                            <multiselect 
                                v-model="appointmentDetails.selectedTime" 
                                :options="timeOptions" 
                                :searchable="true"
                                :close-on-select="true"
                                :show-labels="false"
                                label="name"
                                track-by="name"
                                :allow-empty="false">
                            </multiselect>
                          </div>
                        </div>

                        <div class="col-sm-12 col-md-12">
                          <div class="mb-3">
                            <label class="form-label f-w-600">Event Duration</label>
                            <div class="d-flex justify-content-center gap-3">
                              <div class="btn-group">
                                <button type="button" style="border: solid 1px;" class="btn px-3 py-3" :class="{'btn-success-v2': appointmentDetails.selectedDuration === '15'}" @click="selectDuration('15')"> 15 min </button>
                                <button type="button" style="border: solid 1px;" class="btn px-3 py-3" :class="{'btn-success-v2': appointmentDetails.selectedDuration === '30'}" @click="selectDuration('30')"> 30 min </button>
                                <button type="button" style="border: solid 1px;" class="btn px-3 py-3" :class="{'btn-success-v2': appointmentDetails.selectedDuration === '45'}" @click="selectDuration('45')"> 45 min </button>
                              </div>

                              <div class="btn-group">
                                <button type="button" style="border: solid 1px;"  class="btn px-3 py-3" :class="{'btn-success-v2': appointmentDetails.selectedDuration === '1'}" @click="selectDuration('1')"> 1 hour </button>
                                <button type="button" style="border: solid 1px;"  class="btn px-3 py-3" :class="{'btn-success-v2': appointmentDetails.selectedDuration === '1.5'}" @click="selectDuration('1.5')"> 1.5 hours </button>
                                <button type="button" style="border: solid 1px;"  class="btn px-3 py-3" :class="{'btn-success-v2': appointmentDetails.selectedDuration === '2'}" @click="selectDuration('2')">2 hours</button>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>

                      <div class="row  mb-3">
                        <div class="col-sm-12">
                          <div class="pb-0 d-flex justify-content-between">
                            <h6 class="card-title mb-0"><i class="fa-regular fa-user"></i> Contact Information</h6>
                            <div class="card-title mb-2">
                              <a class="btn btn-outline-primary me-2" style="height: 35px !important" v-if="customerFieldsOnEdit" @click="handleNewCustomer">NEW CONTACT</a>
                              <!-- <a class="btn btn-outline-danger" style="height: 35px !important" v-if="customerFieldsDisabled" @click="handleEditCustomer">EDIT</a> -->
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="mb-3 row">
                        <div class="col-sm-12 col-md-12">
                            <div class="mb-3">
                                <multiselect 
                                    v-model="selectedContact" 
                                    :options="customerOptions" 
                                    :searchable="true"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    placeholder="New Contact"
                                    label="name"
                                    track-by="name"
                                    :allow-empty="false"
                                    @select="populateFormWithCustomer">
                                </multiselect>
                            </div>
                            
                        </div>
                        
                        <div  v-if="this.formType == 'On-Site Estimate'" class="col-sm-12 col-md-12">
                          
                          <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                              <label class="form-label f-w-600">Lead Source</label>
                              <div v-if="!sourceLoading">
                                <a
                                  class="badge badge-dark cursor-pointer"
                                  style="height: 20px !important"
                                  @click="populateSource"
                                  id="edit-lead-reset-source"
                                  >Reset</a
                                >
                                <a
                                  class="badge badge-primary cursor-pointer"
                                  data-bs-toggle="modal"
                                  data-original-title="sourceModal"
                                  data-bs-target="#sourceModal"
                                  @click="handleSourceClick('add')"
                                  style="height: 20px !important"
                                  >Add</a
                                >
                                <a
                                  class="badge badge-secondary cursor-pointer"
                                  data-bs-toggle="modal"
                                  data-original-title="sourceModal"
                                  data-bs-target="#sourceModal"
                                  @click="handleSourceClick('edit')"
                                  style="height: 20px !important"
                                  v-if="leadForm.source_ids.length != 0"
                                  >Edit</a
                                >
                              </div>
                            </div>
                            <Select2
                              v-model="leadForm.source_ids"
                              :className="'container-style-outlined-no-hover'"
                              :placeholder="'Select Sources'"
                              :id="'edit-lead-source-list'"
                              :purpose="'multiple-select'"
                              :items="sources"
                              :isLoading="sourceLoading"
                              :disabled="processing"
                            />
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                          <div>
                            <label class="form-label f-w-600">First Name</label>
                            <input
                                class="form-control b-primary-v2"
                                type="text"
                                placeholder="..."
                                name="first_name"
                                v-model="form.first_name"
                                @input="handleInput"
                                required
                            />
                            <div class="text-danger" v-if="form.errors.first_name">{{ form.errors.first_name }}</div>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                          <div class="mb-3">
                            <label class="form-label f-w-600">Last Name</label>
                            <input
                                class="form-control b-primary-v2"
                                type="text"
                                placeholder="..."
                                name="last_name"
                                v-model="form.last_name"
                                @input="handleInput"
                                required
                            />
                            <div class="text-danger" v-if="form.errors.last_name">{{ form.errors.last_name }}</div>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="mb-3">
                              <div class="d-flex justify-content-between align-items-center">
                                <label class="form-label f-w-600">Mobile Phone</label>
                                <a class="badge badge-dark" style="height: 20px !important; cursor: pointer" @click="handlePhoneClick" id="check-schedule">Add Phone</a>
                              </div>
                              <div v-for="(phone, index) in form.phones" :key="index" class="mb-3">
                                <input
                                  class="form-control b-primary-v2"
                                  placeholder="..."
                                  v-model="form.phones[index]"
                                  :name="'phone' + index"
                                  @input="handleInput"
                                  required
                                  v-mask="'(###) ###-####'"
                                />
                                <a class="badge badge-danger" style="cursor: pointer" @click="removePhone(index)" v-if="form.phones.length > 1">Remove</a>
                                <div class="text-danger" v-if="form.errors.phones && form.errors.phones[index]">{{ form.errors.phones[index] }}</div>
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="mb-3">
                              <div class="d-flex justify-content-between align-items-center">
                                <label class="form-label f-w-600">Email Address</label>
                                <a class="badge badge-dark" style="height: 20px !important; cursor: pointer" @click="handleEmailClick" id="add-email">Add Email</a>
                              </div>
                              <div v-for="(email, index) in form.emails" :key="index" class="mb-3">
                                <input
                                  class="form-control b-primary-v2"
                                  placeholder="..."
                                  v-model="form.emails[index]"
                                  :name="'phone' + index"
                                  @input="handleInput"
                                  required
                                />
                                <a class="badge badge-danger" style="cursor: pointer" @click="removeEmail(index)" v-if="form.emails.length > 1">Remove</a>
                                <div class="text-danger" v-if="form.errors.emails && form.errors.emails[index]">{{ form.errors.emails[index] }}</div>
                              </div>
                            </div>
                        </div>
                      </div>


                      <div class="row mb-3">
                        <div class="col-sm-12">
                            <h6 class="card-title mb-0"><i class="fa fa-location-arrow"></i> Appointment Address</h6>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-12">
                          <div class="mb-1">
                              <vue-google-autocomplete
                              id="add_street_address_customer_detail"
                              name="add_street_address_customer_detail"
                              classname="form-control b-primary-v2"
                              placeholder="Home Address"
                              @input="onCustomerAddressChange"
                              required
                              v-on:placechanged="getAddressData"
                              :country="['us']"
                              :type="['address']"
                              >
                              </vue-google-autocomplete>
                              <div class="text-danger" v-if="form.errors.street_address">{{ form.errors.street_address }}</div>
                          </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="mb-3">
                            <label class="form-label f-w-600">City</label>
                            <input
                                class="form-control b-primary-v2"
                                type="text"
                                placeholder="City"
                                name="city"
                                v-model="form.city"
                                @input="handleInput"
                                required
                            />
                            <div class="text-danger" v-if="form.errors.city">{{ form.errors.city }}</div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="mb-1">
                                <label class="form-label f-w-600">State</label>
                                <input
                                    class="form-control b-primary-v2"
                                    type="text"
                                    placeholder="State"
                                    name="state"
                                    v-model="form.state"
                                    @input="handleInput"
                                    required
                                />
                                <div class="text-danger" v-if="form.errors.state">{{ form.errors.state }}</div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="mb-3">
                            <label class="form-label f-w-600">Postal Code</label>
                            <input
                                class="form-control b-primary-v2"
                                type="number"
                                placeholder="ZIP Code"
                                name="zip_code"
                                v-model="form.zip_code"
                                @input="handleInput"
                                required
                            />
                            <div class="text-danger" v-if="form.errors.zip_code">{{ form.errors.zip_code }}</div>
                            </div>
                        </div>
                      </div>

                      
                      <div class="row mb-4">
                        <div class="col-sm-12 mb-3">
                            <h6 class="card-title mb-0"><i class="fa fa-file-text"></i> Appointment Details</h6>
                        </div>

                        <div class="col-sm-12">
                            <textarea class="form-control b-primary-v2"  v-model="appointmentDetails.description" cols="20" data-val="true" data-val-length="The field Details must be a string with a maximum length of 8000." data-val-length-max="8000" id="Appointment_Details" name="Appointment.Details" placeholder="Enter details about this appointment..." rows="2"></textarea>
                        </div>

                      </div>

                      <div class="row" v-if="this.formType != 'On-Site Estimate'">

                        <div class="col-sm-12 mb-4">
                            <h6 class="card-title mb-0"><i class="fa fa-file-text"></i> Communication </h6>
                        </div>

                        <div class="form-group col-6 text-center">
                            <label for="SendEmailNotification">Send Email</label>
                            <div name="SendEmailNotification" class="switch" :class="{ 'on': appointmentDetails.reminder_email }" @click="toggleEmail" style="margin-top: -10px; margin-bottom: -10px; margin-left: 15px;">
                                <div class="switch-handle"></div>
                                <span class="switch-label">{{ appointmentDetails.reminder_email ? 'ON' : 'OFF' }}</span>
                            </div>
                        </div>
                        <div class="form-group col-6 text-center">
                            <label for="SendSmsNotification">Send SMS</label>
                            <div name="SendSmsNotification" class="switch" :class="{ 'on': appointmentDetails.reminder_sms }" @click="toggleSms" style="margin-top: -10px; margin-left: 15px; margin-bottom: -10px">
                                <div class="switch-handle"></div>
                                <span class="switch-label">{{ appointmentDetails.reminder_sms ? 'ON' : 'OFF' }}</span>
                            </div>
                        </div>

                        <div class="form-grounp col-12">
                            <label class="font-weight-bold" for="SendSmsTemplate">SMS Message</label>
                            <textarea class="form-control b-primary-v2" cols="20" id="SendSmsTemplate" name="SendSmsTemplate" rows="2" style="height: 100px;">{{ appointmentDetails.smsTemplate }}</textarea>
                        </div>
                      </div>

                    </div>

                    <!-- <div class="row">
                        <div class="mx-3 p-3">
                            <div class=" b-primary-v2 media align-items-stretch">
                                <div class="d-flex align-items-center bg-success text-success position-relative callout-arrow-left p-2">
                                    <i class="feather icon-info white font-medium-5"></i>
                                </div>
                                <div class="media-body p-1">
                                    <p>By submitting this appointment, a Deal will be created in Estimate Scheduled and Drip Message “Appointment Details” will send <strong>Immediately</strong>.</p>
                                </div>
                            </div>
                        </div>
                    </div> -->

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="card-footer text-end px-4">
                  <button class="btn btn-primary-v2 me-2"  @click="handleSubmit('view', $event)"> Save </button>
                  <button class="btn btn-secondary"  @click="store.close()"> Close </button>
                </div>
              </div>
            </div>
        </div>
    </div>
</template>
<script>
import {  useForm, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";
import { useNewAppointmentSidebar } from '../../stores/new-appointment';

import axios from 'axios';
import Swal from "sweetalert2";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import Select2 from "./../../components/Select2.vue";

import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';

import FullCalendar from "@fullcalendar/vue3";
import SourceModal from "@/Pages/sales/lead/SourceModal.vue";

import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
    components: {
        FullCalendar,
        Select2,
        Multiselect, 
        VueGoogleAutocomplete,
        FlatPickr,
      SourceModal,
    },  
    props: {
        errors: {
            type: [Array],
            default: []
        },
        company: {
            type: [Array],
            default: []
        },
        csrf_token: {
            type: [String],
            default: ""
        },
        style: {
            type: [String],
            default: ""
        },
        auth: {
            type: [String],
            default: ""
        },
        lead: {
            type: [String],
            default: ""
        },
    },
    setup(){
        const page = usePage();
        const store = useNewAppointmentSidebar();

        const form = useForm({
            cust_id: 0,
            first_name: "",
            last_name: "",
            display_name: "",
            phone: "",
            cell_phone: "",
            email: "",
            company: "",
            street_address: "",
            city: "",
            state: "",
            zip_code: "",
            phones: [''],
            emails: [''],
        });

        const leadForm = useForm({
            lead_id: 0,
            cust_id: 0,
            opportunity_title: "",
            street_address: "",
            city: "",
            state: "",
            zipcode: "",
            opportunity_phone: "",
            status: "open",
            description: "",
            cost_of_lead: 0,
            created_by: "",
            updated_by: "",
            tag_ids: [],
            source_ids: [],
            jobtype_ids: [],
            salesperson_ids: [],
            appointment: [],
            stage_id: 2,
            stage_date: new Date(),
            reminder: false,
            followup: false,
        });

        const appointmentDetails = useForm({
            salespeople: [],
            apptDate: new Date().toISOString().substring(0, 10),
            startDate: "",
            endDate: "",
            appointedBy: 0,
            selectedSalesId: 0,
            selectedTime: {
              name: "07:15 AM",
              value: "07:15 AM"
            },
            title: '',
            description: '',
            selectedColor:'purple',
            selectedDuration: '15',
            reminder_sms: false,
            reminder_email: false,
            smsTemplate: "Hi, {first-name}! We've scheduled your {event-type} for {appointment-time} on {appointment-date} at {appointment-location} with {assigned-user}. Please let us know if you have any questions or need to make changes! Thank you! - {company-name}",
            emailTemplate: "",
        });
        return { store, page, form, leadForm, appointmentDetails }
    },
    data(){
        const showing = false;
        const loading = false;
        const customerFieldsDisabled = false;
        const customerFieldsOnEdit = false;
        const processing = false;
        const sources = [];
        const sourceLoading = false;
        const sourceAction = "";
        const salespersons = [];
        const userData = [];
        const userLoading = false;
        const appointedBy = [];
        const closeSendOption = false;
        const leadData = null;
        const customerData = null;
        const initialFormState = null;

        const selectedContact = null;
        const customerOptions = [];

        const apptDateConfig = {
          enableTime: false,
          dateFormat: "Y-m-d",
          time_24hr: false,
          allowInput: true,
          minuteIncrement: 30,
          defaultDate: this.appointmentDetails.apptDate
        }

        const timeOptions = [];

        const eventColors = [
          { text: 'Purple', value: 'purple', textColor: 'white' },
          { text: 'Red', value: 'red', textColor: 'white' },
          { text: 'Salmon', value: 'salmon', textColor: 'white' },
          { text: 'Orange', value: 'orange', textColor: 'black' },
          { text: 'Yellow', value: 'yellow', textColor: 'black' },
          { text: 'Mint', value: 'mintcream', textColor: 'black' },
          { text: 'Green', value: 'green', textColor: 'white' },
          { text: 'Dark Blue', value: 'darkblue', textColor: 'white' },
          { text: 'Light Blue', value: 'lightblue', textColor: 'black' },
          { text: 'Pink', value: 'pink', textColor: 'black' },
          { text: 'Gray', value: 'gray', textColor: 'white' }
        ];

        return { showing, loading,customerFieldsDisabled,customerFieldsOnEdit,processing,sources,salespersons,userData,userLoading,appointedBy,closeSendOption,leadData,customerData,initialFormState,sourceAction,selectedContact,customerOptions,apptDateConfig,sourceLoading,timeOptions,eventColors }
    },
    methods: {
      updateVisibility() {
          if (this.store.isOpen) {

            this.customerFieldsOnEdit = false;
            this.selectedContact = null;
            this.customerFieldsDisabled = false;
            this.form.cust_id = 0;
            this.form.first_name = "";
            this.form.last_name = "";
            this.form.display_name =  "";
            this.form.phone= "";
            this.form.cell_phone = "";
            this.form.email = "";
            this.form.company = "";
            this.form.street_address = "";
            this.form.city = "";
            this.form.state = "";
            this.form.zip_code = "";
            this.form.phones = [''];
            this.form.emails = [''];

            this.appointmentDetails.apptDate = "";
            this.appointmentDetails.startDate = "";
            this.appointmentDetails.endDate = "";
            this.appointmentDetails.appointedBy = 0;
            this.appointmentDetails.selectedSalesId = 0;

              this.fetchSalesPersons();
              // this.getCalendarEvents();
              this.fetchCustomers();
              this.fetchUserData();
              this.generateTimeOptions();
              this.getAllSource();
              this.showing = true;

          } else {
              setTimeout(() => {
                  this.showing = false;
              }, 500);
          }
      },
      toggleSms() { 
        this.appointmentDetails.reminder_sms = !this.appointmentDetails.reminder_sms;
      },
      toggleEmail() { 
        this.appointmentDetails.reminder_email = !this.appointmentDetails.reminder_email;
      },
      selectDuration(duration) {
        this.appointmentDetails.selectedDuration = duration;
      },
      textColor(value) {
        const color = this.eventColors.find(c => c.value === value);
        return color ? color.textColor : 'black';
      },
      updateBackgroundColor() {
        // This method is not necessary as Vue.js will reactively update the style binding when selectedColor changes
      },
      onCustomerAddressChange(value) {
        this.form.street_address = value.target.value;
      },
      handleEditCustomer() {
        this.customerFieldsDisabled = false;
        this.customerFieldsOnEdit = true;
      },
      handleNewCustomer() {
        this.form.cust_id = 0;
        this.form.first_name = "";
        this.form.last_name = "";
        this.form.display_name = "";
        this.form.phone = "";
        this.form.cell_phone = "";
        this.form.email = "";
        this.form.company = "";
        this.form.street_address = "";
        this.form.city = "";
        this.form.state = "";
        this.form.zip_code = "";
        this.selectedContact = null;

        this.customerFieldsOnEdit = false;
        this.customerFieldsDisabled = false;
      },
      hasFormChanged() {
        return Object.keys(this.form).some((key) => this.form[key] !== this.initialFormState[key]);
      },
      populateFormWithCustomer() {
        this.form.cust_id = this.selectedContact.cust_id;
        this.form.first_name = this.selectedContact.first_name;
        this.form.last_name = this.selectedContact.last_name;
        this.form.display_name = this.selectedContact.display_name;
        this.form.phone = this.selectedContact.phone;
        this.form.cell_phone = this.selectedContact.cell_phone;
        this.form.email = this.selectedContact.email;
        this.form.company = this.selectedContact.company;
        this.form.street_address = this.selectedContact.street_address;
        this.form.city = this.selectedContact.city;
        this.form.state = this.selectedContact.state;
        this.form.zip_code = this.selectedContact.zip_code;
        // this.customerFieldsDisabled = true;

        ////////// phones and emails /////////////////
        this.form.phones = this.selectedContact.phone.split(',');
        this.form.emails = this.selectedContact.email.split(',');

        $("#add_street_address_customer_detail").val(this.form.street_address);
        this.initialFormState = { ...this.form };
      },
      handleInput(e) {
        // this.leadForm.clearErrors(e.target.name);
        this.form.clearErrors(e.target.name);
      },
      async handleSubmit(type, event) {
        this.processing = true;
        event.preventDefault();

        //if (stage == "4") estimated schedule, Require appointment date

        //if (apptdate exist and start time doesnt, promt error)

        ////////////////////////// SAVE/UPDATE CUSTONER ////////////////////////////////////////////////

        if (this.leadForm.cust_id === 0) {
          try {
            const customerResponse = await this.saveCustomer();
            if (customerResponse.data.status !== "success") {
              this.initialFormState = { ...this.form };
              this.processing = false;
              return;
            }
          } catch (error) {
            this.processing = false;
            return;
          }
        } else if (this.hasFormChanged()) {
          try {
            await this.updateCustomer();
          } catch (error) {
            this.processing = false;
            return;
          }
        }

        ////////////////////////// SAVE APPOINTMENT ////////////////////////////////////////////////
        try {
          if (this.leadForm.opportunity_phone) {
            this.leadForm.opportunity_phone = this.leadForm.opportunity_phone.replace(/\D/g, "");
          }

          this.appointmentDetails.appointedBy = this.appointedBy[0];
          this.leadForm.appointment = this.appointmentDetails;

          const url = this.leadForm.lead_id ? `/api/updateLead/${this.leadForm.lead_id}` : "/api/saveLead";
          const response = await axios.post(url, this.leadForm, {
            headers: {
              Authorization: "Bearer " + this.page.props.csrf_token,
              Accept: "application/json",
              "X-Requested-With": "XMLHttpRequest",
            },
          });

          if (response.data.status === "success") {
            const lead_id = response.data.data.id;

            this.customerFieldsDisabled = false;
            this.form.reset();
            this.leadForm.reset();

            this.leadForm.salesperson_ids = [];
            this.leadForm.tag_ids = [];
            this.leadForm.source_ids = [];
            this.leadForm.jobtype_ids = [];

            $("#add_street_address_customer_detail").val("");

            if (type === "view") {
              this.processing = true;
              Inertia.get(`/sales/lead-management/view-lead/${lead_id}`);
            } else if (type === "proposal") {
              this.processing = true;
              Inertia.get(`/sales/lead-management/proposal/0/${lead_id}`);
            } else if (type === "close") {
              this.processing = true;
              Inertia.get("/sales/lead-management");
            } else if (type === "new") {
              this.processing = true;
              Inertia.get(`/sales/lead-management/new`);
              // Clear Form
            }

            Swal.fire({
              icon: "success",
              title: "Success!",
              text: "Data has been sent successfully!",
            });
          } else if (response.data.status === "error" && response.data.errors) {
            for (const [field, error] of Object.entries(response.data.errors)) {
              this.leadForm.errors[field] = error[0];
            }
          }

          this.processing = false;
        } catch (error) {
          this.processing = false;
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "There was a problem when saving the data!",
          });
        }
      },
      async saveCustomer() {
        // this.customerFieldsDisabled = true;
        try {
          if (this.form.phone) {
            this.form.phone = this.form.phone.replace(/\D/g, "");
          }
          const response = await axios.post("/api/saveCustomer", this.form, {
            headers: {
              Authorization: "Bearer " + this.page.props.csrf_token,
              Accept: "application/json",
              "X-Requested-With": "XMLHttpRequest",
            },
          });

          if (response.data.status === "success") {
            //this.leadForm.cust_id = response.data.data.id;
            this.form.cust_id = response.data.data.id;
            //this.customerFieldsDisabled = true;
          } else if (response.data.status === "error" && response.data.errors) {
            for (const [field, error] of Object.entries(response.data.errors)) {
              form.errors[field] = error[0];
            }
            // this.customerFieldsDisabled = false;
          }
          return response; // Return the axios response
        } catch (error) {
          // this.customerFieldsDisabled = false;
          throw error; // Throw the error to be caught in the calling function
        }
      },
      async updateCustomer() {
        //this.customerFieldsDisabled = true;
        try {
          if (this.form.phone) {
            this.form.phone = this.form.phone.replace(/\D/g, "");
          }
          const response = await axios.post(`/api/updateCustomer/${this.form.cust_id}`, this.form, {
            headers: {
              Authorization: "Bearer " + this.page.props.csrf_token,
              Accept: "application/json",
              "X-Requested-With": "XMLHttpRequest",
            },
          });

          if (response.data.status !== "success") {
            throw new Error("Failed to update customer");
          }
          return response;
        } catch (error) {
          throw error;
        }
      },
      async fetchSalesPersons() {
        try {
          this.userLoading = true;
          const response = await axios.get("/api/userContacts", {
            headers: {
              Authorization: "Bearer " + this.page.props.csrf_token,
              Accept: "application/json",
              "X-Requested-With": "XMLHttpRequest",
            },
          });
          const data = response.data;
          this.salespersons = Object.values(data.data).map((userDetails) => {
            if (userDetails.user_id) {
              return {
                text: userDetails.display_name,
                id: userDetails.user_id ? userDetails.user_id : userDetails.cust_id,
                email: userDetails.email,
                phone: userDetails.phone,
              };
            } else {
              return false;
            }
          });

          // this.$nextTick(() => {
          //   document.querySelector("#edit-lead-reset-salesperson").click();
          // });

          this.userLoading = false;
        } catch (error) {
          console.error("Error fetching customers: ", error);
        }
      },
      async getAddressData(addressData, placeResultData, id) {
        const placeAddress = placeResultData.address_components;

        let streetAddress = "";

        for (const component of placeAddress) {
          const componentType = component.types[0];
          switch (componentType) {
            case "street_number":
              streetAddress = component.long_name;
              break;
            case "route":
              streetAddress += " " + component.long_name;
              break;
            case "postal_code":
              this.leadForm.zipcode = component.long_name;
              this.form.zip_code = component.long_name;
              break;
            case "administrative_area_level_1":
              this.leadForm.state = component.long_name;
              this.form.state = component.long_name;
              break;
            case "administrative_area_level_2":
              this.leadForm.state = component.long_name;
              this.form.state = component.long_name;
              break;
            case "neighborhood":
              this.leadForm.city = component.long_name;
              this.form.city = component.long_name;
              break;
          }
        }

        $("#add_street_address_customer_detail").val(streetAddress);
        this.form.street_address = streetAddress;
        this.leadForm.street_address = streetAddress;
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
          //this.customerOptions = Object.values(data.data).filter(userDetails => userDetails.cust_id);
          this.customerOptions = Object.values(data.data)
          .filter(userDetails => userDetails.cust_id)
          .map(userDetails => ({
              ...userDetails,
              value: userDetails.cust_id,
              name: userDetails.display_name
          }));
          this.loading = false;
        } catch (error) {
          console.error("Error fetching customers: ", error);
        }
      },
      generateTimeOptions() {
        const options = [];
        for (let hour = 7; hour <= 8; hour++) {
          for (let minutes = 0; minutes < 60; minutes += 15) {
            // Break the loop after 8:30 AM
            if (hour === 8 && minutes > 30) {
              break;
            }
            
            // Format the hour to a 12-hour format with leading zero
            const hourFormatted = hour.toString().padStart(2, '0');

            // Format minutes to have leading zero
            const minutesFormatted = minutes.toString().padStart(2, '0');

            // Create the display value for the option
            const timeDisplay = `${hourFormatted}:${minutesFormatted} AM`;
            options.push({ value: timeDisplay, name: timeDisplay });
          }
        }

        this.timeOptions = options;
      },
      async fetchUserData() {
        try {
          this.userLoading = true;
          const response = await axios.get('/api/users', {
            headers: {
              'Authorization': 'Bearer ' + this.page.props.csrf_token,
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          });
          const data = response.data;
          //this.customerOptions = Object.values(data.data).filter(userDetails => userDetails.cust_id);
          this.userData = Object.values(data.data)
          .filter(userDetails => userDetails.user_id)
          .map(userDetails => ({
              ...userDetails,
              id: userDetails.user_id,
              text: userDetails.display_name
          }));
          this.userLoading = false;
        } catch (error) {
          console.error("Error fetching customers: ", error);
        }
      },
      handleDateRange(apptDate) {
        this.appointmentDetails.apptDate = apptDate.toLocaleString();
      },
      handlePhoneClick(){
        this.form.phones.push('');
      },
      removePhone(index){      
        this.form.phones.splice(index, 1);
      },
      handleEmailClick(){
        this.form.emails.push('');
      },
      removeEmail(index){      
        this.form.emails.splice(index, 1);
      },
      getCalendarEvents(){
        axios.get('/api/calendar/getData').then(response => {
          this.eventSources  = response.data.data;
        });
      },
      getLeadTitleVersion(title){
        axios.get('/api/leads/getLeadTitleVersion',{
            params: {
              'opportunity_title': title
            }
          }).then(response => {
            if(response.data.opportunityTitleVersion > 0){
              const version = Number(response.data.opportunityTitleVersion) + 1;
              this.leadForm.opportunity_title = title + " V" + version;
            }else{
              this.leadForm.opportunity_title = title;
            }
        });
      },

    /////////////////////////////////// LEAD SOURCE ////////////////////////////////////////////////////////////
      populateSource() {
        if (this.page.props.lead && this.page.props.lead.sources) {
          const sourcesData = Object.values(this.page.props.lead.sources).map((source) => source.source_id);
          this.leadForm.source_ids = sourcesData;
        }
      },
      async getAllSource() {
        try {
          this.sourceLoading = true;
          const response = await axios.get("/api/sources", this.form, {
            headers: {
              Authorization: "Bearer " + this.page.props.csrf_token,
              Accept: "application/json",
              "X-Requested-With": "XMLHttpRequest",
            },
          });

          if (response.status === 200) {
            const data = response.data;
            this.sources = Object.values(data.data).map((source) => {
              return {
                id: source.source_id,
                text: source.source_name,
              };
            });

            this.sourceLoading = false;

            this.$nextTick(() => {
              document.querySelector("#edit-lead-reset-source").click();
            });
          } else {
            this.sourceLoading = false;
            console.log(response);
          }
        } catch (error) {
          this.sourceLoading = false;
          console.log(error);
        }
      },
      handleSourceClick(type) {
        this.sourceAction = type;
      },
      handleSourceChange(value) {
        const type = value.type;
        const source = value.value;

        if (type === "add") {
          this.sources.push({
            id: source.id,
            text: source.text,
          });
        } else if (type === "edit") {
          this.sources = this.sources.map((item) => {
            if (item.id === source.id) {
              return { ...item, text: source.text };
            }
            return item;
          });
        } else if (type === "delete") {
          this.sources = this.sources.filter((item) => item.id !== source.id);
        }
      },
      getSelectedSource(id) {
        return this.sources.find((item) => item.id == id);
      },

    },
    computed: {
        isOpen() {
            return this.store.isOpen;
        },
        first_name() {
            return this.form.first_name;
        },
        last_name() {
            return this.form.last_name;
        },
        display_name() {
            return this.form.display_name;
        },
        street_address() {
            return this.form.street_address;
        },
        formType() {
          return this.store.formType;
        },
        apptDate() {
          return this.appointmentDetails.apptDate;
        },
        selectedTime() {
          return this.appointmentDetails.selectedTime;
        },
        selectedDuration() {
          return this.appointmentDetails.selectedDuration;
        }
    },
    watch: {
        isOpen: {
            handler() {
                this.updateVisibility();
            }
        },
        first_name: {
          handler(newFirstName) {
            this.form.display_name = `${newFirstName} ${this.form.last_name}`;
          },
        },
        last_name: {
          handler(newLastName) {
            this.form.display_name = `${this.form.first_name} ${newLastName}`;
          },
        },
        display_name: {
          handler(newDisplayname) {
              const temp_display_name = `${newDisplayname} - ${this.form.street_address}`;
              this.getLeadTitleVersion(temp_display_name);
          },
        },
        formType: {
          handler(newValue) {
            // if(newValue == "lead"){
            //   this.leadForm.stage_id = 2;
            // }else if(newValue == "proposal"){
            //   this.leadForm.stage_id = 5;
            // }
          }
        },
        street_address: {
          handler(newAddress) {
              this.leadForm.opportunity_title = `${this.form.display_name} - ${newAddress}`;
          },
        },
        customerFieldsDisabled: {
          handler(newValue) {
              $("#add_street_address_customer_detail").prop("disabled", newValue);
          },
        },
        processing: {
          handler(newValue) {
              //$("#street_address_new_lead").prop("disabled", newValue);
          },
        },
        apptDate: {
            handler(newVal, oldVal) {
                console.log(`Appointment apptDate changed from ${oldVal} to ${newVal}`);

                //set start date and end date
                
            },
            deep: true,
        },
        selectedTime: {
            handler(newVal, oldVal) {
                console.log(`Appointment selectedTime changed from ${oldVal} to ${newVal}`);
                console.log(`SelectedTime`, newVal);
                
            },
            deep: true,
        },
        selectedDuration: {
            handler(newVal, oldVal) {
                console.log(`Appointment selectedDuration changed from ${oldVal} to ${newVal}`);
                
            },
            deep: true,
        },
    },
}
</script>

<style scoped>
    .switch {
    width: 80px;
    height: 30px;
    background-color: #ccc;
    border-radius: 15px;
    position: relative;
    padding: 5px;
    box-sizing: border-box;
    cursor: pointer;
    transition: background-color 0.2s;
    user-select: none;
    }

    .switch.on {
    background-color: #4cd964;
    }

    .switch-handle {
    width: 30px;
    height: 30px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    left: 0;
    top: 0;
    transition: left 0.2s;
    }

    .switch.on .switch-handle {
    left: 50px;
    }

    .switch-label {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    font-size: 12px;
    font-weight: bold;
    color: #fff;
    }

    .switch.on .switch-label {
    right: auto;
    left: 10px;
    color: #fff;
    }

  .icon-with-tooltip {
    position: relative;
    display: inline-block;
  }

  .icon-with-tooltip .custom-tooltip {
    visibility: hidden;
    width: 150px;
    background-color: white;
    color: black;
    text-align: left;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    top: 120%;
    left: 100%;
    margin-left: -10px;
    padding-left: 10px;
    opacity: 0;
    transition: opacity 0.3s;
    border: solid 1px black;
  }

  .icon-with-tooltip:hover .custom-tooltip {
    visibility: visible;
    opacity: 1;
  }
</style>

<style>
 .multiselect {
        border: 1px solid #1e5bb2 !important;
        border-radius: 0.25rem;
        min-height: 10px !important;
        height: 35px !important;
    }

  .multiselect--active .multiselect__tags {
      border: none;
  }

  .multiselect__content-wrapper {
      border: 1px solid #1e5bb2;
      border-top: none;
  }

  .multiselect .multiselect__tags {
      min-height: 10px !important;
      display: block;
      padding: 5px 40px 0 5px !important;
      border-radius: 5px;
      border: 1px solid #e8e8e8;
      background: #fff;
      font-size: 14px;
      height: 35px !important;
  }

  .multiselect .multiselect__select{
    height: 35px !important;
  }
</style>