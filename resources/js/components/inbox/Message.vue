

<template>
   <div class="default-according p-15" id="accordion">
      <div class="card">
         <div class="collapse show" id="collapse1" aria-labelledby="heading1" data-bs-parent="#accordion">
            <div class="card-body" v-html="message" style="height: 100%;overflow: hidden; overflow-x: hidden;"></div>
         </div>
      </div>
   </div>
</template>
<script setup>
defineProps(['message']);
</script>