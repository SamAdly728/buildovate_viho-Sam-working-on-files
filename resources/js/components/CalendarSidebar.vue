<template>
  <div class="container-fluid calendar-basic" style="background-color: white;">
    
    <div class="d-flex justify-content-between align-items-center">
        <label class="form-label f-w-600">{{ salesperson_ids.length > 1 ? 'Salespeople' : 'Salesperson'}}</label>
        <div v-if="!sourceLoading">
            <a class="badge badge-dark cursor-pointer" style="height: 20px !important;" @click="populateSalesperson" id="edit-lead-reset-salesperson">Reset</a>
        </div>
    </div>
    <div class="mb-4">
      <select ref="selectInstance" id="salesperson" v-model="salespersonId" placeholder="Select Crew Member" class="form-control" style="border-color: #1e5bb2;">
        <option value="" disabled selected>Select Crew Member</option>
        <option v-for="item in salePersons" :key="item.id" :value="item.id">{{ item.text }}</option>
      </select>

      <!-- <Select2 
          v-model="salesperson_ids"
          :className="'container-style-outlined-no-hover'"
          :placeholder="'Select Crew Member'" 
          :id="'edit-lead-user-list'"
          :purpose="'multiple-select'"
          :items="salePersons"
          :isLoading="userLoading"
          :disabled="processing"
      /> -->
    </div>
    <FullCalendar ref="fullCalendar" :options="calendarOptions"/>
  </div>
</template>
<script>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import { INITIAL_EVENTS } from "@/stores/calender";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";
import googleCalendarPlugin from "@fullcalendar/google-calendar";
import axios from 'axios';
import Swal from 'sweetalert2';

import Select2 from './Select2.vue';

import { useCalendarScheduleSidebar } from '../stores/calendar-schedule';
import { usePage } from '@inertiajs/inertia-vue3';

export default {
  components: {
    FullCalendar,
    Select2
  },
  props: {
    heigth: {
      type: [Number],
      default: 980
    },
    initialView: {
      type: [String],
      default: "timeGridWeek"
    },
    setDate: {
      type: [String],
      default: new Date()
    },
    showsidebar: {
      type: [Boolean],
      default: true
    },
    showtitle: {
      type: [Boolean],
      default: true
    },
    showAddButton: {
      type: [Boolean],
      default: true
    },
    enableScheduleAppointment: {
      type: [Boolean],
      default: true
    },
    salePersons:{
      type: [Array],
      default: []
    }
  },
  data() {
    const selfie = this;
    return {
      uploadIcon: window.location.origin + '/assets/images/upload-100.png',
      deleteIcon: window.location.origin + '/assets/images/delete.png',
      show : false,
      dateClick: null,
      formData: {
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
        entityType: 'non-work',
        entityId: 0,
        file: []
      },
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin, googleCalendarPlugin],
        initialView: this.initialView,
        scrollTime: '08:00:00',
        dateClick: "",
        initialEvents: INITIAL_EVENTS,
        editable: true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        height: this.heigth,
        headerToolbar: {
          left: this.showAddButton ? "addEvent prev,next today" : "prev,next today",
          center: "title",
          right: this.showAddButton ? "dayGridMonth,timeGridWeek,timeGridDay": "",
        },
        businessHours: {
          daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
          startTime: '08:00',
          endTime: '18:00',
        },
        slotLabelFormat: [
          { hour: '2-digit', minute: '2-digit', hour12: false }
        ],
        // slotLaneContent: function(arg) {
        //   if (!selfie.isInBusinessHours(arg.date)) {
        //     return { domNodes: [selfie.createNonBusinessHoursContent()] };
        //   }
        // },
        eventSources: []
      },
      salesperson_ids: [],
      salespersonId: 0,
    };
  },    
  setup(){
      const store = useCalendarScheduleSidebar();
      const page = usePage();

      return { store, page }
  },
  methods: {
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
        let t_laststart = this.formatDate(info.endStr);
        let t_nowstart = this.formatDate(info.startStr);

        this.store.setStartDate(t_nowstart);
        this.store.setEndDate(t_laststart);
      }
    },
    initializeCalendarOptionsDependentOnDOM() {
      // Modify calendarOptions to include eventClick
      this.calendarOptions = {
        ...this.calendarOptions, // Spread existing options
        eventClick: this.handleEventClick,
        select: this.handleSelectEvent,
        // unselect: this.UnSelectEvent,
        // dateClick: function (calDate) {
        // },
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
      return `${hours}:${minutes}`;
    },
    setCalendarDate(date) {
      const calendarApi = this.$refs.fullCalendar.getApi();
      calendarApi.gotoDate(date);
    },
  },
  mounted() {
    axios.get('/api/calendar/getData') // Your Laravel endpoint to fetch events
      .then(response => {
        this.events  = response.data.data;
        this.calendarOptions.eventSources = [
            { events: this.events }
          ];
        console.log(this.calendarOptions.eventSources);
      });

    this.$nextTick(() => {
      // After ensuring the DOM is ready, initialize eventClick
      this.initializeCalendarOptionsDependentOnDOM();
    });
  },
  computed: {
      apptDate(){
          return this.store.apptDate;
      },
      startDate(){
          return this.store.startDate;
      },
      endDate(){
          return this.store.endDate;
      },
      selectedSalesPeople(){
          return this.store.selectedSalesPerson;
      },
      selectedSalesId(){
          return this.store.selectedSalesPerson;
      }
  },
  watch: {
    // setDate(newValue, oldValue) {
    //   console.log(`Prop myProp changed from ${oldValue} to ${newValue}`);
    //   this.setCalendarDate(newValue);
    // }
    salesperson_ids(newValue, oldValue){
      console.log("Sales Person Change");
      console.log(newValue);
      
      this.store.setSelectedSalesPerson(newValue);
    },
    selectedSalesId(newValue, oldValue){
      this.store.setSelectedSalesId(newValue);
    }
  }
};
</script>