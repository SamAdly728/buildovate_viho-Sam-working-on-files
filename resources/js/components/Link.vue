<template>
    <Link 
        class="" :class="{ 'active-link': active }"
        preserve-scroll 
        :href="href"
        >
        <template v-if="vficon"><vue-feather :type="vficon"></vue-feather></template>
         {{ name }}
    </Link>
</template>

<script setup>
import VueFeather from 'vue-feather';
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps(["name", "component", "href", "icon", "vficon", "active"]);
</script>

<style scoped>

.active-link {
    font-weight: 700;
}
</style>
