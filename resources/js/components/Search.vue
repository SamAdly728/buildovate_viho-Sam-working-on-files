<template>    

<form @submit.prevent="form.post(currentPage)" class="search-form">
  <!-- <div class="form-group mb-0"> -->
    <!-- <div class="input-group"> -->
      <!-- <span class="input-group-text"><i class="icon-search"></i></span> -->
      <input v-model="form.search" id="search"  class="form-control-plaintext" type="search" placeholder="Search..">
    <!-- </div> -->
  <!-- </div> -->
</form>

</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
const props = defineProps(['search']);
const currentPage = window.location.pathname;

const form = useForm({
  search: props.search
});

form.post(currentPage, {
  preserveScroll: true,
  replace: true
});
</script>