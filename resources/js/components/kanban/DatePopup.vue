
<style scoped>
.popup {
  background: white;
  padding: 0px;
  border-radius: 5px;
  width: 330px;
  z-index: 100;
}
.close-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        border: none;
        background: transparent;
        font-size: 20px;
        cursor: pointer;
    }
</style>
<style>
.vuejs3-datepicker__calendar-topbar{
  display: none !important;
}
</style>
<template>
  <div v-if="showPopup" class="popup" :style="popupStyle">
    <div class="card">
      <div class="card-header m-0 p-2">
        <div style="padding: 10px;">
          <button class="close-btn" @click="emitClosePopup">&times;</button>
          <h6 class="text-center">Dates</h6>
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body m-0 p-3">

         <!-- Vue Datepicker -->
        <DatePicker v-model="date"  :inline="true" @selected="updateDate" />
        
        <div class="form">
          <!-- Start date -->
          <div class="form-group">
            <label for="startDate">Start date</label>
            
            <input type="text" id="startDate" class="form-control" v-model="startDate" placeholder="YYYY-MM-DD">
          </div>
    
          <!-- Due date -->
          <div class="form-group row">
            <label for="dueDate" class="col-sm-12 col-form-label">Due date</label>
            <div class="col-sm-6">
              <input type="text" id="dueDate" class="form-control" v-model="selectedDate">
            </div>
            <div class="col-sm-6">
              <input type="text" id="dueDatetime" class="form-control" v-model="selectedTime"  placeholder="HH:MM:SS AM/PM">
            </div>
          </div>

          <!-- Dropdown for Due Date Reminder -->
          <div class="form-group">
            <label for="reminderDate">Set due date reminder</label>
            <select id="reminderDate" class="form-control" v-model="reminderDate" @change="onReminderChange">
              <option value="none">None</option>
              <option value="1">1 day before</option>
              <option value="2">2 days before</option>
              <option value="7">1 week before</option>
              <!-- Add more options as needed -->
            </select>
            <p>Reminder Date: {{ reminderDateValue }}</p>
          </div>
        </div>
      </div>
      <!-- Card Footer -->
      <div class="card-footer p-0">
        <button class="btn btn-primary  w-100 mb-3"  @click="saveDate">Save</button>
        <button class="btn btn-secondary  w-100"  @click="removeDate">Remove</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import DatePicker from 'vuejs3-datepicker';

export default {
  props: ['showPopup', 'position','card'],
  components: {
    DatePicker
  },
  data(props) {
    return {
      // card:props.card,
      date: new Date(),
      startDate:  null,
      _selectedDate: new Date(props.card.due_date),
      selectedTime: '',
      dueDate: '',
      dueTime: '',
      reminderDate:'none',
      reminderDateValue:'',
    };
  },
  computed: {
    popupStyle() {
      return {
        position: 'absolute',
        top: this.position.top + 'px',
        left: this.position.left + 'px'
      }
    },
    // startDate: {
    //   // Getter returns the date in YYYY-MM-DD format for the input field
    //   get() {

    //     const year = this._startDate.getFullYear();
    //     let month = this._startDate.getMonth() + 1; // January is 0!
    //     let day = this._startDate.getDate();

    //     // Pad the month and day with leading zeros if necessary
    //     month = month < 10 ? `0${month}` : month;
    //     day = day < 10 ? `0${day}` : day;

    //     return `${year}-${month}-${day}`;
    //   },
    //   // Setter parses the input value back into a Date object
    //   set(newValue) {
    //     this._startDate = new Date(newValue);
    //   }
    // },
    selectedDate: {
      // Getter returns the date in YYYY-MM-DD format for the input field
      get() {
        const year = this._selectedDate.getFullYear();
        let month = this._selectedDate.getMonth() + 1; // January is 0!
        let day = this._selectedDate.getDate();

        // Pad the month and day with leading zeros if necessary
        month = month < 10 ? `0${month}` : month;
        day = day < 10 ? `0${day}` : day;

        return `${year}-${month}-${day}`;
      },
      // Setter parses the input value back into a Date object
      set(newValue) {
        this._selectedDate = new Date(newValue);
      }
    },
  },
  methods: {
    updateDate(value) {
      this.selectedDate = this.formatDate(value);
      this.selectedTime = this.formatTime(value);
      // You can call other methods here as needed
      if(this.reminderDate != 'none'){
        this.reminderDateValue =  this.calculateDate(this.reminderDate);
      }else{
        this.reminderDateValue = "";
      }
    },
    formatDate(date) {
      // return date.toLocaleDateString(); // e.g., "MM/DD/YYYY"
      let newDate = new Date(date).toISOString().split('T')[0]
      return newDate;
    },
    formatTime(date) {
      return date.toLocaleTimeString(); // e.g., "HH:MM:SS AM/PM"
    },
    saveDate() {

      let formData = {
        start_date: this.startDate,
        due_date: this.selectedDate,
        due_time: this.selectedTime,
        reminder: this.reminderDate,
        reminder_date: this.reminderDateValue,
      };

      this.$emit('save-form', formData);
    },
    removeDate() {
      let formData = {
        start_date: this.startDate,
        due_date: "",
        due_time: "",
        reminder: "none",
        reminder_date: "",
      };

        this.$emit('save-form', formData);
    },   
    emitClosePopup() {
        this.$emit('close-popup');
    },    
    calculateDate(days) {
      let noOfDay = parseInt(days);
      const resultDate = new Date(this.selectedDate);
      resultDate.setDate(resultDate.getDate() - noOfDay);

      const year = resultDate.getFullYear();
      let month = resultDate.getMonth() + 1; // January is 0!
      let day = resultDate.getDate();

      // Pad the month and day with leading zeros if necessary
      month = month < 10 ? `0${month}` : month;
      day = day < 10 ? `0${day}` : day;

      return `${year}-${month}-${day}`;
    },
    onReminderChange(){
      // You can call other methods here as needed
      if(this.reminderDate != 'none'){
        this.reminderDateValue =  this.calculateDate(this.reminderDate);
      }else{
        this.reminderDateValue = "";
      }
    }
  },  
};
</script>

