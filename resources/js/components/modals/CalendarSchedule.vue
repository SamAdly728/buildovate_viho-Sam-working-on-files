<template>
    <div class="modal-transparent d-flex" style="position: absolute; left: 0; top: 0; bottom: 0; right: 0; z-index: 1000;" v-if="showing">
        <div class="flex-grow-1 d-flex justify-content-end px-5 pt-5" style="margin-bottom: auto;">
        </div>
        <div class="bg-white shadow-lg d-flex flex-column" :class="this.isOpen ? 'right-slide-animation-in' : 'right-slide-animation-out'">
            <div class="d-flex align-items-center">
                <h5 class="p-3 f-w-600 text-dark m-0 p-0 flex-grow-1" style="height: 55px;">Calendar Schedule</h5>
                <a style="cursor: pointer;" @click="store.close()" class="p-3"><i class="icon-close"></i></a>
            </div>
            <!-- <div style="height: 1px; width: 100%;" class="bg-primary"></div> -->
            <div class="flex-grow-1 bg-main" style="max-height: calc(100vh - 51px); overflow: hidden;">
                <div class="d-flex justify-content-center align-items-center f-14 f-w-600 text-muted py-2" v-if="loading">
                    <i class="fa fa-spin fa-spinner me-2"></i>Loading...
                </div>
                <div class="slim-scroll-gray d-flex flex-column gap-3 py-3" style="max-height: calc(100vh - 51px); overflow: auto;">
                    <div class="mx-1">
                        <label class="form-label f-w-600">SalesPerson</label>
                        <select ref="selectInstance" id="salesperson" v-model="salesId" placeholder="Select Crew Member" class="form-control" style="border-color: #1e5bb2;">
                            <option value="0" disabled selected>Select Crew Member</option>
                            <option v-for="item in store.salesPerson" :key="item.id" :value="item.id">{{ item.text }}</option>
                        </select>
                    </div>
                    <FullCalendar ref="fullCalendar" :options="calendarOptions"/>
                </div>
                <button class="btn btn-primary w-100"  @click="store.close()"> SAVE </button>
            </div>
        </div>
    </div>
</template>
<script>
import { useCalendarScheduleSidebar } from '../../stores/calendar-schedule';
import { usePage } from '@inertiajs/inertia-vue3';
import Calendar from '../CalendarSidebar.vue';
import axios from 'axios';

import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import { INITIAL_EVENTS } from "@/stores/calender";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";
import googleCalendarPlugin from "@fullcalendar/google-calendar";
import Swal from 'sweetalert2';

export default {
    components: {
        FullCalendar,
    },  
    props: {
        eventSources: {
            type: [Array],
            default: []
        },
        initialView: {
            type: [String],
            default: "timeGridDay"
        },
    },
    data(){
        const showing = false;
        const loading = false;
        const calendarOptions = {
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
            slotLabelFormat: [
            { hour: '2-digit', minute: '2-digit', hour12: false }
            ],
            eventSources: this.eventSources
        };
        const salesId = 0;

        return { showing, loading, calendarOptions,salesId }
    },
    setup(){
        const store = useCalendarScheduleSidebar();
        const page = usePage();

        return { store, page }
    },
    methods: {
        updateVisibility() {
            if (this.store.isOpen) {
                this.showing = true;
            } else {
                setTimeout(() => {
                    this.showing = false;
                }, 500);
            }
        },
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
    computed: {
        isOpen() {
            return this.store.isOpen;
        },
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
        isOpen: {
            handler() {
                this.updateVisibility();
            }
        },
        selectedSalesId(newValue, oldValue){
            this.salesId = newValue;
        },
        salesId(newValue, oldValue){
            this.store.setSelectedSalesId(newValue);
        },
    },
    mounted() {
        this.$nextTick(() => {
            this.initializeCalendarOptionsDependentOnDOM();
        });
    },
}
</script>