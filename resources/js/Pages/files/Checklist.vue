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
.dz-remove {
  cursor: pointer !important;
}

svg {
  pointer-events: none !important;
}

.files {
  cursor: default !important;
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
                  <h5 class="text-muted d-inline">Checklist</h5>
                  <span style="margin-top: .4rem" class="ml-2 text-success" v-if="selected_jobsite"><b>-</b> {{ jobsiteName }}</span>
                  <button class="btn btn-primary btn-sm float-end d-inline" data-bs-toggle="modal" data-bs-target="#uploadFile">Upload</button>
                  <button class="btn btn-danger btn-sm float-end mr-1" @click="deleteFile">Delete</button>
                  <transition>
                    <label v-if="gridView" class="d-block float-end mr-2 mt-2" for="check-box">
                      <input class="checkbox_animated" id="check-box" type="checkbox" v-model="selectAll" @change="toggleSelectAll">
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
              <div class="card-body file-manager overflow-x-hidden overflow-y-auto custom-scrollbar" style="max-height: 700px" v-if="gridView">
                <ul class="files" >
                  <li class="file-box mr-3 mb-2" v-for="file in checklistsFile">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="d-inline" :for="'check-box'+file.user_file_upload_id">
                        <input class="checkbox_animated single-file-checkbox" :value="file.user_file_upload_id" :id="'check-box'+file.user_file_upload_id" type="checkbox" v-model="selectedItems.selectedFileId" @change="checkSelectAllStatus">
                      </label>
                      <i title="Add to favorite" class="icon-star h5 ml-4 p-2" :class="{ 'fav-color': file.favorite }" :id="file.user_file_upload_id" style="cursor: pointer" @click="addToFavorite"></i>
                    </div>
                    <a :href="'/files/preview/user-upload/'+file.user_file_upload_id" target="_blank">
                      <img style="width: 100%; height: 200px" :src="file.s3Url" alt="">
                    </a>
                  </li>
                </ul>
              </div>
              <div class="card-body file-manager">
                <div class="table-responsive" v-if="listView" style="max-height: 700px; min-height: auto">
                  <table class="table table-hover" >
                    <thead>
                    <tr>
                      <th class="text-muted">
                        <input class="checkbox_animated" type="checkbox" v-model="selectAll" @change="toggleSelectAll" title="Select All">Name</th>
                      <th class="text-muted">Favorite</th>
                      <th class="text-muted">Size</th>
                      <th class="text-muted">Added</th>
                      <transition>
                        <th v-if="!selectAll" class="text-muted">Actions</th>
                      </transition>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="file in checklistsFile" >
                      <td class="d-flex align-items-center">
                        <input class="checkbox_animated" type="checkbox" :value="file.user_file_upload_id" :id="file.user_file_upload_id" v-model="selectedItems.selectedFileId" @change="checkSelectAllStatus">
                        <!--                        <img class="ml-1" style="max-width: 50px; max-height: 50px; object-fit: cover; cursor: pointer" :src="photo.s3Url" alt="" @click="previewModal(photo.s3Url)" data-bs-toggle="modal" data-bs-target="#modal-preview">-->
                        <a :href="'/files/preview/user-upload/'+file.user_file_upload_id" target="_blank">
                          <img class="ml-1" style="max-width: 50px; max-height: 50px; object-fit: cover; cursor: pointer" :src="file.s3Url" alt="">
                        </a>
                        <span class="ml-3 text-muted">{{ file.file_name }}</span>
                      </td>
                      <td class="text-muted">
                        <i title="Add to favorite" class="icon-star h5 ml-4 p-2 " :class="{ 'fav-color': file.favorite }" :id="file.user_file_upload_id" style="cursor: pointer" @click="addToFavorite"></i>
                        <!--                        <i title="Add to favorite" class="icofont icofont-star h5 ml-5 fav-icon p2" :class="{ 'fav-color': photo.favorite }" :id="photo.user_file_upload_id" style="cursor: pointer" @click="addToFavorite"></i>-->
                      </td>
                      <td class="text-muted"> {{ Math.trunc(Math.round(file.file_size / 1024 * 100) / 100) + ' KB' }} </td>
                      <td class="align-items-center text-muted">{{ formatDateValue(file.created_at) }}</td>
                      <transition>
                        <td v-if="!selectAll">
                          <a href="#" class="text-muted mr-2">Share</a>
                          <a class="text-success mr-2" :href="file.s3Url">Download</a>
                          <a class="text-danger" href="#" v-if="!selectAll" @click="deleteSinglePhoto(file.user_file_upload_id)">Delete</a>
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
  <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-muted" id="exampleModalLabel">Upload Files - Contracts</h5>
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
                      <label class="btn btn-primary mt-3" for="photoUpload">
                        Browse
                        <form action="" @submit.prevent="uploadFile">
                          <input type="file" multiple hidden id="photoUpload" accept="image/*" @input="uploadFile">
                        </form>
                      </label>
                    </div>
                  </div>
                  <div class="overflow-auto" >
                    <!-- Upload Footer-->
                    <div v-if="countUpload > 0">
                      <hr class="mt-0 mb-0">
                      <div class="p-3">
                        <span class="text-muted">{{ countUpload }} File</span>
                        <a href="#"><span class="txt-danger float-end"  @click="deleteItemFromModal">Clear All</span></a>
                      </div>
                    </div>
                    <div id="footer-display">
                      <div v-for="contract in checklistsFile">
                        <div v-if="wasUploadedJustNow(contract.created_at)">
                          <hr class="mt-0 mb-0">
                          <div class="p-3">
                            <div class="row new-added" :data-id="contract.user_file_upload_id">
                              <div class="d-flex align-items-center">
                                <i class="icofont icofont-check text-success mr-2 h4"></i>
                                <img :src="contract.s3Url" alt="Uploaded Image" class="img-thumbnail mr-3" style="width: 50px; height: 50px;">
                                <span style="margin-right: 3rem" class="text-muted">{{ truncateFileName(contract.file_name) }}</span>
                                <span style="margin-right: 4rem" class="text-muted"><small>{{ Math.trunc(Math.round(contract.file_size / 1024 * 100) / 100) + ' KB' }}</small></span>
                                <button type="button" class="txt-danger" style="position: absolute; right: 18px" @click="deleteSinglePhoto(contract.user_file_upload_id)">Remove</button>
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
                    Coming Soon.
                  </div>
                </div>

                <div class="card rounded">
                  <div class="card-header rounded p-3">
                    <h6 class="mb-0"><span class="text-muted">Notifications</span></h6>
                  </div>
                  <hr class="mb-0 mt-0">
                  <div class="card-body p-3">
                    Coming Soon.
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
import { selected_jobsite } from '../../globalState';
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
import { router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import axios from "axios";

import { usePage } from '@inertiajs/vue3';
import Swal from "sweetalert2";

const page = usePage();

export default {
  components: {
    sideMenu
  },
  props: ['checklistsFile', 'userFolder'],
  data() {
    return {
      showLoader: false,
      gridView: false,
      listView: true,
      uploadIcon: window.location.origin + '/assets/images/upload-100.png',
      selectAll: false,
      selectedItems: {
        selectedFileId: []
      },
      countUpload: 0,
      fileUpload: {
        file: '',
        'upload-file-from' : 'checklist'
      },
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
    async uploadFile() {
      let thisInstance = this
      this.fileUpload.file = event.target.files[0]
      if (event.target.files[0].type.match('image.*') == null) {
        toast.error('File type is not allowed!')
      } else {
        try {
          this.showLoader = true
          await axios.post('/files/save/user-upload', this.fileUpload, {
            headers: {
              'Content-Type': 'multipart/form-data',
            }
          }).then(response => {
            this.selectedItems.selectedFileId.push(response.data.user_file_upload_id)
            this.countUpload++
            router.reload()
            toast.success('Successfully Added! ')
          })
        } catch (error) {
          console.log(error)
        } finally {
          this.showLoader = false
        }
      }
    },
    async deleteItemFromModal() {
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
      }).then(async function (res) {
        if (res.isConfirmed) {
          thisInstance.showLoader = true
          try {
            await axios.post('/files/delete/user-upload', thisInstance.selectedItems).then(response => {
              router.reload()
              thisInstance.countUpload = 0
              toast.error('Successfully Deleted!')
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
    wasUploadedJustNow(uploadedTime) {
      let uploadDate = new Date(uploadedTime);
      let currentDate = new Date();
      let diffInMinutes = (currentDate - uploadDate) / (1000 * 60);
      return diffInMinutes < 1;
    },
    truncateFileName: function(val) {
      if (val.length > 10) {
        return val.substring(0, 10 - 3) + '...';
      }
      return val;
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
    clearModalView() {
      // this.hideFooter = false
      // this.hideAppendFiles =
      this.selectedItems.selectedFileId = []
      router.reload()
      this.countUpload = 0
      // $('#footer-display').empty()
      const parentElement = document.getElementById('footer-display');
      const children = parentElement.children;

      for (let i = 0; i < children.length; i++) {
        children[i].remove()
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
    toggleSelectAll() {
      this.selectedItems.selectedFileId = this.selectAll
          ? this.checklistsFile.map(item => item.user_file_upload_id)
          : [];
      this.$emit('selection-changed', this.selectedItems.selectedFileId);
    },
    checkSelectAllStatus() {
      this.selectAll = this.selectedItems.selectedFileId.length === this.checklistsFile.length;
    },
    deleteFile() {
      if (this.selectedItems.selectedFileId.length === 0) {
        toast.error('No file has been selected!')
      } else {
        axios.post('/files/delete/user-upload', this.selectedItems).then(response => {
          if (response.data && response.status == 200) {
            router.reload()
            toast.success('Successfully deleted!')
          }
        })
      }
    }
  },
  mounted() {
    // Dropzone.options.checklistFiles = {
    //   paramName: "file",
    //   maxFiles: 10,
    //   maxFilesize: 10,
    //   acceptedFiles: "image/*,text/*,application/pdf",
    //   headers: {
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   },
    //   accept: function(file, done) {
    //     done()
    //   },
    //   init: function() {
    //
    //     let myDropzone = this
    //
    //     myDropzone.on("addedfile", function(file){
    //       router.reload()
    //     })
    //
    //     myDropzone.on("success", function(file){
    //       router.reload()
    //     })
    //
    //     this.on("error", function(file, errorMessage) {
    //
    //       if (errorMessage.length > 1) {
    //         $('.dz-details').hide()
    //       }else{
    //         $('.dz-remove').show()
    //       }
    //
    //     })
    //   }
    // };
    //
    // let dz = new Dropzone('#checklistFiles')
    //
    // $('#uploadFile').on('hidden.bs.modal', function (e) {
    //   // Remove all files from the dropzone
    //   dz.removeAllFiles();
    //   router.reload()
    // });

    let thisInstance = this
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