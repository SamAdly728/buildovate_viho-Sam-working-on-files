<style scoped>
.custom-hover:hover{
  background-color: #0f5132 !important;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #2b786a;
  border-radius: 10px;
}
</style>
<template>
  <div class="p-2 overflow-auto custom-scrollbar" v-if="selected_jobsite">
    <div class="container-fluid mt-2">
      <div class="row">
        <div class="col-xl-3 box-col-6 pe-0">
          <sideMenu :user-folder="userFolder"/>
        </div>
      
        <fileManager :user-file="userFile" :user-folder="userFolder"/>
      </div>
    </div>
  </div>
  <div class="container" v-if="!selected_jobsite">
    <div class="row">
      <div class="col d-flex justify-content-center align-items-center" style="height: 200px;">
        <div class="text-center">
          <h3 class="text-success">Select a Jobsite.</h3>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useSideBar } from '../stores/sidebar';
import {watch} from "vue";
import {router} from '@inertiajs/vue3';
const store = useSideBar();

let selected_jobsite = ref(false)

watch(() => store.$state.selectedJobsites, (newValue, oldValue) => {
  selected_jobsite.value = newValue.length > 0;
});
</script>

<script>
import sideMenu from "@/components/user_files/FileSideMenu.vue"
import fileManager from "@/components/user_files/FileManager.vue"
import {router, usePage} from '@inertiajs/vue3';
import { useSideBar } from '../stores/sidebar';
import {ref, watch} from "vue";

const page = usePage();
export default {
  components:{
    sideMenu,
    fileManager
  },
  props: ['userFile', 'userFolder'],
  data() {
    return {

    }
  },
  mounted() {
    $('html, body').css({
      overflow: 'auto',
    });
    window.addEventListener('keydown', function(event) {
      if (event.key === 'F5' ||
          (event.ctrlKey && event.key === 'r') ||
          (event.metaKey && event.key === 'r'))
      {
        event.preventDefault();
        router.reload()
      }

      if ((event.ctrlKey && event.shiftKey && event.key === 'R') ||
          (event.metaKey && event.shiftKey && event.key === 'R')) {
        event.preventDefault();
        router.reload()
      }
    });
  }
}
</script>

