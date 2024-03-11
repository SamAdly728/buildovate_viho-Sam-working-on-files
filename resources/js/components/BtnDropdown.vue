<template>
    <div class="btn-group" role="group">
        <button @click="isShown=!isShown" class="btn btn-light dropdown-toggle" id="btnGroupDrop" type="button">
        {{ name }}
        </button>
        <div v-if="isShown" class="dropdown-menu" style="display:block">
        <a v-for="l in links" :key="l.name" class="dropdown-item" :href="l.link">
            {{ l.name }}
        </a>
        </div>
    </div>
</template>

<script>
export default {
  name: 'app',
  props: ["name", "links"],
  data() {
    return {
        isShown:false
    }
  }
}
</script>
<style scoped>

.btn-group {
    vertical-align: bottom;
}
</style>
