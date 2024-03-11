<template>
    <div class="">
        <comingSoon></comingSoon>
    </div>
</template>

<script>
import comingSoon from "@/components/comingSoon.vue"
    export default {
    components: {
        comingSoon
    },
    mounted() {
        $('html, body').css({
        overflow: 'hidden',
        height: '100%'
        });
    }
    }
</script>