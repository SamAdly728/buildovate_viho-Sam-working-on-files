<template>
    <Link 
        preserve-scroll 
        :href="href"
        >
        <h5>
            <vue-feather type="file-text"></vue-feather>
            {{ name }}
        </h5>
    </Link>
</template>

<script setup>

import { Link } from "@inertiajs/vue3";
import VueFeather from 'vue-feather';

// import { defineProps } from "vue";
defineProps(["name","component","href","icon"]);

</script>

<style>
 /* .active{
    text-decoration: underline;
    color: green;
} */

</style>
