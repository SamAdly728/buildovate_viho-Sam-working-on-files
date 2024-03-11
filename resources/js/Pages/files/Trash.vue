<style>
.video-container {
  position: absolute;
  top: 0;
  bottom: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
}
.video-container video {
  /* Make video to at least 100% wide and tall */
  min-width: 100%;
  min-height: 100%;

  /* Setting width & height to auto prevents the browser from stretching or squishing the video */
  width: auto;
  height: auto;

  /* Center the video */
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
}

.table thead th {
  position: sticky;
  top: 0;
  background: white;  /* To ensure header background remains opaque */
  z-index: 1;
}
</style>
<template>
  <div class="centered-on-screen" v-if="showLoader">
    <div class="backdrop"></div>
    <div class="d-flex flex-column align-items-center">
      <div style="height: 400px; margin-top: 15%">
        <LoadingMetric></LoadingMetric>
      </div>
    </div>
  </div>
  <div class="p-2 overflow-auto custom-scrollbar">
    <div class="container-fluid mt-2">
      <div class="row">
        <div class="col-xl-3 box-col-6 pe-0">
          <sideMenu :user-folder="userFolder"/>
        </div>
        <div class="col-xl-9 col-md-12 box-col-12">
          <div class="file-content">
            <div class="card">
              <div class="card-header">
                <div class="">
                  <h5 class="text-muted d-inline">Trash</h5>
<!--                  <button class="btn btn-primary btn-sm float-end d-inline" data-bs-toggle="modal" data-bs-target="#uploadFile">Add New</button>-->
                </div>
              </div>
              <div class="card-body file-manager">
              <!--<comingSoon/>-->
                <div class="table-responsive" style="max-height: 700px; min-height: auto">
                  <table class="table table-hover">
                    <thead>
                    <tr>
                      <th><span class="text-muted">Name</span></th>
                      <th><span class="text-muted">Size</span></th>
                      <th><span class="text-muted">Action</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="trash in trashedFile">
                      <td class="d-flex align-items-center">
                        <img class="mr-5" style="max-width: 50px; max-height: 50px; object-fit: cover; cursor: pointer" :src="trash.s3Url" alt="">
                        <span class="text-muted">{{ trash.file_name }}</span>
                      </td>
                      <td><span class="text-muted">{{ Math.trunc(Math.round(trash.file_size / 1024 * 100) / 100) + ' KB' }}</span></td>
                      <td>
                        <a href="#"><span class="text-success" @click="restoreFile(trash.user_file_upload_id)">Restore</span></a>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import LoadingMetric from '@/components/LoadingStyleMetric.vue';
</script>
<script>
import sideMenu from "@/components/user_files/FileSideMenu.vue"
import comingSoon from "@/components/comingSoon.vue"

import { usePage } from '@inertiajs/vue3';
import {router} from '@inertiajs/vue3';
import axios from "axios";
import {toast} from "vue3-toastify";


const page = usePage();

export default {
  components: {
    sideMenu,
    comingSoon
  },
  props: ['trashedFile', 'userFolder'],
  data() {
    return {
      showLoader: false
    }
  },
  methods: {
    async restoreFile(key) {
      try {
        this.showLoader = true
        await axios.post('/files/restore/user-upload/trashed', {keyId:key}).then(response => {
          router.reload()
          toast.success('Successfully restored!')
        })
      } catch(error) {
        console.log(error)
      } finally {
        this.showLoader = false
      }
    }
  },
  mounted() {
    console.log(this.trashedFile)
  }
}
</script>