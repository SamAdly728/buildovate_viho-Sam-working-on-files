<script setup>
import ProItemList from "@/Pages/company/buildovate-professionals/ProItemList.vue";
import ProItemCard from "@/Pages/company/buildovate-professionals/ProItemCard.vue";

const props = defineProps(["item"]);
</script>

<template>
  <div class="desktop-view">
    <ProItemList :item="props.item"></ProItemList>
  </div>
  <div class="mobile-view">
    <ProItemCard :item="props.item"></ProItemCard>
  </div>
</template>

<style scoped>
.desktop-view {
  display: block;
}

.mobile-view {
  display: none;
}

/* Styles for screens with a maximum width of 767px (extra-small) */
@media (max-width: 767px) {
  .desktop-view {
    display: none;
  }

  .mobile-view {
    display: block;
  }
}
</style>
