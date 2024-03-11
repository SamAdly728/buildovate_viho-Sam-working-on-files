<style scoped>
.flatpickr-input {
  display: none !important;
}

</style>
<template>
  <div class="m-l-5">
    <flat-pickr :config="config"/>
  </div>
  <div class="p-l-10 p-r-10 m-t-15">
    <JobsiteList/>
  </div>
</template>
<script>
import FlatPickr from 'vue-flatpickr-component';
import JobsiteList from '../sidebar/JobsiteList.vue';
export default  {
  components: {
    FlatPickr,
    JobsiteList
  },
  data() {
    return {
      config: {
        wrap: false,
        altFormat: 'M j, Y',
        altInput: false,
        dateFormat: 'Y-m-d',
        // defaultDate: new Date(),
        inline: true
      },
    }
  },
  mounted() {
    let flat = document.querySelector('.flatpickr-calendar')
    flat.style.border = '1px solid #1E5BB2'
    flat.style.fontSize = '14px'
    // flat.style.fontWeight = 'bold'
    flat.style.transform = 'scale(0.8)'
  }
}
</script>