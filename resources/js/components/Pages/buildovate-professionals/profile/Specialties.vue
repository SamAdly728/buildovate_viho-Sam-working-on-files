<script setup>
import { useMainStore } from "@/stores/main";
const store = useMainStore();
</script>
<template>
  <div>
    <div class="frame-100000958">
      <div class="frame-1000009545" v-for="(tag, index) in store.selectedPro?.tags" :key="index">
        <div class="inter-normal-trout-8px">{{ tag }}</div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
