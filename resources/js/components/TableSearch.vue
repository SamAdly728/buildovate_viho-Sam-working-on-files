<template>    
  <form @submit.prevent="form.post(currentPage)">
    <div class="d-flex align-items-center position-relative my-1">
      <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
        <span class="path1"></span>
        <span class="path2"></span>
      </i>
      <input type="text" id="search" v-model="form.search" data-kt-table-widget-4="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search..." />
    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
const props = defineProps(['search']);
const currentPage = window.location.pathname;

const form = useForm({
  search: props.search!='null' ? props.search : '' 
});

// form.post(currentPage, {
//   preserveScroll: true,
//   replace: true
// });
</script>