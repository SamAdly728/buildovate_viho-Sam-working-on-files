<template>
  <div v-if="name === 'More'" :class="'mm_style'">
    <!-- {{ name }}   -->
    <i class="fa fa-chevron-right ml-1"></i>
  </div>
  <Link
    v-else
    :class="'mm_style'"
    preserve-scroll
    :name="name"
    :href="href"
    @click="clearProfile"
  >
    {{ name }}
  </Link>
</template>

<script setup>
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";
import { useMainStore } from "@/stores/main";

const store = useMainStore();
const props = defineProps(["name", "component", "href", "icon", "active"]);

const clearProfile = () => {
  store.showViewProfile(false);
  store.setRightPanel(false);
};
</script>

<style scoped>
.mm_style {
  color: #24695c;
  font-weight: 500;
}
.active-link {
  font-weight: 700;
}
</style>
