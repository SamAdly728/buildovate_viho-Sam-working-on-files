<script setup>
import { ref } from "vue";
import { useMainStore } from "@/stores/main";

const store = useMainStore();

const props = defineProps(["isOpen"]);

const closePanel = () => {
  store.setRightPanel(false);
};
</script>

<style scoped>
.left {
  left: 0px !important;
  width: 70%;
}

.text-black {
  color: #000;
}
/* Styles for screens with a maximum width of 767px (extra-small) */
@media (max-width: 767px) {
  .left {
    width: 100%; /* Set width to 100% on mobile views */
  }
}
</style>
<template>
  <div
    v-show="store.isOpenRighPanel"
    class="customizer-contain bg-light text-black left"
  >
    <div class="tab-content" id="quickstarttabContent">
      <div class="customizer-header text-center">
        <i @click="closePanel" class="icofont-close icon-close"></i>
        <h5>Profile</h5>
        <hr />
      </div>
      <div class="customizer-body custom-scrollbar">
        Content Here

        <p>{{ store.message }}</p>
      </div>
    </div>
  </div>
</template>
