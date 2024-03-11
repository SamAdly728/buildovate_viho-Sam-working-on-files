<script setup>
import { useMainStore } from "@/stores/main";
import Profile from "@/components/Pages/buildovate-professionals/Profile.vue";

const store = useMainStore();

const props = defineProps(["isOpen"]);

// const closePanel = () => {
//   store.setRightPanel(false);
// };
</script>

<style scoped>
.left {
  left: 0 !important;
  width: 685px;
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
  <Transition>
    <div
      v-show="store.isOpenRighPanel"
      class="customizer-contain text-black left"
      style="
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 5px 5px 25px #00000042;
        height: 2184px;
        position: absolute;
        top: 50px;
      "
    >
      <Profile></Profile>
    </div>
  </Transition>
</template>
