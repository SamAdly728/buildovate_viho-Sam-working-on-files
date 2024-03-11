<template>

<div v-if="showPopup" class="popup" :style="popupStyle">
    <div class="card">
      <div class="card-header m-0 p-2">
        <div style="padding: 10px;">
          <button class="close-btn" @click="emitClosePopup">&times;</button>
          <h6 class="text-center">Attach</h6>
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body p-3">
          <div class="row px-2 px-2">
              <div class="col-md-12 mb-3">
                  <label for="custom-file-upload" class="w-100" id="file-upload-label" style="display: inline">
                    <div class="card mb-0 rounded" id="custom-dropzone">
                        <div class="card-body p-0" style="text-align: center;">
                            <label for="custom-file-upload" class="col-md-12 text-muted mb-3">Attach a file from your computer</label>
                            <input type="file" id="custom-file-upload" @change="fileChanged" hidden>
                            <label for="custom-file-upload">
                                <img id="upload-image" :src="uploadIcon" alt="" style="cursor: pointer; display: block; margin: auto;">
                            </label>
                            <label v-if="filename" for="custom-file-upload">
                                Filename : {{ filename }}
                            </label>
                        </div>
                    </div>
                  </label>
                  <div id="image-container">
                  </div>
              </div>
          </div>
      </div>
      <!-- Card Footer -->
      <div class="card-footer p-0" style="display: flex; justify-content: center; gap: 10px;">
          <button class="btn btn-primary" @click="uploadFile">Insert</button>
          <button class="btn btn-secondary" @click="emitClosePopup">Cancel</button>
      </div>
    </div>
  </div>
</template>
  
  <script>
  import axios from 'axios';
  export default {
    props: ['showPopup', 'position'],
    data() {
      return {
        file: '',
        uploadIcon: window.location.origin + '/assets/images/upload-100.png',
        filename: '',
      };
    },
    computed: {
      popupStyle() {
        return {
          position: 'absolute',
          top: this.position.top + 'px',
          left: this.position.left + 'px'
        };
      }
    },
    methods: {    
      fileChanged(event) {
        if (event.target.files.length > 0) {
          const file = event.target.files[0];
          this.file = file;
          this.filename = this.file.name

          // const formData = new FormData();
          // formData.append("file", file);
          // formData.append("todo_id", 8);

          // // Adjust the URL and headers as necessary
          // axios.post('/api/todo/upload', formData, {
          // headers: {
          //   'Content-Type': 'multipart/form-data',
          // }
          // })
          // .then(response => {
          //   console.log(response.data);
          //   alert("File uploaded successfully.");
          // })
          // .catch(error => {
          //   console.error("There was an error uploading the file:", error.response);
          // });
        }
      },
      uploadFile() {
        if (!this.file) {
          alert("Please select a file.");
          return;
        }
        this.$emit('save-form', this.file);
      },
      emitClosePopup() {
        this.$emit('close-popup');
      }
    }
  };
  </script>
  
  <style scoped>
    .popup {
        background: white;
        background-color: white;
        border: 1px solid #727070;
        padding: 0px;
        z-index: 100;  
        border-radius: 5px;
        width: 330px;
    }
    .member-item {
        cursor: pointer;
    }
    .close-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        border: none;
        background: transparent;
        font-size: 20px;
        cursor: pointer;
    }
  </style>
  