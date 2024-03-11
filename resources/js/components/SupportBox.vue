<template>
   <div class="text-center mt-3">
      <div class="mb-3 f-w-700 text-secondary">OUR TEAM IS HERE TO HELP</div>
      <div class="mb-3">
      <img class="card-img-top img-60 me-1" :src="'/images/michelle.png'" style="display:inline-block;border-radius: 50%;">
      <img class="card-img-top img-60 me-1" :src="'/images/joe.png'" style="display:inline-block;border-radius: 50%;">
      <img class="card-img-top img-60" :src="'/assets/images/dashboard-2/5.png'" style="display:inline-block;border-radius: 50%;">
      </div>
      <div class="mb-2">
      {{ page.props.support.phone }}
      </div>
      <div>
      <a href="" class="text-info">Contact Support</a>
      </div>
   </div>
</template>
<script setup>
import { usePage } from '@inertiajs/vue3';
const page = usePage();
</script>