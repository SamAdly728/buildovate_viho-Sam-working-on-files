<template>
    <Link 
        :href="href"
        :class="btn_class"
        >
        <vue-feather v-if="icon!=''" :type="icon" class="m-r-5"></vue-feather>
        <span>{{ name }}</span>
    </Link>
</template>

<script setup>
import VueFeather from 'vue-feather';
import { Link } from "@inertiajs/vue3";
// import { defineProps } from "vue";
defineProps(["name","href","icon","btn_class"]);

</script>

<style>
 /* .active{
    text-decoration: underline;
    color: green;
} */

</style>
