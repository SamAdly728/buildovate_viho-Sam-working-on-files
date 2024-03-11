<script setup>
import { onMounted } from "vue";
import ProItem from "@/Pages/company/buildovate-professionals/ProItem.vue";
import { useMainStore } from "@/stores/main";

const store = useMainStore();

const loadDefault = () => {
  store.setSelectedPro(null);
  store.getPros();
};
onMounted(() => {
  console.log("List of pros mounted");
  store.setSelectedPro(null);
  loadDefault();
});
</script>

<template>
  <div v-for="(item, index) in store.prosList" :key="index">
    <ProItem :item="item"></ProItem>
  </div>
</template>
