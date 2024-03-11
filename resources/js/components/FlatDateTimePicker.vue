<template>
  <flat-pickr
    ref="flatpickr"
    class="form-control b-primary-v2 bg-white"
    v-model="date"
    :config="config"
    placeholder="Select date and time"
    name="appointment_date"
    :disabled="processing"
  ></flat-pickr>
</template>

<script setup>
import { ref, watch, onMounted, defineEmits } from 'vue';
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

const processing = ref(false);
const date = ref([]);
const flatpickrRef = ref(null);
const emit = defineEmits(['update-range']);

const config = {
  enableTime: false,
  // dateFormat: "Y-m-d h:i K",
  dateFormat: "Y-m-d",
  time_24hr: false,
  allowInput: true,
  minuteIncrement: 30,
  defaultDate: getDefaultDate(),
  onClose(selectedDates) {
    const fromDateTime = selectedDates[0];
    const toDateTime = new Date(fromDateTime.getTime() + 30 * 60000); // 30 minutes later
    // this.setDate([fromDateTime, toDateTime]);
    emit('update-range', { apptDate: selectedDates, startDate: fromDateTime, endDate: toDateTime });
  },
};

function getDefaultDate() {
  const now = new Date();
  now.setHours(8, 0, 0, 0); // Sets the time to 8:00 AM
  return now;
}

</script>
