<style></style>
<template>
  <div class="file-content">
    <div class="card">
      <div class="card-header">
        <div class="">
          <h5 class="text-muted d-inline">Designs</h5>
          <button class="btn btn-primary btn-sm float-end d-inline" data-bs-toggle="modal" data-bs-target="#uploadFile">Upload</button>
          <button class="btn btn-primary btn-sm float-end mr-1" @click="deleteFile">Delete</button>
          <label class="d-block float-end mr-2 mt-2" for="check-box">
            <input class="checkbox_animated" id="check-box" type="checkbox" v-model="selectAll" @change="toggleSelectAll">
            <span class="text-muted">Select All</span>
          </label>
        </div>
      </div>
      <div class="card-body file-manager">
        <ul class="files" >
          <li class="file-box mr-3 mb-2" v-for="file in designsFile">
            <label class="d-block float-end" :for="'check-box'+file.user_file_upload_id">
              <input class="checkbox_animated single-file-checkbox" :value="file.user_file_upload_id" :id="'check-box'+file.user_file_upload_id" type="checkbox" v-model="selectedItems.selectedFileId" @change="checkSelectAllStatus">
            </label>
            <img style="width: 100%; height: 200px" :src="file.s3Url" alt="">
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
export default {

}
</script>