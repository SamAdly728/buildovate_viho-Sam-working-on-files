<script setup>
import { onMounted, ref, watch } from "vue";
import Professional from "@/components/Pages/buildovate-professionals/Professional.vue";
import { useMainStore } from "@/stores/main";

const store = useMainStore();

onMounted(() => {
  // console.log("HERE");
});
</script>
<template>
  
  <div class="row" style="background-color: #f5f9ff">
    <div class="col-md-3" v-for="(item, index) in store.prosList">
      <Professional :item="item" :key="index"></Professional>
    </div>
  </div>
</template>
