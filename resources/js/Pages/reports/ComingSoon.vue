<template>
  <comingSoon></comingSoon>
</template>

<script setup>

import Link from "@/components/Link.vue";

</script>

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

