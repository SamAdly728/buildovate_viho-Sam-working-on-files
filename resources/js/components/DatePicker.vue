<template>
    <div class="form-group row mb-0">
        <label class="col-sm-3 col-form-label text-end">Permanently visible Datepicker</label>
        <div class="col-sm-3">
            {{ date.toLocaleDateString("en-US", { month: 'short', day: 'numeric' }) }}
            <v-date-picker v-model="date"  />
            <!-- <Timepicker v-model="time" /> -->
        </div>
    </div>
</template>
<script>
// import Datepicker from "vue3-datepicker";
// import Timepicker from "vue3-datepicker";
import { ref } from 'vue';
import Datepicker from 'vue3-datepicker';
// import 'vue3-datepicker/dist/datepicker.min.css';

export default {
    setup(){
        const datepickerVisible = ref(true);
    },
    components: {
    'v-date-picker':Datepicker,
    },
    data(){
       return{
            date: new Date(),
            time: new Date(),
            // date1: new Date(),
            // date3: new Date(),
            format: 'MM/dd/yyyy',
            format2: 'MMMM yyyy',orientation: "top right",
            disabledDates:{
                days: [6, 0],
            },
        }
},
}
</script>