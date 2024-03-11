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
</style>
<template>
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
                  <h5 class="text-muted d-inline">Google Drive</h5>
                  <button class="btn btn-primary btn-sm float-end d-inline" data-bs-toggle="modal" data-bs-target="#uploadFile">Add New</button>
                </div>
              </div>
              <div class="card-body file-manager">
                <comingSoon/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import sideMenu from "@/components/user_files/FileSideMenu.vue"
import comingSoon from "@/components/comingSoon.vue"

import { usePage } from '@inertiajs/vue3';

const page = usePage();

export default {
  components: {
    sideMenu,
    comingSoon
  },
  props: ['userFolder'],
  data() {
    return {

    }
  },
  mounted() {

    // console.log(this.videoUrl)
    // let video = document.getElementById('coming-soon')
    //
    // video.src = this.videoUrl
    // video.play()
  }
}
</script>