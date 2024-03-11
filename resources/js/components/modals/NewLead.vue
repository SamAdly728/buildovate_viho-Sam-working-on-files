<template>
    <div class="modal-transparent d-flex" style="position: absolute; left: 0; top: 0; bottom: 0; right: 0; z-index: 500;" v-if="showing">
        <div style="width: 50%;" class="bg-white shadow-lg d-flex flex-column" :class="this.isOpen ? 'right-slide-animation-in' : 'right-slide-animation-out'">
            <div class="d-flex align-items-center">
                <h5 v-if = "this.formType == 'lead'"  class="p-3 f-w-600 text-dark m-0 p-0 flex-grow-1" style="height: 55px;">New Lead</h5>
                <h5 v-else-if = "this.formType == 'proposal'"  class="p-3 f-w-600 text-dark m-0 p-0 flex-grow-1" style="height: 55px;">New Proposal</h5>
                <a style="cursor: pointer;" @click="store.close()" class="p-3"><i class="icon-close"></i></a>
            </div>
            <div class="flex-grow-1 bg-main" style="max-height: calc(100vh - 51px); overflow-y: auto;">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card b-primary-v2">
                            <div class="card-header pb-0 d-flex justify-content-between">
                                <h6 class="card-title mb-0"><i class="fa-regular fa-user"></i> Contact Information</h6>
                                <div>
                                  <a class="btn btn-outline-primary me-2" style="height: 35px !important" v-if="customerFieldsOnEdit || customerFieldsDisabled" @click="handleNewCustomer">NEW CONTACT</a>
                                  <a class="btn btn-outline-danger" style="height: 35px !important" v-if="customerFieldsDisabled" @click="handleEditCustomer">EDIT</a>
                                </div>
                            </div>
                            <div class="card-body m-0 pt-2">
                                <form method="POST">
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
                                            :disabled="customerFieldsDisabled"
                                        />
                                        <div class="text-danger" v-if="form.errors.first_name">{{ form.errors.first_name }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div>
                                        <label class="form-label f-w-600">Last Name</label>
                                        <input
                                            class="form-control b-primary-v2"
                                            type="text"
                                            placeholder="..."
                                            name="last_name"
                                            v-model="form.last_name"
                                            @input="handleInput"
                                            required
                                            :disabled="customerFieldsDisabled"
                                        />
                                        <div class="text-danger" v-if="form.errors.last_name">{{ form.errors.last_name }}</div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="mb-3">
                                    <label class="form-label f-w-600">Display Name</label>
                                    <input
                                        class="form-control b-primary-v2"
                                        placeholder="..."
                                        v-model="form.display_name"
                                        name="display_name"
                                        @input="handleInput"
                                        required
                                        :disabled="customerFieldsDisabled"
                                    />
                                    <div class="text-danger" v-if="form.errors.display_name">{{ form.errors.display_name }}</div>
                                    </div>
                                    <hr />
                                    <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label f-w-600">Jobsite Address</label>
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
                                    <div class="row">
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
                                                :disabled="customerFieldsDisabled"
                                            />
                                            <div class="text-danger" v-if="form.errors.city">{{ form.errors.city }}</div>
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
                                                :disabled="customerFieldsDisabled"
                                            />
                                            <div class="text-danger" v-if="form.errors.zip_code">{{ form.errors.zip_code }}</div>
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
                                                    :disabled="customerFieldsDisabled"
                                                />
                                                <div class="text-danger" v-if="form.errors.state">{{ form.errors.state }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="row">
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
                                                  :disabled="customerFieldsDisabled"
                                                  v-mask="'(###) ###-####'"
                                                />
                                                <a class="badge badge-danger" style="cursor: pointer" @click="removePhone(index)" v-if="form.phones.length > 1">Remove</a>
                                                <div class="text-danger" v-if="form.errors.phones && form.errors.phones[index]">{{ form.errors.phones[index] }}</div>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <!-- <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                  <label class="form-label f-w-600">Email Address</label>
                                                  <a  class="badge badge-dark" style="height: 20px !important; cursor: pointer" @click="handleEmailClick" id="check-schedule">Add Email</a>
                                                </div>
                                                <input
                                                    class="form-control b-primary-v2"
                                                    placeholder="..."
                                                    v-model="form.email"
                                                    name="email"
                                                    @input="handleInput"
                                                    required
                                                    :disabled="customerFieldsDisabled"
                                                />
                                                <div class="text-danger" v-if="form.errors.email">{{ form.errors.email }}</div>
                                            </div> -->

                                            
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
                                                  :disabled="customerFieldsDisabled"
                                                />
                                                <a class="badge badge-danger" style="cursor: pointer" @click="removeEmail(index)" v-if="form.emails.length > 1">Remove</a>
                                                <div class="text-danger" v-if="form.errors.emails && form.errors.emails[index]">{{ form.errors.emails[index] }}</div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <!-- <div class="mb-3">
                                                <label class="form-label f-w-600">Lead Source</label>
                                                <input
                                                    class="form-control b-primary-v2"
                                                    placeholder="..."
                                                    v-model="form.company"
                                                    name="company"
                                                    @input="handleInput"
                                                    required
                                                    :disabled="customerFieldsDisabled"
                                                />
                                                <div class="text-danger" v-if="form.errors.company">{{ form.errors.company }}</div>
                                            </div> -->

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
                                            <div class="mb-3">
                                              <label class="form-label f-w-600">Stage</label>
                                              <div class="icon-with-tooltip">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                <span class="custom-tooltip">Cold Leads <br> Warm Leads <br> Estimated Requested <br> Estimated Scheduled </span>
                                              </div>

                                              <select class="form-select b-primary-v2" v-model="leadForm.stage_id" name="stage" required>
                                                <option value="0" disabled selected>Select a deal stage...</option>
                                                <option value="1">Cold Leads</option>
                                                <option value="2">Warm Leads</option>
                                                <option value="3">Estimated Requested</option>
                                                <option value="4">Estimated Scheduled</option>
                                                <option v-if = "this.formType == 'proposal'" value="5">In Draft</option>
                                              </select>
                                              <div class="text-danger" v-if="leadForm.errors.stage_id">{{ leadForm.errors.stage_id }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="formType == 'proposal'" class="row">
                                      <div class="col-md-6">
                                          <label class="form-label w-100">Follow Up <i class="fa fa-info-circle" aria-hidden="true"></i></label>
                                          <div class="switch" :class="{ 'on': leadForm.followup }" @click="toggleFollowup">
                                              <div class="switch-handle"></div>
                                              <span class="switch-label">{{ leadForm.followup ? 'ON' : 'OFF' }}</span>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <label class="form-label w-100">Reminder <i class="fa fa-info-circle" aria-hidden="true"></i></label>
                                          <div class="switch" :class="{ 'on': leadForm.reminder }" @click="toggleReminder">
                                              <div class="switch-handle"></div>
                                              <span class="switch-label">{{ leadForm.reminder ? 'ON' : 'OFF' }}</span>
                                          </div>
                                      </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <div  v-if="this.formType == 'lead'" class="card b-primary-v2" style="margin-top: -15px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label f-w-600">Lead Title</label>
                                    <input
                                    class="form-control b-primary-v2"
                                    type="text"
                                    placeholder="Enter title..."
                                    v-model="leadForm.opportunity_title"
                                    name="opportunity_title"
                                    @input="handleInput"
                                    required
                                    :disabled="processing"
                                    />
                                    <div class="text-danger" v-if="leadForm.errors.opportunity_title">
                                    {{ leadForm.errors.opportunity_title }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label w-100">Follow Up <i class="fa fa-info-circle" aria-hidden="true"></i></label>
                                <div class="switch" :class="{ 'on': leadForm.followup }" @click="toggleFollowup">
                                    <div class="switch-handle"></div>
                                    <span class="switch-label">{{ leadForm.followup ? 'ON' : 'OFF' }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label w-100">Reminder <i class="fa fa-info-circle" aria-hidden="true"></i></label>
                                <div class="switch" :class="{ 'on': leadForm.reminder }" @click="toggleReminder">
                                    <div class="switch-handle"></div>
                                    <span class="switch-label">{{ leadForm.reminder ? 'ON' : 'OFF' }}</span>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                            <div class="mb-1 col-md-6">
                                <label class="form-label f-w-600">Description</label>
                                <textarea
                                class="form-control b-primary-v2"
                                rows="5"
                                placeholder="Enter lead description..."
                                v-model="leadForm.description"
                                name="description"
                                @input="handleInput"
                                :disabled="processing"
                                >
                                </textarea>
                                <div class="text-danger" v-if="leadForm.errors.description">{{ leadForm.errors.description }}</div>
                            </div>
                            <div class="col-md-6 d-flex flex-column gap-3 m-0 p-0">
                                <div>
                                <label class="form-label f-w-600">Appointment Set By</label
                                ><a @click="addDefaultUser" id="appointment_by" style="visibility: hidden">Test</a>
                                <Select2
                                    v-model="appointedBy"
                                    :className="'container-style-outlined-no-hover'"
                                    :placeholder="'Select Crew Member'"
                                    :id="'new-lead-appointed-by'"
                                    :purpose="'multiple-select'"
                                    :items="userData"
                                    :isLoading="userLoading"
                                    :disabled="processing"
                                />
                                </div>
                                <div class="row m-0 p-0">
                                <div class="col-md-12 mb-6 p-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label f-w-600">Appointment Date</label>
                                    <a  class="badge badge-dark"
                                        style="height: 20px !important; cursor: pointer"
                                        @click="handleResetCalendarClick"
                                        id="check-schedule"
                                        >Reset Date</a
                                    >
                                    </div>
                                    <flat-pickr
                                      ref="flatpickr"
                                      class="form-control b-primary-v2 bg-white"
                                      v-model="appointmentDetails.apptDate"
                                      :config="apptDateConfig"
                                      placeholder="Select date and time"
                                      name="appointment_date"
                                      :disabled="processing"
                                    ></flat-pickr>
                                    <span v-if="appointmentDetails.apptDate">
                                      <small> {{ extractTime(appointmentDetails.startDate) }} -  {{ extractTime(appointmentDetails.endDate) }}  </small>
                                    </span>
                                </div>
                                </div>
                            </div>
                            </div>
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
        <div class="bg-white shadow-lg d-flex flex-column" v-if="this.isCalendarOpen && this.formType == 'lead'" :class="this.isCalendarOpen ? 'right-slide-animation-in' : 'right-slide-animation-out'">
            <div class="d-flex align-items-center" style="background-color: white;">
                <h5 class="p-3 f-w-600 text-dark m-0 p-0 flex-grow-1" style="height: 55px;">Calendar Schedule</h5>
                <a style="cursor: pointer;" @click="this.isCalendarOpen = !this.isCalendarOpen" class="p-3"><i class="icon-close"></i></a>
            </div>
            <!-- <div style="height: 1px; width: 100%;" class="bg-primary"></div> -->
            <div class="flex-grow-1 bg-main" style="max-height: calc(100vh - 51px); overflow: hidden;">
                <div class="d-flex justify-content-center align-items-center f-14 f-w-600 text-muted py-2" v-if="loading">
                    <i class="fa fa-spin fa-spinner me-2"></i>Loading...
                </div>
                <div class="slim-scroll-gray d-flex flex-column gap-3 py-3" style="max-height: calc(100vh - 51px); overflow: auto;">
                    <div class="mx-1">
                        <label class="form-label f-w-600">SalesPerson</label>
                        <select ref="selectInstance" id="salesperson" v-model="appointmentDetails.selectedSalesId" placeholder="Select Crew Member" class="form-select b-primary-v2">
                            <option value="0" disabled selected>Select Crew Member</option>
                            <option v-for="item in salespersons" :key="item.id" :value="item.id">{{ item.text }}</option>
                        </select>
                    </div>
                    <FullCalendar ref="fullCalendar" :options="calendarOptions"/>
                </div>
                <button class="btn btn-primary-v2 w-100"  @click="this.isCalendarOpen = !this.isCalendarOpen"> DONE </button>
            </div>
        </div>
    </div>
      <SourceModal
        :type="sourceAction"
        :selected="leadForm.source_ids.length === 0 ? { id: 0, text: '' } : getSelectedSource(leadForm.source_ids[0])"
        @click="handleSourceChange"
      />
</template>
<script>
import {  useForm, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";
import { useNewLeadSidebar } from '../../stores/new-lead';

import axios from 'axios';
import Swal from "sweetalert2";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import Select2 from "./../../components/Select2.vue";

import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';

import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import { INITIAL_EVENTS } from "@/stores/calender";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";
import googleCalendarPlugin from "@fullcalendar/google-calendar";
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
        const store = useNewLeadSidebar();

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
            apptDate: "",
            startDate: "",
            endDate: "",
            appointedBy: 0,
            selectedSalesId: 0,
        });
        return { store, page, form, leadForm, appointmentDetails }
    },
    data(){
        const isCalendarOpen = false;
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

        const calendarOptions = {
            plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin, googleCalendarPlugin],
            initialView: "timeGridDay",
            scrollTime: '08:00:00',
            dateClick: "",
            initialEvents: INITIAL_EVENTS,
            editable: true,
            selectable: true,
            selectMirror: true,
            dayMaxEvents: true,
            weekends: true,
            height: "500px",
            headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "",
            },
            businessHours: {
              daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
              startTime: '08:00',
              endTime: '18:00',
            },
            slotLabelFormat: {
              hour: 'numeric', // '2-digit' for two leading zeros or 'numeric' for no leading zeros
              minute: '2-digit',
              hour12: true, // Use 12-hour format
              meridiem: 'short' // Optionally, specify this for AM/PM. Note: This might depend on the FullCalendar version and locale.
            },
            eventTimeFormat: { // Ensure event times are displayed in the same format
              hour: 'numeric',
              minute: '2-digit',
              meridiem: 'short',
              hour12: true
            },
            eventSources: this.eventSources
        };
        const apptDateConfig = {
          enableTime: false,
          dateFormat: "Y-m-d",
          time_24hr: false,
          allowInput: true,
          minuteIncrement: 30,
        }

        return { showing, loading, calendarOptions,isCalendarOpen,customerFieldsDisabled,customerFieldsOnEdit,processing,sources,salespersons,userData,userLoading,appointedBy,closeSendOption,leadData,customerData,initialFormState,sourceAction,selectedContact,customerOptions,apptDateConfig,sourceLoading }
    },
    methods: {
        updateVisibility() {
            if (this.store.isOpen) {

              this.customerFieldsOnEdit = false;
              this.selectedContact = null;
              this.customerFieldsDisabled = false;
              this.isCalendarOpen = false;
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

              this.leadForm.lead_id = 0,
              this.leadForm.cust_id = 0,
              this.leadForm.opportunity_title = "",
              this.leadForm.street_address = "",
              this.leadForm.city = "",
              this.leadForm.state = "",
              this.leadForm.zipcode = "",
              this.leadForm.opportunity_phone = "",
              this.leadForm.status = "open",
              this.leadForm.description = "",
              this.leadForm.cost_of_lead = 0,
              this.leadForm.created_by = "",
              this.leadForm.updated_by = "",
              this.leadForm.tag_ids = [],
              this.leadForm.source_ids = [],
              this.leadForm.jobtype_ids = [],
              this.leadForm.salesperson_ids = [],
              this.leadForm.appointment = [],
              // this.leadForm.stage_id = 2,
              this.leadForm.stage_date = new Date(),
              this.leadForm.reminder = false,
              this.leadForm.followup = false;

              this.appointmentDetails.apptDate = "";
              this.appointmentDetails.startDate = "";
              this.appointmentDetails.endDate = "";
              this.appointmentDetails.appointedBy = 0;
              this.appointmentDetails.selectedSalesId = 0;

                this.fetchSalesPersons();
                this.getCalendarEvents();
                this.fetchCustomers();
                this.fetchUserData();
                this.getAllSource();
                this.showing = true;


            } else {
                setTimeout(() => {
                    this.showing = false;
                }, 500);
            }
        },
        toggleReminder() { 
            this.leadForm.reminder = !this.leadForm.reminder;
        },
        toggleFollowup() { 
            this.leadForm.followup = !this.leadForm.followup;
        },
    addDefaultUser() {
      this.appointedBy.push(this.props.user_id);
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
      this.leadForm.cust_id = this.selectedContact.cust_id;
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
      this.customerFieldsDisabled = true;

      ////////// phones and emails /////////////////
      this.form.phones = this.selectedContact.phone.split(',');
      this.form.emails = this.selectedContact.email.split(',');

      $("#add_street_address_customer_detail").val(this.form.street_address);
      this.initialFormState = { ...this.form };

      this.leadForm.street_address = this.selectedContact.street_address;
      this.leadForm.city = this.selectedContact.city;
      this.leadForm.state = this.selectedContact.state;
      this.leadForm.zipcode = this.selectedContact.zip_code;
    },
    handleInput(e) {
      this.leadForm.clearErrors(e.target.name);
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

      ////////////////////////// SAVE LEAD ////////////////////////////////////////////////
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
    async deleteLead() {
      this.processing = true;
      this.customerFieldsDisabled = true;
      try {
        const response = await axios.post(`/api/deleteLead/${this.leadForm.lead_id}`, this.form, {
          headers: {
            Authorization: "Bearer " + this.page.props.csrf_token,
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        if (response.data.status !== "success") {
          throw new Error("Failed to update customer");
        } else {
          this.customerFieldsDisabled = false;
          this.form.reset();
          this.leadForm.reset();
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data has been DELETED successfully!",
          });
          // Go back to the previous page
          window.history.back();
        }
        this.processing = false;
        return response;
      } catch (error) {
        this.processing = false;
        throw error;
      }
    },
    async saveCustomer() {
      this.customerFieldsDisabled = true;
      try {
        if (this.form.phone) {
          this.form.phone = this.form.phone.replace(/\D/g, "");
        }
        if (this.form.cell_phone) {
          this.form.cell_phone = this.form.cell_phone.replace(/\D/g, "");
        }
        const response = await axios.post("/api/saveCustomer", this.form, {
          headers: {
            Authorization: "Bearer " + this.page.props.csrf_token,
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        if (response.data.status === "success") {
          this.leadForm.cust_id = response.data.data.id;
          this.form.cust_id = response.data.data.id;
          this.customerFieldsDisabled = true;
        } else if (response.data.status === "error" && response.data.errors) {
          for (const [field, error] of Object.entries(response.data.errors)) {
            form.errors[field] = error[0];
          }
          this.customerFieldsDisabled = false;
        }
        return response; // Return the axios response
      } catch (error) {
        this.customerFieldsDisabled = false;
        throw error; // Throw the error to be caught in the calling function
      }
    },
    async updateCustomer() {
      this.customerFieldsDisabled = true;
      try {
        if (this.form.phone) {
          this.form.phone = this.form.phone.replace(/\D/g, "");
        }
        if (this.form.cell_phone) {
          this.form.cell_phone = this.form.cell_phone.replace(/\D/g, "");
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

      this.setCalendarDate(this.appointmentDetails.apptDate);

      this.isCalendarOpen  = true;
    },
    handleResetCalendarClick() {
      this.isCalendarOpen  = false;
      this.appointmentDetails.apptDate = "";
      this.appointmentDetails.startDate = "";
      this.appointmentDetails.endDate = "";
      this.appointmentDetails.appointedBy = 0;
      this.appointmentDetails.selectedSalesId = 0;
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

        ////////////////////////////////////// CALENDAR slider /////////////////////////////////////////////////
        isInBusinessHours: function(date) {
        // Define business hours
        var businessStart = '08:00';
        var businessEnd = '18:00';

        // Convert business hours to date objects
        var startHour = parseInt(businessStart.split(':')[0]);
        var startMinutes = parseInt(businessStart.split(':')[1]);
        var endHour = parseInt(businessEnd.split(':')[0]);
        var endMinutes = parseInt(businessEnd.split(':')[1]);

        // Create date objects for start and end times on the given date
        var startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), startHour, startMinutes);
        var endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), endHour, endMinutes);

        // Check if the given date is within the business hours
        return date >= startDate && date < endDate;
        },
        getCalendarInstance() {
        return this.$refs.fullCalendar.getApi();
        },
        createNonBusinessHoursContent() {
          let element = document.querySelector('.fc-event-main');
          const el = document.createElement('div');
          el.className = 'disabled-slot';
          // el.style.top = element.getBoundingClientRect().y + 'px';
          // el.style.left = element.getBoundingClientRect().x + 'px';
          el.style.width = '100%';
          el.style.height = '21px';
          // You can add more customization here if needed
          return el;
        },
        handleEventClick(clickInfo) {
          Swal.fire({
            title: 'Already booked!',
            text: "This time slot is not available for booking.",
            icon: 'warning',
          })
        },
        handleSelectEvent(info){
          this.selectedEvent = null;
          let selfie = this;
          // Prevent selection outside of business hours
          if (!this.isInBusinessHours(info.start)) {
            selfie.getCalendarInstance().unselect();
            Swal.fire({
                title: 'Business Hours!',
                text: "This time slot is not available for booking.",
                icon: 'warning',
            })
        }else{
          let t_laststart = this.formatDate(info.end);
          let t_nowstart = this.formatDate(info.start);
          this.appointmentDetails.startDate = t_nowstart;
          this.appointmentDetails.endDate = t_laststart;

          this.leadForm.stage_id = 4;
        }
        },
        initializeCalendarOptionsDependentOnDOM() {
          this.calendarOptions = {
              ...this.calendarOptions,
              eventClick: this.handleEventClick,
              select: this.handleSelectEvent,
          };
        },
        formatDate(date){
          if (date) {
            return new Intl.DateTimeFormat('en-US', {
                year: 'numeric', month: '2-digit', day: '2-digit',
                hour: '2-digit', minute: '2-digit',hour12: true
            }).format(new Date(date));
          }
        },
        toLocalISOString(date) {
          console.log("date: ", date);
          const tzOffset = -date.getTimezoneOffset();
          const localISOTime = new Date(date.getTime() - (tzOffset * 60000)).toISOString().slice(0, -1);
          return localISOTime.replace('T', ' ').slice(0, 19);
        },
        extractTime(dateString) {
          const date = new Date(dateString);
          let hours = date.getHours();
          let minutes = date.getMinutes();
          const ampm = hours >= 12 ? 'PM' : 'AM';

          // Convert hours from 24-hour to 12-hour format
          hours = hours % 12;
          hours = hours ? hours : 12; // The hour '0' should be '12'

          // Pad single digit minutes with a leading zero
          minutes = minutes < 10 ? '0' + minutes : minutes;

          // Format the time in HH:MM AM/PM format
          return `${hours}:${minutes} ${ampm}`;
        },
        setCalendarDate(date) {
          this.$nextTick(() => {
            const calendarApi = this.$refs.fullCalendar.getApi();

            const baseDate = new Date(this.appointmentDetails.apptDate);
            calendarApi.gotoDate(baseDate);

            // const startDate = new Date(baseDate.setHours(8, 0, 0, 0)); // Hours, Minutes, Seconds, Milliseconds
            // const endDate = new Date(startDate.getTime() + 60 * 60 * 1000); // Add 1 hour to start date for end date

            // calendarApi.select({
            //   start: startDate,
            //   end: endDate,
            // });
          });
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
        opportunity_title() {
            return this.leadForm.opportunity_title;
        },
        formType() {
          return this.store.formType;
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
        opportunity_title: {
          handler(newLeadTitle) {
            this.leadForm.reminder=true;
            this.leadForm.followup=true;

          },
        },
        formType: {
          handler(newValue) {
            if(newValue == "lead"){
              this.leadForm.stage_id = 2;
            }else if(newValue == "proposal"){
              this.leadForm.stage_id = 5;
            }
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
    },
    mounted() {
        this.$nextTick(() => {
            this.initializeCalendarOptionsDependentOnDOM();

            this.apptDateConfig.onClose = (selectedDates) => {
              this.handleDateRange(selectedDates);
            };
        });
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

    .multiselect {
        border: 1px solid #1e5bb2;
        border-radius: 0.25rem;
    }

    .multiselect--active .multiselect__tags {
        border: none;
    }

    .multiselect__content-wrapper {
        border: 1px solid #1e5bb2;
        border-top: none;
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