<style scoped>
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  margin-top: 5px;
  display: none;
  position: absolute;
  /* //background-color: white; */
  min-width: 180px;
  overflow: auto;
  /* //box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); */
  z-index: 1;
  /* //border: solid 1px #e6edef; */
  border-color: #e6edef;
  background-color: #e6edef;
  border-radius: 3px;
  animation: fadeIn .1s;
}

.dropdown-content a {
  color: black;
  padding: 8px 16px;
  text-decoration: none;
  display: block;
}
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

.custom-modal-body-background {
  background: #ececec;
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

.photo-image-container {
  position: relative !important;
  display: inline-block !important; /* So that the container fits the image size */
}

.photo-img-fluid {
//max-width: 100% !important;
//height: auto !important;
  display: block !important; /* Removes the bottom space caused by inline nature of images */
}

.photo-overlay-checkbox {
  position: absolute !important;
  top: 15px !important;  /* Adjust as needed */
  left: 25px !important;  /* Adjust as needed */
  z-index: 1 !important;
}

.fav-color {
  color: #fcc200
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
  <div class="p-2 overflow-auto custom-scrollbar" v-if="blockPage">
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
                  <h5 class="text-muted d-inline">Videos</h5>
                  <span style="margin-top: .4rem" class="ml-2 text-success" v-if="selected_jobsite"><b>-</b> {{ jobsiteName }}</span>
                  <button class="btn btn-primary btn-sm float-end d-inline" data-bs-toggle="modal" data-bs-target="#uploadVideos">Upload</button>
                  <button class="btn btn-danger btn-sm float-end d-inline mr-2" @click="deleteAll">Delete</button>
                  <transition>
                    <label class="d-block float-end mr-2 mt-2" for="check-box-photo" v-if="gridView">
                      <input class="checkbox_animated" id="check-box-photo" type="checkbox" v-model="selectAll" @change="toggleSelectAll">
                      <span class="text-muted">Select All</span>
                    </label>
                  </transition>
                  <transition>
                    <div v-if="selectAll || selectedItems.selectedFileId.length > 0" class="dropdown mr-2 float-end">
                      <button id="action-button" @click="toggleAction" class="btn btn-secondary btn-sm">Action</button>
                      <div id="action-options" class="dropdown-content" style="z-index: 9999;">
                        <a class="text-muted" href="#">Share</a>
                        <a class="text-muted" href="#" @click="bulkDownload">Download</a>
                      </div>
                    </div>
                  </transition>
                </div>
                <div class="input-group mt-3 mb-0">
                    <span class="input-group-text" id="grid-view" style="cursor: pointer">
                      <i class="fa fa-th" id="grid-view-icon"></i>
                    </span>
                  <span class="input-group-text" id="list-view" style="cursor: pointer">
                      <i class="fa fa-list-ul" id="list-view-icon"></i>
                    </span>
                </div>
              </div>
              <div class="file-manager" v-if="gridView">
                <div class="gallery my-gallery card-body row" itemscope="" >
                  <figure class="col-xl-3 col-md-4 xl-33" itemprop="associatedMedia" itemscope="" v-for="video in videoFile">
<!--                      <img class="img-thumbnail photo-img-fluid" :src="video.s3Url" itemprop="thumbnail" alt="Image description" style="width: auto; height: 200px">-->
                    <a :href="'/files/preview/user-upload/'+video.user_file_upload_id" target="_blank" class="img-thumbnail photo-img-fluid">
                      <i class="icofont icofont-ui-video-play " style="margin-left: 25px; font-size: 200px; width: 200px; height: 200px"></i>
                    </a>
                    <input class="photo-overlay-checkbox checkbox_animated" type="checkbox" :value="video.user_file_upload_id" :id="video.user_file_upload_id"
                           v-model="selectedItems.selectedFileId" @change="checkSelectAllStatus">
                    <figcaption itemprop="caption description" class="text-muted mt-2">
                      {{ truncateFileName(video.file_name) }}
                      <i title="Add to favorite" class="icon-star h5 p-2 float-end" :class="{ 'fav-color': video.favorite }" :id="video.user_file_upload_id" style="cursor: pointer" @click="addToFavorite"></i>
                    </figcaption>
                  </figure>
                </div>
              </div>
              <div class="table-responsive p-3" v-if="listView">
              <table class="table table-hover">
                <thead>
                <tr>
                  <th class="text-muted"><input class="checkbox_animated" type="checkbox" v-model="selectAll" @change="toggleSelectAll" title="Select All"> Name</th>
                  <th class="text-muted">Favorite</th>
                  <th class="text-muted">Size</th>
                  <th class="text-muted">Added</th>
                  <transition>
                    <th v-if="!selectAll" class="text-muted">Actions</th>
                  </transition>
                </tr>
                </thead>
                <tbody>
                <tr v-for="video in videoFile" >
                  <td class="d-flex align-items-center">
                    <input class="checkbox_animated" type="checkbox" :value="video.user_file_upload_id" :id="video.user_file_upload_id" v-model="selectedItems.selectedFileId" @change="checkSelectAllStatus">
<!--                    <img class="ml-1" style="max-width: 50px; max-height: 50px; object-fit: cover; cursor: pointer" :src="video.s3Url" alt="" -->
<!--                         @click="previewModal(video.s3Url)" data-bs-toggle="modal" data-bs-target="#modal-preview">-->
                    <a :href="'/files/preview/user-upload/'+video.user_file_upload_id" target="_blank">
                      <i class="icofont icofont-ui-video-play h4"></i>
                    </a>
                    <span class="ml-3 text-muted">{{ video.file_name }}</span>
                  </td>
                  <td class="text-muted">
<!--                    <i title="Add to favorite" class="icofont icofont-star h5 ml-5 fav-icon p2" :class="{ 'fav-color': video.favorite }" :id="video.user_file_upload_id" style="cursor: pointer" @click="addToFavorite"></i>-->
                    <i title="Add to favorite" class="icon-star h5 ml-4 p-2 " :class="{ 'fav-color': video.favorite }" :id="video.user_file_upload_id" style="cursor: pointer" @click="addToFavorite"></i>
<!--                    <i class="fa fa-star-o"></i>-->
                  </td>
                  <td class="text-muted"> {{ Math.trunc(Math.round(video.file_size / 1024 * 100) / 100) + ' KB' }} </td>
                  <td class="align-items-center text-muted">{{ formatDateValue(video.created_at) }}</td>
                  <transition>
                    <td v-if="!selectAll">
                      <a href="#" class="text-muted mr-2">Share</a>
                      <a class="text-success mr-2" :href="video.s3Url">Download</a>
                      <a class="text-danger" href="#" v-if="!selectAll" @click="deleteSinglePhoto(video.user_file_upload_id)">Delete</a>
                    </td>
                  </transition>
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
  <div class="container" v-if="!selected_jobsite">
    <div class="row">
      <div class="col d-flex justify-content-center align-items-center" style="height: 200px;">
        <div class="text-center">
          <h3 class="text-success">Select a Jobsite.</h3>
        </div>
      </div>
    </div>
  </div>
<!-- Upload modal  -->
  <div class="modal fade" id="uploadVideos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-muted" id="exampleModalLabel">Upload Files - Videos</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="">
          <div class="card-body custom-modal-body-background">
            <div class="row">
              <div class="col-md-5">
                <div class="card rounded">
                  <div class="d-flex flex-column align-items-center">
                    <div class="p-5 d-flex flex-column align-items-center" style="width: 300px; cursor: pointer;">
                      <div style="font-size: 4rem;">
                        <i class="far fa-file-alt"></i>
                      </div>
                      <span class="mt-3">Drop files here to upload, or browse for files.</span>
                      <label class="btn btn-primary mt-3" for="videoUpload">
                        Browse
                        <form action="" @submit.prevent="uploadFile">
                          <input type="file" multiple hidden id="videoUpload" accept="video/*" @input="uploadFile" @change="removeOldItem">
                        </form>
                      </label>
                    </div>
                  </div>
                  <div class="overflow-auto">
                    <!-- Upload Footer-->
                    <div v-if="countUpload > 0">
                      <hr class="mt-0 mb-0">
                      <div class="p-3">
                        <span class="text-muted"> {{ countUpload }} File</span>
                        <a href="#"><span class="txt-danger float-end" @click="deleteItemFromVideoModal">Clear All</span></a>
                      </div>
                    </div>
                    <div id="video-footer-display">
                      <div v-for="video in videoFile">
                        <div v-if="videoWasUploadedJustNow(video.created_at)">
                          <hr class="mt-0 mb-0">
                          <div class="p-3">
                            <div class="row new-added-video" :data-id="video.user_file_upload_id">
                              <div class="d-flex align-items-center">
                                <i class="icofont icofont-check text-success mr-2 h4"></i>
    <!--                            <img :src="video.s3Url" alt="Uploaded Image" class="img-thumbnail mr-3" style="width: 50px; height: 50px;">-->
                                <i class="icofont icofont-ui-video-play txt-success mr-1 mb-0 h4"></i>
                                <span style="margin-right: 3rem" class="text-muted">{{ truncateFileName(video.file_name) }}</span>
                                <span style="margin-right: 4rem" class="text-muted"><small>{{ Math.trunc(Math.round(video.file_size / 1024 * 100) / 100) + ' KB' }}</small></span>
                                <button type="button" class="txt-danger" style="position: absolute; right: 18px" @click="deleteSinglePhoto(video.user_file_upload_id)">Remove</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End of upload footer-->
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card rounded">
                  <div class="card-header rounded p-3">
                    <h6 class="mb-0"><span class="text-muted">Set Viewing Access to 1 Document</span></h6>
                  </div>
                  <hr class="mb-0 mt-0">
                  <div class="card-body p-3">
                      Coming Soon
                  </div>
                </div>

                <div class="card rounded">
                  <div class="card-header rounded p-3">
                    <h6 class="mb-0"><span class="text-muted">Notifications</span></h6>
                  </div>
                  <hr class="mb-0 mt-0">
                  <div class="card-body p-3">
                      Coming Soon
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" @click="clearModalView">Close</button>
            <!--            <button class="btn btn-primary" type="button" @click="onClickSave" :disabled="!photoFile.length">Save</button>-->
          </div>
        </div>
      </div>
    </div>
  </div>

  </template>
<script setup>
import LoadingMetric from '@/components/LoadingStyleMetric.vue';
import {selected_jobsite} from "@/globalState.js";
import { ref, watch} from "vue";

const blockPage = ref(true)
let jobsiteName = ''

if (selected_jobsite.value != null) {
  jobsiteName = ref(selected_jobsite.value.jobsite_name)
} else {
  blockPage.value = false
}

watch(selected_jobsite, (val) => {
  jobsiteName = val.jobsite_name
  blockPage.value = true
})
</script>
<script>
import sideMenu from "@/components/user_files/FileSideMenu.vue"
import comingSoon from "@/components/comingSoon.vue"

import {router, usePage} from '@inertiajs/vue3';
import {toast} from "vue3-toastify";
import axios from "axios";
import Swal from "sweetalert2";

const page = usePage();

export default {
  components: {
    sideMenu,
    comingSoon
  },
  props: ['videoFile', 'userFolder'],
  data() {
    return {
      showLoader: false,
      fileUpload: {
        file: '',
        'upload-file-from' : 'videos'
      },
      selectAll: false,
      selectedItems: {
        selectedFileId: []
      },
      gridView: false,
      listView: true,
      previewUrl: '',
      isFav: false,
      countUpload: 0
    }
  },
  methods: {
    async bulkDownload() {
      if (this.selectedItems.selectedFileId.length == 0) {
        toast.error('No File has been selected!')
      } else {
        try {
          this.showLoader = true
          await axios.post('/files/download/user-upload/bulk-download', this.selectedItems).then(response => {
            console.log(response)
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'files.zip');
            document.body.appendChild(link);
            link.click();
          })
        } catch (error) {
          console.log(error)
        }finally {
          this.showLoader = false
          $('#action-options').slideUp()
          this.selectAll = false
          this.selectedItems.selectedFileId = []
        }
      }
    },
    toggleAction: function() {
      $('#action-options').slideToggle()
    },
    clearModalView() {

      this.selectedItems.selectedFileId = []
      router.reload()
      this.countUpload = 0
      // $('#footer-display').empty()
      const parentElement = document.getElementById('video-footer-display');
      const children = parentElement.children;

      for (let i = 0; i < children.length; i++) {
        children[i].remove()
      }
    },
    videoWasUploadedJustNow(uploadedTime) {
      let uploadDate = new Date(uploadedTime);
      let currentDate = new Date();
      let diffInMinutes = (currentDate - uploadDate) / (1000 * 60);
      return diffInMinutes < 1;
    },
    toggleSelectAll() {
      this.selectedItems.selectedFileId = this.selectAll
          ? this.videoFile.map(item => item.user_file_upload_id)
          : [];
      this.$emit('selection-changed', this.selectedItems.selectedFileId);
    },
    checkSelectAllStatus() {
      this.selectAll = this.selectedItems.selectedFileId.length === this.videoFile.length;
    },
    async deleteItemFromVideoModal() {
      let thisInstance = this
      let elements = document.getElementsByClassName('new-added-video');
      for (let i = 0; i < elements.length; i++) {
        let elementNew = elements[i];
        thisInstance.selectedItems.selectedFileId.push(elementNew.getAttribute('data-id'));
      }
      Swal.fire({
        html: "Are You Sure?<br>Your deleted items will remain in the Trash folder for the next <i><b>30 days</b></i> in case you decide you want your files back, after that it will be permanently deleted.",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        customClass: {
          confirmButton: "btn btn-danger",
          cancelButton: "btn btn-active-light"
        }
      }).then(async function (res) {
        if (res.isConfirmed) {
          thisInstance.showLoader = true
          try {
            await axios.post('/files/delete/user-upload', thisInstance.selectedItems).then(response => {
              thisInstance.countUpload = 0
              toast.error('Successfully Deleted!')
              router.reload()
            })
          } catch (error) {
            console.log(error)
          } finally {
            // thisInstance.selectAll = false
            thisInstance.countUpload = 0
            thisInstance.showLoader = false
            router.reload()
          }
        }
      })
    },
    async deleteAll() {
      let thisInstance = this
      this.selectedItems.selectedFileId = this.videoFile.map(item => item.user_file_upload_id)
      if (!this.selectedItems.selectedFileId.length) {
        toast.error('No file has been selected!')
        this.selectAll = false
      } else {
        Swal.fire({
          html: "Are You Sure?<br>Your deleted items will remain in the Trash folder for the next <i><b>30 days</b></i> in case you decide you want your files back, after that it will be permanently deleted.",
          icon: "warning",
          showCancelButton: true,
          buttonsStyling: false,
          confirmButtonText: "Delete",
          cancelButtonText: "Cancel",
          customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-active-light"
          }
        }).then(async function (res) {
          if (res.isConfirmed) {
            thisInstance.showLoader = true
            try {
              await axios.post('/files/delete/user-upload', thisInstance.selectedItems).then(response => {
                toast.error('Successfully Deleted!')
                router.reload()
              })
            } catch (error) {
              console.log(error)
            } finally {
              thisInstance.selectAll = false
              thisInstance.showLoader = false
            }
          }
        })
      }
    },
    async deleteSinglePhoto(id) {
      let thisInstance = this
      Swal.fire({
        html: "Are You Sure?<br>Your deleted items will remain in the Trash folder for the next <i><b>30 days</b></i> in case you decide you want your files back, after that it will be permanently deleted.",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        customClass: {
          confirmButton: "btn btn-danger",
          cancelButton: "btn btn-active-light"
        }
      }).then(async function(res) {
        if (res.isConfirmed) {
          thisInstance.showLoader = true
          try {
            await axios.post('/files/delete/user-upload', {'selectedFileId': id}).then(response => {
              toast.error('Successfully Deleted!')
              router.reload()
            })
          } catch (error) {
            console.log(error)
          } finally {
            thisInstance.showLoader = false
          }
        }
      })

    },
    truncateFileName: function(val) {
      if (val.length > 10) {
        return val.substring(0, 10 - 3) + '...';
      }
      return val;
    },
    async uploadFile() {
      this.fileUpload.file = event.target.files[0]
      if (event.target.files[0].type.match('video.*') == null) {
        toast.error('File type is not allowed!')
      } else {
        try {
          this.showLoader = true
          await axios.post('/files/save/user-upload', this.fileUpload, {
            headers: {
              'Content-Type': 'multipart/form-data',
            }
          }).then(response => {
            this.countUpload++
            router.reload()
            toast.success('Successfully Added! ')
            this.selectedItems.selectedFileId = this.photoFile.map(item => item.user_file_upload_id)
          })
        } catch (error) {
          console.log(error)
        } finally {
          this.showLoader = false
        }
      }
    },
    previewModal(url) {
      this.previewUrl = url
    },
    addToFavorite() {
      $(document).on('click', '#'+String(event.target.id), function(){
        $(this).toggleClass('fav-color')
        if ($(this).hasClass('fav-color')) {
          axios.post('/files/update/user-upload/favorite', {'upload-id': event.target.id, 'flag': 1}).then(response => {router.reload()})
        } else {
          axios.post('/files/update/user-upload/favorite', {'upload-id': event.target.id, 'flag': 0}).then(response => {router.reload()})
        }
      })
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
    // console.log(this.videoFile)
    let thisInstance = this
    // console.log(this.photoFile)
    if (this.gridView) {
      $('#grid-view').addClass('border-success z-10')
      $('#grid-view-icon').addClass('text-success')
      $('#list-view-icon').addClass('text-muted')
    }else{
      $('#grid-view').addClass('text-muted')
      $('#list-view').addClass('border-success z-10')
      $('#list-view-icon').addClass('text-success').removeClass('text-muted')
    }

    $(document).on('click', '#list-view', function() {
      thisInstance.listView = true
      thisInstance.gridView = false
      thisInstance.selectAll = false
      thisInstance.selectedItems.selectedFileId = []
      $('#grid-view').removeClass('border-success z-10')
      $('#grid-view-icon').removeClass('text-success')
      $('#grid-view-icon').addClass('text-muted')
      $('#list-view').addClass('border-success z-10')
      $('#list-view-icon').addClass('text-success').removeClass('text-muted')
    })

    $(document).on('click', '#grid-view', function() {
      thisInstance.listView = false
      thisInstance.gridView = true
      thisInstance.selectAll = false
      thisInstance.selectedItems.selectedFileId = []
      $('#grid-view').addClass('border-success z-10')
      $('#grid-view-icon').addClass('text-success')
      $('#grid-view-icon').removeClass('text-muted')
      $('#list-view').removeClass('border-success z-10')
      $('#list-view-icon').removeClass('text-success').addClass('text-muted')
    })
  }
}
</script>