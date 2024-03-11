<template>
  <flat-pickr
    class="form-control b-primary-v2 bg-white"
    v-model="date"
    :config="config"
    placeholder="Select date and time"
    name="appointment_date"
    :disabled="processing"
  ></flat-pickr>
</template>
<script setup>
    import { ref } from 'vue';
    import FlatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    const processing = ref(false);
    const date = ref(null);
    const config = {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        allowInput: true
    };
</script>