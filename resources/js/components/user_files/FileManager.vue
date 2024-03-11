<style scoped>
.dropbtn {
  background-color: #3498db;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover,
.dropbtn:focus {
  background-color: #2980b9;
}

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
  animation: fadeIn 0.1s;
}

.dropdown-content a {
  color: black;
  padding: 8px 16px;
  text-decoration: none;
  display: block;
}
/*
.dropdown a:hover {
  background-color: #E6EDEF;
}*/

.show {
  display: block;
}

/*.hoverEffect:hover{
  background-color: #0f5132 !important;
}*/

.accordion {
  cursor: pointer;
  width: 100%;
  border: none;
  outline: none;
  /* //font-size: 15px; */
  transition: 0.4s;
}

.active,
.accordion:hover {
  background-color: #e6edef;
  content: "\002B";
  color: #6c757d;
  /* //padding: 10px;
  //border-radius: 5px; */
}

.accordion:after {
  content: "\002B";
  color: #6c757d;
  font-weight: bold;
  float: right !important;
}

.active:after {
  content: "\2212";
}

.panel {
  padding: 0 18px;
  background-color: #e6edef;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}

.table thead th {
  position: sticky;
  top: 0;
  background: white; /* To ensure header background remains opaque */
  z-index: 1;
}

/*.table-fixed-bottom {
!*  position: fixed;*!
  bottom: 20px;
  !*left: 0;
  right: 0; *!!* This ensures the table stretches across the full width of the screen *!
  overflow-x: auto; !* In case the table width exceeds the screen width *!
}*/
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
  <div class="col-xl-9 col-md-12 box-col-12">
    <div class="file-content">
      <div class="card">
        <div class="card-header">
          <div class="media justify-content-between">
            <div class="d-flex">
              <h5 class="text-muted">File Manager</h5>
              <span
                style="margin-top: 0.4rem"
                class="ml-2 txt-primary"
                v-if="selected_jobsite"
                ><b v-if="jobsiteName">-</b> {{ jobsiteName }}</span
              >
            </div>
            <div>
              <i
                class="icofont icofont-gear h4 txt-primary"
                style="cursor: pointer"
              ></i>
            </div>
          </div>
        </div>
        <div class="card-body file-manager">
          <div class="media d-inline">
            <div class="dropdown mr-2">
              <button
                id="upload-button"
                @click="uploadDropdown('upload-button', 'upload-options')"
                class="btn btn-primary"
              >
                Upload
              </button>
              <div id="upload-options" class="dropdown-content">
                <a
                  class="text-muted"
                  href="#"
                  data-bs-toggle="modal"
                  data-original-title="uploadModal"
                  data-bs-target="#file-upload"
                  @click="closeSlideCreate('upload-options')"
                  ><i class="icofont icofont-paper"></i> File</a
                >
              </div>
            </div>
            <div class="dropdown">
              <button
                id="create-button"
                @click="createButton('create-button', 'create-options')"
                class="upload-btn btn btn-primary"
              >
                + Create
              </button>
              <div id="create-options" class="dropdown-content">
                <a
                  class="text-muted"
                  href="#"
                  data-bs-toggle="modal"
                  data-original-title="uploadModal"
                  data-bs-target="#create-folder"
                  @click="closeSlideCreate('create-options')"
                  ><i class="icofont icofont-ui-folder"></i> Folder</a
                >
                <a class="text-muted" href="#"
                  ><i class="icofont icofont-folder-search"></i> Shared
                  Folder</a
                >
              </div>
            </div>
          </div>
          <div class="media float-end d-inline">
            <form class="form-inline" action="#" method="get">
              <div class="form-group d-flex mb-0">
                <i class="fa fa-search"></i>
                <input
                  class="form-control-plaintext"
                  type="text"
                  placeholder="Search..."
                />
              </div>
            </form>
          </div>
          <h5 class="mt-5 text-muted">Folders</h5>
          <ul class="folder">
            <li class="folder-box mr-2">
              <Link href="/files/user_files/design">
                <div class="media">
                  <i class="fa fa-folder f-36 txt-warning"></i>
                  <div class="media-body ms-3 mt-3">
                    <h6 class="mb-0 text-muted">Designs</h6>
                  </div>
                </div>
              </Link>
            </li>
            <li class="folder-box mr-2">
              <Link href="/files/user_files/contract">
                <div class="media">
                  <i class="fa fa-folder f-36 txt-warning"></i>
                  <div class="media-body ms-3 mt-3">
                    <h6 class="mb-0 text-muted">Contracts</h6>
                  </div>
                </div>
              </Link>
            </li>
            <li class="folder-box mr-2">
              <Link href="/files/user_files/checklist">
                <div class="media">
                  <i class="fa fa-folder f-36 txt-warning"></i>
                  <div class="media-body ms-3 mt-3">
                    <h6 class="mb-0 text-muted">Checklists</h6>
                  </div>
                </div>
              </Link>
            </li>
            <li class="folder-box">
              <Link href="/files/user_files/engineering">
                <div class="media">
                  <i class="fa fa-folder f-36 txt-warning"></i>
                  <div class="media-body ms-3 mt-3">
                    <h6 class="mb-0 text-muted">Engineering Plans</h6>
                  </div>
                </div>
              </Link>
            </li>
          </ul>
          <ul class="folder mt-2">
            <li class="folder-box mr-2">
              <Link href="/files/user_files/site">
                <div class="media">
                  <i class="fa fa-folder f-36 txt-warning"></i>
                  <div class="media-body ms-3 mt-3">
                    <h6 class="mb-0 text-muted">Site Plans</h6>
                  </div>
                </div>
              </Link>
            </li>
            <li class="folder-box mr-2">
              <Link href="/files/user_files/architectural">
                <div class="media">
                  <i class="fa fa-folder f-36 txt-warning"></i>
                  <div class="media-body ms-3 mt-3">
                    <h6 class="mb-0 text-muted">Architectural Drawings</h6>
                  </div>
                </div>
              </Link>
            </li>
            <li class="folder-box mr-2">
              <Link href="/files/user_files/permit">
                <div class="media">
                  <i class="fa fa-folder f-36 txt-warning"></i>
                  <div class="media-body ms-3 mt-3">
                    <h6 class="mb-0 text-muted">Permits</h6>
                  </div>
                </div>
              </Link>
            </li>
            <li class="folder-box">
              <Link href="/files/user_files/inspection">
                <div class="media">
                  <i class="fa fa-folder f-36 txt-warning"></i>
                  <div class="media-body ms-3 mt-3">
                    <h6 class="mb-0 text-muted">Inspections</h6>
                  </div>
                </div>
              </Link>
            </li>
          </ul>
          <ul class="folder mt-2">
            <li class="folder-box mr-2 mb-2">
              <Link href="/files/user_files/warranty">
                <div class="media">
                  <i class="fa fa-folder f-36 txt-warning"></i>
                  <div class="media-body ms-3 mt-3">
                    <h6 class="mb-0 text-muted">Warranties</h6>
                  </div>
                </div>
              </Link>
            </li>
            <li class="folder-box mr-2 mb-2">
              <Link href="/files/user_files/document">
                <div class="media">
                  <i class="fa fa-folder f-36 txt-warning"></i>
                  <div class="media-body ms-3 mt-3">
                    <h6 class="mb-0 text-muted">Documents</h6>
                  </div>
                </div>
              </Link>
            </li>
            <hr />
            <li class="folder-box mr-2 mb-2" v-for="folder in userFolder">
              <Link :href="'/files/folders/content/' + folder.file_folder_id">
                <div class="media">
                  <i class="fa fa-folder f-36 txt-warning"></i>
                  <div class="media-body ms-3 mt-3">
                    <h6 class="mb-0 text-muted">{{ folder.folder_name }}</h6>
                  </div>
                  <i
                    @click="deleteFolder"
                    class="fa fa-ellipsis-v p-2"
                    style="position: relative; z-index: 99999"
                  ></i>
                </div>
              </Link>
            </li>
          </ul>
          <h5 class="mt-5 text-muted">Recent Files</h5>
          <hr />
          <div
            class="table-responsive table-fixed-bottom"
            style="max-height: 500px; overflow-y: auto"
          >
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-muted">Name</th>
                  <th class="text-muted">Date Added</th>
                  <th class="text-muted">Size</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="file in userFile">
                  <td>
                    <!--                  <a :href="'/files/preview/user-upload/'+file.user_file_upload_id" target="_blank">-->
                    <!--                    <i class="icofont icofont-file-text text-primary mr-1" v-if="file.file_type == 'txt'"></i>-->
                    <!--                    <i class="icofont icofont-ui-image mr-1 text-info" v-if="file.file_type == 'png' || file.file_type == 'jpg' ||  file.file_type == 'avif' || file.file_type == 'jpeg' || file.file_type == 'webp' || file.file_type == 'JPG'"></i>-->
                    <!--                    <i class="icofont icofont-file-pdf mr-1 text-danger" v-if="file.file_type == 'pdf'"></i>-->
                    <!--                    <i class="icofont icofont-ui-video-play h6 mr-1" v-if="file.file_type == 'mp4'"></i>-->
                    <!--                    <span class="text-muted">{{file.file_name}}</span>-->
                    <!--                  </a>-->

                    <a href="#" @click="previewModal(file.s3Url)">
                      <i
                        class="icofont icofont-file-text text-primary mr-1"
                        v-if="file.file_type == 'txt'"
                      ></i>
                      <i
                        class="icofont icofont-ui-image mr-1 text-info"
                        v-if="
                          file.file_type == 'png' ||
                          file.file_type == 'jpg' ||
                          file.file_type == 'avif' ||
                          file.file_type == 'jpeg' ||
                          file.file_type == 'webp' ||
                          file.file_type == 'JPG'
                        "
                      ></i>
                      <i
                        class="icofont icofont-file-pdf mr-1 text-danger"
                        v-if="file.file_type == 'pdf'"
                      ></i>
                      <i
                        class="icofont icofont-ui-video-play h6 mr-1"
                        v-if="file.file_type == 'mp4'"
                      ></i>
                      <span class="text-muted">{{ file.file_name }}</span>
                    </a>
                  </td>
                  <td>
                    <span class="text-muted">{{
                      formatDateValue(file.created_at)
                    }}</span>
                  </td>
                  <td>
                    <span class="text-muted">{{
                      Math.trunc(
                        Math.round((file.file_size / 1024) * 100) / 100
                      ) + " KB"
                    }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for file upload -->
  <div
    class="modal fade"
    id="file-upload"
    tabindex="-1"
    role="dialog"
    aria-labelledby="fileUpload"
    aria-hidden="true"
    style="position: fixed"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-muted">Upload File</h5>
          <button
            class="btn-close"
            type="button"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <div class="card rounded">
                <div class="d-flex flex-column align-items-center">
                  <div
                    class="p-5 d-flex flex-column align-items-center"
                    style="width: 300px; cursor: pointer"
                  >
                    <div style="font-size: 4rem">
                      <i class="far fa-file-alt txt-primary"></i>
                    </div>
                    <span class="mt-3 text-muted"
                      >Drop files here to upload, or browse for files.</span
                    >
                    <label class="btn btn-primary mt-3" for="photoUpload">
                      Browse
                      <form action="" @submit.prevent="uploadFile">
                        <input
                          type="file"
                          multiple
                          hidden
                          id="photoUpload"
                          accept="image/*,video/*"
                          @input="uploadFile"
                        />
                      </form>
                    </label>
                  </div>
                </div>
                <div class="overflow-auto">
                  <!-- Upload Footer-->
                  <div v-if="countUpload > 0">
                    <hr class="mt-0 mb-0" />
                    <div class="p-3">
                      <span class="text-muted">{{ countUpload }} File</span>
                      <a href="#"
                        ><span
                          class="txt-danger float-end"
                          @click="deleteItemFromModal"
                          >Clear All</span
                        ></a
                      >
                    </div>
                  </div>
                  <div id="footer-display">
                    <div v-for="file in userFile">
                      <div v-if="wasUploadedJustNow(file.created_at)">
                        <hr class="mt-0 mb-0" />
                        <div class="p-3">
                          <div
                            class="row new-added"
                            :data-id="file.user_file_upload_id"
                          >
                            <div class="d-flex align-items-center">
                              <i
                                class="icofont icofont-check text-success mr-2 h4"
                              ></i>
                              <img
                                :src="file.s3Url"
                                alt="Uploaded Image"
                                class="img-thumbnail mr-3"
                                style="width: 50px; height: 50px"
                              />
                              <span
                                style="margin-right: 3rem"
                                class="text-muted"
                                >{{ truncateFileName(file.file_name) }}</span
                              >
                              <span
                                style="margin-right: 4rem"
                                class="text-muted"
                                ><small>{{
                                  Math.trunc(
                                    Math.round((file.file_size / 1024) * 100) /
                                      100
                                  ) + " KB"
                                }}</small></span
                              >
                              <button
                                type="button"
                                class="txt-danger"
                                style="position: absolute; right: 18px"
                                @click="
                                  deleteSinglePhoto(file.user_file_upload_id)
                                "
                              >
                                Remove
                              </button>
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
              <div class="mb-3">
                <label class="form-label" for="fileManagerUpload"
                  >Select Folder</label
                >
                <select
                  class="form-select digits"
                  id="fileManagerUpload"
                  v-model="destinationFolder"
                >
                  <option value="" selected>Please select a folder...</option>
                  <option value="design">Designs</option>
                  <option value="contract">Contracts</option>
                  <option value="checklist">Checklists</option>
                  <option value="engineering">Engineering Plans</option>
                  <option value="siteplan">Site Plans</option>
                  <option value="architectural">Architectural Drawings</option>
                  <option value="permit">Permits</option>
                  <option value="inspection">Inspections</option>
                  <option value="warranty">Warranties</option>
                  <option value="document">Documents</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-secondary"
            type="button"
            data-bs-dismiss="modal"
            @click="clearModalView"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Create Folder Modal -->
  <div
    class="modal fade"
    id="create-folder"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createFolder"
    aria-hidden="true"
    style="position: fixed"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-muted">Create Folder</h5>
          <button
            class="btn-close"
            type="button"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label class="form-label" for="create-folder-input"
                  >Folder Name</label
                >
                <input
                  class="form-control"
                  id="create-folder-input"
                  type="email"
                  placeholder="Folder name..."
                  v-model="newFolderName"
                />
              </div>
              <div class="mb-3">
                <label class="form-label" for="create-folder-input"
                  >Accepted File Type</label
                >
                <label class="d-block" for="file-type-image">
                  <input
                    class="checkbox_animated"
                    id="file-type-image"
                    value="image/*"
                    type="checkbox"
                    v-model="fileType"
                  />
                  <span class="text-muted">Image</span>
                </label>
                <label class="d-block" for="file-type-video">
                  <input
                    class="checkbox_animated"
                    id="file-type-video"
                    value="video/*"
                    type="checkbox"
                    v-model="fileType"
                  />
                  <span class="text-muted">Video</span>
                </label>
                <label class="d-block" for="file-type-text">
                  <input
                    class="checkbox_animated"
                    id="file-type-text"
                    value="text/plain"
                    type="checkbox"
                    v-model="fileType"
                  />
                  <span class="text-muted">Plain Text</span>
                </label>
                <label class="d-block" for="file-type-csv">
                  <input
                    class="checkbox_animated"
                    id="file-type-csv"
                    value=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                    type="checkbox"
                    v-model="fileType"
                  />
                  <span class="text-muted">CSV / Excel</span>
                </label>
                <label class="d-block" for="file-type-pdf">
                  <input
                    class="checkbox_animated"
                    id="file-type-pdf"
                    value=".pdf"
                    type="checkbox"
                    v-model="fileType"
                  />
                  <span class="text-muted">PDF</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">
            Close
          </button>
          <button
            class="btn btn-secondary"
            type="button"
            @click="saveNewFolder"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Preview modal -->

  <div
    class="modal fade rounded"
    id="preview-modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="previewModal"
    aria-hidden="true"
    style="position: fixed"
  >
    <div class="modal-dialog modal-xl" role="document">
      <div
        id="modal-content"
        class="modal-content"
        style="
          background-color: rgba(0, 0, 0, 0) !important;
          border-color: rgba(0, 0, 0, 0);
        "
      >
        <!--        <div class="modal-header">-->
        <!--          <h5 class="modal-title" id="previewModal">Modal title</h5>-->
        <button
          class="btn-close"
          type="button"
          data-bs-dismiss="modal"
          aria-label="Close"
          style="z-index: 99999; background-color: white !important"
        ></button>
        <!--        </div>-->
        <div class="modal-body">
          <img
            class="rounded img-fluid"
            :src="previewUrl"
            alt=""
            style="width: 100%; height: auto"
          />
          <!--        <div id="videoPlayer"></div>-->
        </div>
        <!--        <div class="modal-footer">-->
        <!--          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>-->
        <!--          <button class="btn btn-secondary" type="button">Save changes</button>-->
        <!--        </div>-->
      </div>
    </div>
  </div>
</template>

<script setup>
import LoadingMetric from "@/components/LoadingStyleMetric.vue";
import { ref, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";
import {useSideBar} from "../../stores/sidebar.js";

const store = useSideBar();

let selected_jobsite = ref(false)

let jobsiteName = null;
let jobsiteId = null;

watch(() => store.$state.selectedJobsites, (newValue, oldValue) => {
  selected_jobsite.value = newValue.length > 0;
  jobsiteId = newValue[0].jobsite_id;
  getUserjobData();
});

if (store.$state.selectedJobsites != null) {
  jobsiteName = ref(store.$state.selectedJobsites[0].jobsite_name);
  jobsiteId = store.$state.selectedJobsites[0].jobsite_id;
  getUserjobData();
}

const userFile = ref([]);

function getUserjobData() {
  axios.get("/files/jobs/" + jobsiteId).then((response) => {
    userFile.value = response.data;
  });
}
</script>

<script>
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import axios from "axios";
import { toast } from "vue3-toastify";
import { selected_jobsite } from "../../globalState";

export default {
  props: ["userFile", "userFolder"],
  data() {
    return {
      showLoader: false,
      countUpload: 0,
      newFolderName: "",
      previewUrl: "",
      destinationFolder: "",
      fileUpload: {
        file: "",
        "upload-file-from": "",
        // jobsite_id: selected_jobsite._value.jobsite_id
      },
      selectedItems: {
        selectedFileId: []
      },
      fileType: []
    };
  },
  methods: {
    deleteFolder() {
      alert("test");
    },
    clearModalView() {
      this.selectedItems.selectedFileId = [];
      router.reload();
      this.countUpload = 0;
      const parentElement = document.getElementById("footer-display");
      const children = parentElement.children;
      this.destinationFolder = "";

      for (let i = 0; i < children.length; i++) {
        children[i].remove();
      }
    },
    async uploadFile() {
      this.fileUpload.file = event.target.files[0];
      this.fileUpload["upload-file-from"] = this.destinationFolder;
      if (event.target.files[0].type.match("image.*") == null) {
        toast.error("File type is not allowed!");
      } else {
        if (this.destinationFolder.length == 0) {
          toast.error("Please select destination folder!");
        } else {
          try {
            this.showLoader = true;
            await axios
              .post("/files/save/user-upload", this.fileUpload, {
                headers: {
                  "Content-Type": "multipart/form-data"
                }
              })
              .then((response) => {
                this.selectedItems.selectedFileId.push(
                  response.data.user_file_upload_id
                );
                this.countUpload++;
                router.reload();
                toast.success("Successfully Added! ");
              });
          } catch (error) {
            console.log(error);
          } finally {
            router.reload();
            this.showLoader = false;
          }
        }
      }
    },
    async deleteSinglePhoto(id) {
      let thisInstance = this;
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
          thisInstance.showLoader = true;
          try {
            await axios
              .post("/files/delete/user-upload", { selectedFileId: id })
              .then((response) => {
                toast.error("Successfully Deleted!");
                router.reload();
              });
          } catch (error) {
            console.log(error);
          } finally {
            thisInstance.showLoader = false;
          }
        }
      });
    },
    truncateFileName: function (val) {
      if (val.length > 10) {
        return val.substring(0, 10 - 3) + "...";
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
      let thisInstance = this;
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
          thisInstance.showLoader = true;
          try {
            await axios
              .post("/files/delete/user-upload", thisInstance.selectedItems)
              .then((response) => {
                router.reload();
                thisInstance.countUpload = 0;
                toast.error("Successfully Deleted!");
              });
          } catch (error) {
            console.log(error);
          } finally {
            // thisInstance.selectAll = false
            thisInstance.countUpload = 0;
            thisInstance.showLoader = false;
            router.reload();
          }
        }
      });
    },
    async saveNewFolder() {
      if (this.newFolderName.length == 0) {
        toast.error("Folder name is empty!");
      } else {
        try {
          this.showLoader = true;
          await axios
            .post("/files/save_new_folder", {
              "new-folder-name": this.newFolderName,
              "allowed-file-type": this.fileType,
              "added-from": "files"
            })
            .then((response) => {
              toast.success("New folder is added!");
              $("#create-folder").modal("hide");
              $(".modal-backdrop").hide();
            });
        } catch (error) {
          console.log(error);
        } finally {
          router.reload();
          this.newFolderName = "";
          this.showLoader = false;
        }
      }
    },
    closeSlideCreate(optionId) {
      $("#" + optionId).slideUp();
    },
    previewModal(url) {
      this.previewUrl = url;
      /*$('#videoPlayer').remove()
      $('#modal-content').append('<div id="videoPlayer"></div>')
      //
      $("#videoPlayer").aksVideoPlayer({
        file: [
          {
            file: url,
            label: "1080p"
          },{
            file: url,
            label: "720p"
          },
          {
            file: url,
            label: "540p"
          },
          {
            file: url,
            label: "360p"
          },
          {
            file: url,
            label: "240p"
          }
        ],
        width: 940,
        height: 590,
        poster: "https://buildovate-development.s3.us-west-1.amazonaws.com/userfileupload/document/49/a9b7ba70783b617e9998dc4dd82eb3c5-penda.jpg",
        forward: true,
        contextMenu: [
          // {
          //   type: "urlCopy",
          //   label: "Copy Video Url",
          //   url: url
          // },
          // {
          //   type: "socialmedia",
          //   label: "Share on Social Media",
          //   socials: [
          //     {
          //       label: "Facebook",
          //       url: "",
          //       colorBg: "#0066ff",
          //       color: "white",
          //       icon:
          //           '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 20"><defs/><path d="M8.174 3.32H10V.14A23.66 23.66 0 007.34 0C4.709 0 2.906 1.656 2.906 4.7v2.8H0v3.555h2.905V20h3.56v-8.945h2.789L9.697 7.5H6.466V5.05c0-1.027.276-1.73 1.708-1.73z" fill-rule="evenodd"/></svg>'
          //     },
          //     {
          //       label: "Twitter",
          //       url: "",
          //       colorBg: "#0089ff",
          //       color: "white",
          //       icon:
          //           '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 16"><defs/><path d="M17.944 3.987c.013.175.013.35.013.526C17.957 9.85 13.833 16 6.294 16c-2.322 0-4.48-.662-6.294-1.813.33.038.647.05.99.05 1.916 0 3.68-.637 5.089-1.725-1.802-.037-3.313-1.2-3.833-2.8.254.038.508.063.774.063.368 0 .736-.05 1.079-.137-1.878-.376-3.287-2-3.287-3.963v-.05c.546.3 1.18.488 1.853.512A4.02 4.02 0 01.838 2.775c0-.75.203-1.438.558-2.038a11.71 11.71 0 008.452 4.225 4.493 4.493 0 01-.102-.924c0-2.226 1.828-4.038 4.1-4.038 1.18 0 2.245.487 2.994 1.275A8.145 8.145 0 0019.442.3a4.038 4.038 0 01-1.802 2.225A8.316 8.316 0 0020 1.9a8.74 8.74 0 01-2.056 2.087z" fill-rule="evenodd"/></svg>'
          //     }
          //   ]
          // },
          // {
          //   type: "iframe",
          //   label: "Copy Iframe Code",
          //   iframe: "&lt;iframe&gt;&lt;/iframe&gt;"
          // }
        ],
      });*/
      $("#preview-modal").modal("show");
    },
    uploadDropdown: function (id, option) {
      $("#" + option).slideToggle();
      $("#create-options").hide();
    },
    createButton: function (id, option) {
      $("#" + option).slideToggle();
      $("#upload-options").hide();
    },
    dropdownButton: function (buttonId, options) {
      // if (buttonId == 'upload-button') {
      //   $('#upload-options').slideDown().addClass('show')
      //   $('#create-options').slideUp().removeClass('show')
      // }
      // if (buttonId == 'create-button') {
      //   $('#upload-options').slideUp().removeClass('show')
      //   if (!$('.sub-nav').hasClass('active')) {
      //     $('#create-options').slideDown().addClass('show')
      //   } else {
      //     $('#create-options').slideUp().removeClass('show')
      //   }
      // }
      // $('#upload-button').focusout(function () {
      //   $('#upload-options').slideUp().removeClass('show')
      // })
      // $('#create-button').focusout(function () {
      //   // alert($('.accordion').hasClass('active'))
      //   if (!$('.sub-nav').hasClass('active')) {
      //     // alert('active')
      //     // $('#create-options').slideUp().removeClass('show')
      //     // $('#create-options').toggleClass('show')
      //   }
      // })
      // $('.accordion').click(function() {
      //   alert('kini')
      //   // $('#create-options').addClass('show').focus()
      // })
      //
      // window.onclick = (event) => {
      //   // console.log(event.target)
      //   // console.log(document.querySelector('.active'))
      //   let el = document.getElementsByClassName('dropdown-content')
      //
      //
      //   if (event.target !== el && !$('.sub-nav').hasClass('active')) {
      //       // $('#create-options').slideUp().removeClass('show')
      //     // alert('test')
      //   }
      //
      //   // console.log(el)
      // }
      // window.onclick = function(event) {
      //   if (!event.target.matches('#'+buttonId)) {
      //     let dropdowns = document.getElementsByClassName("dropdown-content");
      //     let i;
      //     for (i = 0; i < dropdowns.length; i++) {
      //       let openDropdown = dropdowns[i];
      //       if (openDropdown.classList.contains('show')) {
      //         openDropdown.classList.remove('show');
      //         $('.dropdown-content').slideUp()
      //       }
      //     }
      //   }
      // }
    },
    formatDateValue(date) {
      let newDate = new Date(date);
      const months = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec"
      ];
      const month = months[newDate.getMonth()];
      const day = newDate.getDate();
      const year = newDate.getFullYear();
      let hours = newDate.getHours();
      const minutes = newDate.getMinutes();
      const ampm = hours >= 12 ? "PM" : "AM";
      hours = hours % 12;
      hours = hours ? hours : 12;
      const minutesStr = minutes < 10 ? "0" + minutes : minutes;
      return `${month} ${day}, ${year}, ${hours}:${minutesStr} ${ampm}`;
    }
  },
  mounted() {
    console.log(this.userFolder);

    // $('#upload-button').focusout(function () {
    //   $('#upload-options').slideUp()
    // })
    //
    // $('#create-button').focusout(function () {
    //   if(!$('#sub-nav').hasClass('show')) {
    //     $('#create-options').slideUp()
    //   }
    // })
  }
};
</script>
