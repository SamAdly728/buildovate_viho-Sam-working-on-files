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

.centered-on-screen {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 9999;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.5) !important;
}

backdrop {
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.5) !important;
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
                  <h5 class="text-muted d-inline">Starred</h5>
<!--                  <button class="btn btn-primary btn-sm float-end d-inline" data-bs-toggle="modal" data-bs-target="#uploadFile">Upload</button>-->
                </div>
              </div>
              <div class="card-body file-manager">
                <div class="table-responsive" style="min-height: auto; max-height: 700px">
                  <table class="table table-hover">
                    <thead>
                    <tr>
                      <th class="text-muted">
<!--                        <input class="checkbox_animated" type="checkbox" v-model="selectAll" @change="toggleSelectAll" title="Select All">-->
                        Name
                      </th>
                      <th class="text-muted">Size</th>
                      <th class="text-muted">Added</th>
                      <th class="text-muted">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr v-for="file in starredFile">
                        <td class="d-flex align-items-center">
                          <img class="mr-5" style="max-width: 50px; max-height: 50px; object-fit: cover; cursor: pointer" :src="file.s3Url" alt="" v-if="file.file_type != 'mp4'">
                          <i class="icofont icofont-ui-video-play text-success mb-0 mr-6 ml-1 h1" v-if="file.file_type == 'mp4'"></i>
                          <span class="text-muted">{{ file.file_name }}</span>
                        </td>
                        <td class="text-muted">{{ Math.trunc(Math.round(file.file_size / 1024 * 100) / 100) + ' KB' }}</td>
                        <td>{{ formatDateValue(file.created_at) }}</td>
                        <td>
                          <a class="mr-2" :href="file.s3Url"><span class="text-success">Download</span></a>
                          <a href="#"><span class="text-danger" @click="deleteSinglePhoto(file.user_file_upload_id)">Delete</span></a>
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

import {router, usePage} from '@inertiajs/vue3';
import axios from "axios";
import {toast} from "vue3-toastify";

const page = usePage();

export default {
  components: {
    sideMenu
  },
  props: ['starredFile', 'userFolder'],
  data() {
    return {
      showLoader: false
    }
  },
  methods: {
    async deleteSinglePhoto(id) {
      this.showLoader = true
      try {
        await axios.post('/files/delete/user-upload', {'selectedFileId': id}).then(response => {
          toast.error('Successfully Deleted!')
          router.reload()
        })
      } catch (error) {
        console.log(error)
      } finally {
        this.showLoader = false
      }
    },
    formatDateValue(date) {
      let newDate = new Date(date)
      const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      const month = months[newDate.getMonth()];
      const day = newDate.getDate();
      const year = newDate.getFullYear();

      let hours = newDate.getHours();
      const minutes = newDate.getMinutes();

      const ampm = hours >= 12 ? 'PM' : 'AM';

      // Convert to 12-hour format
      hours = hours % 12;
      hours = hours ? hours : 12; // Convert "0" hour to "12" for 12-hour format

      // Pad minutes with a zero if less than 10
      const minutesStr = minutes < 10 ? '0' + minutes : minutes;

      return `${month} ${day}, ${year}, ${hours}:${minutesStr} ${ampm}`;
    }
  },
  mounted() {
    router.reload()
  }
}
</script>