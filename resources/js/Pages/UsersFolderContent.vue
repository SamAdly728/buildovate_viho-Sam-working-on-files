<style></style>
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
    dynamic content here
    <div class="container-fluid mt-2">
      <div class="row">
        <div class="col-xl-3 box-col-6 pe-0">
          <sideMenu/>
        </div>
        <div class="col-xl-9 col-md-12 box-col-12" >
          <div class="file-content" >
            <div class="card">
              <div class="card-header">
                <div class="">
                  <h5 class="text-muted d-inline">Designs</h5>
                  <span style="margin-top: .4rem" class="ml-2 text-success" v-if="selected_jobsite"><b>-</b> {{ jobsiteName }}</span>
                  <button class="btn btn-primary btn-sm float-end d-inline" data-bs-toggle="modal" data-bs-target="#uploadFile">Upload</button>
                  <button class="btn btn-danger btn-sm float-end mr-1 ml-1" @click="deleteFile">Delete</button>
                  <transition>
                    <label class="d-block float-end mr-2 mt-2" for="check-box" v-if="gridView">
                      <input class="checkbox_animated" id="check-box" type="checkbox" v-model="selectAll" @change="toggleSelectAll">
                      <span class="text-muted">Select All</span>
                    </label>
                  </transition>
                  <transition>
                    <div v-if="selectAll || selectedItems.selectedFileId.length > 0" class="dropdown mr-2 float-end">
                      <button id="action-button" @click="toggleAction" class="btn btn-secondary btn-sm">Action</button>
                      <div id="action-options" class="dropdown-content" style="z-index: 9999;">
                        <a class="text-muted" href="#">Share</a>
                        <a class="text-muted" href="#" @click="hideActionOptions" data-bs-toggle="modal" data-original-title="Move To" data-bs-target="#move-to">Move to</a>
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
              <div class="card-body file-manager overflow-x-hidden overflow-y-auto custom-scrollbar" style="max-height: 700px;" v-if="gridView">
                <ul class="files" >
                  <li class="file-box mr-3 mb-2" v-for="file in designsFile">
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
                    <tr v-for="file in designsFile" >
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
                          <a class="text-danger" href="#" @click="deleteSinglePhoto(file.user_file_upload_id)">Delete</a>
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
</template>
<script setup>
import LoadingMetric from '@/components/LoadingStyleMetric.vue';
import { selected_jobsite } from '../globalState';
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
  props: ['folderContent'],
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
        'upload-file-from' : 'design'
      },
      moveToFolder: ''
    }
  },
  mounted() {
    console.log(this.folderContent)
  }
}
</script>