<style scoped>
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

.backdrop {
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

  <div class="p-3">
    <div class="card file-content">
      <div class="card-header pt-3 pb-0 d-flex align-items-center justify-content-between">
        <div class="card-title h5 text-success">Portfolio</div>
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-original-title="addFolder" data-bs-target="#addFolder">Create Album</button>
      </div>
      <hr class="p-0">

      <div class="card-body pt-0 file-manager">
        <div class="row">
          <div class="col-md-3" v-for="folder in folders">
            <div class="card rounded">
              <Link v-if="folder.s3Url" :href="'/company/portfolio/content/'+folder.file_folder_id">
                <img :src="folder.s3Url" class="w-100 p-2 pb-0" alt="..." style="max-height: 183px; object-fit: cover" v-if="checkExtension(folder.s3Url)">
                <i class="icofont icofont-ui-video-play" v-else style="font-size: 183px; top: 50%; margin-left: 80px"></i>
              </Link>
              <Link v-else :href="'/company/portfolio/content/'+folder.file_folder_id" class="p-5 text-center">
                <span>No Uploads Yet</span>
              </Link>
              <div class="p-2" title="Click on the folder name or description to edit.">
                <h5 class="card-title" @click="editFolderAndDesc(folder)">{{ folder.folder_name }}</h5>
                <p class="card-text" @click="editFolderAndDesc(folder)">{{ folder.folder_desc }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header pb-0">
            <div class="card-title h6 text-muted">Recently Added</div>
          </div>
          <hr class="pb-0 mb-1">
          <div class="card-body pt-0">
            <div class="table-responsive table-fixed-bottom pt-0 mt-0">
              <table class="table table-hover">
                <thead>
                <tr>
                  <th class="text-muted">Name</th>
                  <th class="text-muted">Folder</th>
                  <th class="text-muted">Date Added</th>
                  <th class="text-muted">Size</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="file in allFiles">
                  <td><small>{{file.file_name}}</small></td>
                  <td><Link title="Go To Folder" :href="'/company/portfolio/content/'+file.folder_id"><small class="text-primary">{{file.upload_from}}</small></Link></td>
                  <td><small>{{formatDateValue(file.created_at)}}</small></td>
                  <td><small>{{Math.trunc(Math.round(file.file_size / 1024 * 100) / 100) + ' KB'}}</small></td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-header pb-0">
            <div class="card-title h6 text-muted">Recently Deleted</div>
          </div>
          <hr class="pb-0 mb-1">
          <div class="card-body pt-0">
            <div class="table-responsive table-fixed-bottom pt-0 mt-0">
              <table class="table table-hover">
                <thead>
                <tr>
                  <th class="text-muted">Name</th>
                  <th class="text-muted">Date Added</th>
                  <th class="text-muted">Date Deleted</th>
                  <th class="text-muted">Size</th>
                  <th class="text-muted"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="deleted in deletedFiles">
                  <td><small>{{deleted.file_name}}</small></td>
                  <td><small>{{formatDateValue(deleted.created_at)}}</small></td>
                  <td><small>{{formatDateValue(deleted.deleted_at)}}</small></td>
                  <td><small>{{Math.trunc(Math.round(deleted.file_size / 1024 * 100) / 100) + ' KB'}}</small></td>
                  <td class="text-primary"><small @click="restore(deleted.user_file_upload_id)" style="cursor: pointer">Restore</small></td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addFolder" tabindex="-1" role="dialog" aria-labelledby="addFolder" aria-hidden="true" style="position: fixed">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Album</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label class="form-label" for="add-folder">Album Name</label>
                <input v-model="folderName" class="form-control" id="add-folder" type="text" placeholder="Album name...">
              </div>
              <div class="mb-3">
                <label class="form-label" for="add-folder">Album Name</label>
                <textarea v-model="folderDesc" class="form-control" id="folder-desc" type="text" placeholder="Album Description..."> </textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-secondary" @click="createFolder" type="button">Save</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editFolder" tabindex="-1" role="dialog" aria-labelledby="addFolder" aria-hidden="true" style="position: fixed">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Album</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label class="form-label" for="add-folder">Album Name</label>
                <input v-model="editFolderName" class="form-control" id="edit-add-folder" type="text" placeholder="Album name...">
              </div>
              <div class="mb-3">
                <label class="form-label" for="add-folder">Album Name</label>
                <textarea v-model="editFolderDesc" class="form-control" id="edit-folder-desc" type="text" placeholder="Album Description..."> </textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-secondary" @click="saveEditedFolderInfo" type="button">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import LoadingMetric from '@/components/LoadingStyleMetric.vue';
import { Link } from "@inertiajs/vue3";
</script>
<script>
import { router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import axios from "axios";
import Swal from "sweetalert2";
import {Inertia} from "@inertiajs/inertia";
export default {
  props: ['folders', 'allFiles', 'folderFiles', 'deletedFiles'],
  data() {
    return {
      showLoader: false,
      folderName: '',
      folderDesc: '',
      editFolderName: '',
      editFolderDesc: '',
      folderId: ''
    }
  },
  methods: {
    checkExtension(key) {
      if (key.split('.').pop() != 'mp4') {
        return true
      }
    },
    async restore(key) {
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
    },
    editFolderAndDesc(folder) {
      console.log(folder)
      this.editFolderName = folder.folder_name
      this.editFolderDesc = folder.folder_desc
      this.folderId = folder.file_folder_id
      $('#editFolder').modal('show')
    },
    async saveEditedFolderInfo() {
      if (this.editFolderName.length == 0 || this.editFolderDesc.length == 0) {

        let errorMes = '';

        if (this.editFolderName.length == 0) {
          errorMes = 'Album is empty!'
        }

        if (this.editFolderDesc.length == 0) {
          errorMes = 'Album description is empty!'
        }

        if (this.editFolderName.length == 0 && this.editFolderDesc.length == 0) {
          errorMes = 'Album and Description are empty!'
        }
        Swal.fire({
          text: errorMes,
          icon: "warning",
          buttonsStyling: false,
          confirmButtonText: "Close",
          customClass: {
            confirmButton: "btn btn-danger"
          }
        })
      } else {
        try {
          this.showLoader = true
          await axios.post('/company/portfolio/save-folder-name', {'new-folder-name': this.editFolderName, 'folder-desc' : this.editFolderDesc, 'folder-id': this.folderId})
        }catch(error) {
          console.log(error)
        } finally {
          router.reload()
          this.showLoader = false
        }
      }
    },
    async createFolder() {
      if (this.folderName.length == 0) {
        toast.error('Folder name is empty!')
      } else {
        try {
          this.showLoader = true
          await axios.post('/company/portfolio/add-folder', {'folderName':this.folderName, 'addedFrom': 'portfolio', 'desc' : this.folderDesc}).then(response => {
            toast.success('New folder is added!')
            $('#addFolder').hide()
            $('.modal-backdrop').hide()
          })
        } catch(error) {
          console.log(error)
        } finally {
          router.reload()
          this.folderName = ''
          this.showLoader = false
        }
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

    // $('#addFolder').on('shown.bs.modal', function (e) {
    //   $('html, body.modal-open').css({
    //     overflow: 'hidden',
    //     height: '100%'
    //   });
    // })
    //
    // $('#addFolder').on('hidden.bs.modal', function (e) {
    //   $('html, body').css({
    //     overflow: 'auto',
    //     height: '100%'
    //   });
    // })

  }
}
</script>