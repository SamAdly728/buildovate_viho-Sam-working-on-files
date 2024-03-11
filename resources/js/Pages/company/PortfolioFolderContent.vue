<style>
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

.dropdown-content label {
  color: black;
  padding: 8px 16px;
  text-decoration: none;
  display: block;
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

.turn-black:hover {
  color: #0c0c0c !important;
  font-weight: 1000 !important;
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
  <div class="p-3">
    <div class="card">
      <div class="card-header pt-3 pb-3 flex justify-content-between">
        <div class="w-25 flex align-items-center">
          <i @click.prevent="goBack" class="icon-arrow-circle-left mr-2 ml-0 h5 mt-1 text-muted turn-black" style="cursor: pointer" title="Go Back"></i>
          <h5 class="text-muted" v-if="!editing" @click="startEditing">{{ folderName }}</h5>
          <input type="text" v-else v-model="editedText" @blur="finishEditing" @keyup.enter="finishEditing" class="form-control">
        </div>
        <div>
          <button class="btn btn-primary btn-sm float-right cl" data-bs-toggle="modal" data-bs-target="#uploadPortfolioFile">Upload</button>
          <button class="btn btn-danger btn-sm float-right mr-1 cl" @click="deleteFile" v-if="foldersFile.length > 0">Delete</button>
          <div class="dropdown float-right">
            <button @click="toggleAction" class="btn btn-info btn-sm mr-1">Filter</button>
            <div id="action-options" class="dropdown-content" style="z-index: 9999;">
              <label class="d-block" for="image">
                <input @change="updateDataArray('i')" class="checkbox_animated text-muted" id="image" type="checkbox" value="i">
                <span class="text-muted">Image</span>
              </label>
              <label class="d-block" for="video">
                <input @change="updateDataArray('v')" class="checkbox_animated text-muted" id="video" type="checkbox" value="v">
                <span class="text-muted">Video</span>
              </label>
            </div>
          </div>
          <label class="d-block float-end mr-2 mt-2" for="check-box" v-if="foldersFile.length > 0">
            <input class="checkbox_animated" id="check-box" type="checkbox" v-model="selectAll" @change="toggleSelectAll">
            <span class="text-muted">Select All</span>
          </label>
        </div>
      </div>
      <hr class="p-0 m-0">
      <div class="card-body ">
        <div class="gallery my-gallery row" itemscope="" v-if="foldersFile.length > 0">
          <figure class="col-xl-3 col-md-4 xl-33" itemprop="associatedMedia" itemscope="" v-for="file in filtered">
            <div class="d-flex align-items-center justify-content-between">
              <label class="d-inline" :for="'check-box'+file.user_file_upload_id" v-if="checkImageType(file.file_type)">
                <input class="checkbox_animated single-file-checkbox" :value="file.user_file_upload_id" :id="'check-box'+file.user_file_upload_id" type="checkbox"
                       v-model="selectedItems.selectedFileId" @change="checkSelectAllStatus">
              </label>
              <label class="d-inline" :for="'check-box'+file.user_file_upload_id" v-else>
                <input class="checkbox_animated single-file-checkbox" :value="file.user_file_upload_id" :id="'check-box'+file.user_file_upload_id" type="checkbox"
                       v-model="selectedItems.selectedFileId" @change="checkSelectAllStatus">
              </label>
            </div>
<!--            <a :href="file.s3Url" itemprop="contentUrl" data-size="1600x950">-->
            <transitiongroup>
              <img class="img-thumbnail" :src="file.s3Url" itemprop="thumbnail" alt="Image description" style="height: 350px; width: 100%; object-fit: cover" v-if="checkImageType(file.file_type)">
              <i class="icofont icofont-ui-video-play txt-primary p-0 m-0" v-else style="font-size: 380px"></i>
            </transitiongroup>
<!--            </a>-->
          </figure>
        </div>
        <div class="flex justify-content-center items-center align-middle" v-if="foldersFile.length == 0">
          <span>No Uploads yet.</span>
        </div>
      </div>
    </div>
  </div>

<!-- Upload Modal -->
  <div class="modal fade" id="uploadPortfolioFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-muted" id="exampleModalLabel">{{ folderInfo.folder_name }}</h5>
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
                          <input type="file" multiple hidden id="photoUpload" @input="uploadFile">
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
                      <div v-for="file in foldersFile">
                        <div v-if="wasUploadedJustNow(file.created_at)">
                          <hr class="mt-0 mb-0">
                          <div class="p-3">
                            <div class="row new-added" :data-id="file.user_file_upload_id">
                              <div class="d-flex align-items-center">
                                <i class="icofont icofont-check text-success mr-2 h4"></i>
                                <img :src="file.s3Url" alt="Uploaded Image" class="img-thumbnail mr-3" style="width: 50px; height: 50px;">
                                <span style="margin-right: 3rem" class="text-muted">{{ truncateFileName(file.file_name) }}</span>
                                <span style="margin-right: 4rem" class="text-muted"><small>{{ Math.trunc(Math.round(file.file_size / 1024 * 100) / 100) + ' KB' }}</small></span>
                                <button type="button" class="txt-danger" style="position: absolute; right: 18px" @click="deleteSinglePhoto(file.user_file_upload_id)">Remove</button>
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
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" @click="clearModalView">Done</button>
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
import {toast} from "vue3-toastify";
import axios from "axios";
import {router} from "@inertiajs/vue3";
import Swal from "sweetalert2";

export default {
  props:['foldersFile', 'folderInfo'],
  data() {
    return {
      showLoader: false,
      countUpload: 0,
      selectAll: false,
      selectedItems: {
        selectedFileId: []
      },
      fileUpload: {
        file: '',
        'upload-file-from' : this.folderInfo.folder_name,
        'folder-id' : this.folderInfo.file_folder_id,
        'page-from': 'portfolio'
      },
      editing: false,
      editedText: '',
      folderName: this.folderInfo.folder_name,
      filteredFile: this.foldersFile,
      checkBoxChoice: null,
      imageFileType: ['png', 'jpg', 'jpeg', 'JPG', 'JPEG', 'avif', 'webp']
    }
  },
  methods: {
    checkImageType(type) {
      if($.inArray(type, this.imageFileType) !== -1) {
        return true
      }
    },
    updateDataArray(key) {

      if (this.checkBoxChoice == key) {
        this.checkBoxChoice = null
      } else {
        this.checkBoxChoice = key
      }
    },
    toggleAction: function() {
      $('#action-options').slideToggle()
    },
    goBack() {
      return window.history.back()
    },
    startEditing() {
      this.editing = true;
      this.editedText = this.folderInfo.folder_name;
    },
    finishEditing() {
      this.editing = false;
      this.folderName = this.editedText; // Update the text with the edited text
      if (this.folderName.length == 0) {
        this.folderName = this.folderInfo.folder_name
        Swal.fire({
          text: 'Folder name cannot be empty!.',
          icon: "warning",
          buttonsStyling: false,
          confirmButtonText: "Close",
          customClass: {
            confirmButton: "btn btn-danger"
          }
        })
      }

      axios.post('/company/portfolio/save-folder-name', {'new-folder-name': this.folderName, 'folder-id': this.folderInfo.file_folder_id})
    },
    toggleSelectAll() {
      this.selectedItems.selectedFileId = this.selectAll
          ? this.foldersFile.map(item => item.user_file_upload_id)
          : [];
      this.$emit('selection-changed', this.selectedItems.selectedFileId);
    },
    checkSelectAllStatus() {
      this.selectAll = this.selectedItems.selectedFileId.length === this.foldersFile.length;
    },
    deleteFile() {
      if (this.selectedItems.selectedFileId.length === 0) {
        toast.error('No file has been selected!')
      } else {
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
              await axios.post('/files/delete/user-upload', thisInstance.selectedItems).then(response => {
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
      }
    },
    clearModalView() {
      this.selectedItems.selectedFileId = []
      router.reload()
      this.countUpload = 0
      const parentElement = document.getElementById('footer-display');
      const children = parentElement.children;

      for (let i = 0; i < children.length; i++) {
        children[i].remove()
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
    wasUploadedJustNow(uploadedTime) {
      let uploadDate = new Date(uploadedTime);
      let currentDate = new Date();
      let diffInMinutes = (currentDate - uploadDate) / (1000 * 60);
      return diffInMinutes < 1;
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
    async uploadFile() {
      this.fileUpload.file = event.target.files[0]
      // if (event.target.files[0].type.match('image.*') == null) {
      //   toast.error('File type is not allowed!')
      // } else {
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
      // }
    },
  },
  mounted() {
    $('#uploadPortfolioFile').on('shown.bs.modal', function () {
      $('#action-options').slideUp()
    });

    $('.cl').on('click', function() {
      $('#action-options').slideUp()
    })

  },
  computed: {

    filtered() {
      let thisInstance = this
      let newArray = []
      if (this.checkBoxChoice == 'i') {
        $('#video').prop('checked', false)
        $.each(this.foldersFile, function(key, val) {
          if ($.inArray(val.file_type, thisInstance.imageFileType) !== -1) {
            newArray.push(val)
          }
        })
        return newArray
      }

      if (this.checkBoxChoice == 'v') {
        $('#image').prop('checked', false)
        $.each(this.foldersFile, function(key, val) {
          if ($.inArray(val.file_type, thisInstance.imageFileType) === -1) {
            newArray.push(val)
          }
        })
        return newArray
      }

      return this.foldersFile
    }
  }
}
</script>