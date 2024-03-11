<style scoped>
.dropzone{
  min-height: 0px !important;
  border:none !important;
}
</style>
<template>
    <div class="live-demo">
  
      <div class="dropzone p-0" data-bs-toggle="modal" data-bs-target="#cropModal" :style="'cursor: pointer;width:'+options.width+'px;height: '+options.height+'px;'">
        <!-- <input type="file" ref="uploadInput" @change="selectFile" accept="image/jpg, image/jpeg, image/png, image/gif" style="display:none" class="form-control" name="logo"> -->
        <img v-if="(result.dataURL && result.blobURL) || options.defaultImage" :src="(result.blobURL) ? result.blobURL : options.defaultImage" class="preview_design"  :style="'width:'+options.width+'px;height: '+options.height+'px;'"/>
        <div v-else class="dz-message needsclick" >
          <i class="ki-duotone ki-file-up text-primary fs-3x">
            <span class="path1"></span>
            <span class="path2"></span>
          </i>
          <div class="ms-4">
            <b class="fs-6 fw-bold text-gray-900 mb-1">Click to Upload Logo</b><br>
            <span class="fs-7 fw-semibold text-gray-400">{{ options.width }} X {{ options.height }}</span>
          </div>
        </div>
      </div>
      
      <div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="">Company Logo</h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12 p-20">
                    <center>
                      <!-- The component imported from `vue-picture-cropper` plugin -->
                      <img v-if="pic==''" :src="options.defaultImage" :style="'width:'+options.width+'px;height:'+options.height+'px;'">
                      <VuePictureCropper v-if="pic!=''"
                        :boxStyle="{
                          width: options.width,
                          height: options.height,
                          backgroundColor: '#f8f8f8',
                          margin: 'auto',
                        }"
                        :img="pic"
                        :options="{
                          viewMode: 1,
                          dragMode: 'crop',
                          aspectRatio: 16 / 9,
                          cropBoxResizable: false,
                        }"
                        :presetMode="{
                          mode: 'fixedSize',
                          width: options.width,
                          height: options.height,
                        }"
                      />
                    </center>
                    <input type="file" ref="uploadInput" @change="selectFile" accept="image/jpg, image/jpeg, image/png, image/gif" style="display:none" class="form-control" name="logo">
                  </div>
                </div>
              </div>
              <div class="modal-footer2 text-left p-15">
                <hr>
                <button class="btn btn-secondary" @click="$refs.uploadInput.click()" >Upload Image</button>
                <span class="pull-right">
                  <button class="btn btn-default" data-bs-dismiss="modal">Close</button>
                  <button class="btn btn-primary" @click="getResult" data-bs-dismiss="modal">Save</button>
                </span>
              </div>
          </div>
        </div>
      </div>
  
    </div>
  
        
  </template>
  
  <script lang="ts">
  import { defineComponent, reactive, ref } from 'vue'
  import VuePictureCropper, { cropper } from 'vue-picture-cropper'
  
  export default defineComponent({
    props: ['options'],
    emits: ["croppedImage"],
    components: {
      VuePictureCropper,
    },
    setup(props) {
      const isShowModal = ref<boolean>(false)
      const uploadInput = ref<HTMLInputElement | null>(null)
      const pic = ref<string>('')
      const result = reactive({
        dataURL: '',
        blobURL: '',
      })
  
      /**
       * Select the picture to be cropped
       */
      function selectFile(e: Event) {
        // Reset last selection and results
        pic.value = ''
        result.dataURL = ''
        result.blobURL = ''
  
        // Get selected files
        const { files } = e.target as HTMLInputElement
        if (!files || !files.length) return
  
        // Convert to dataURL and pass to the cropper component
        const file = files[0]
        const reader = new FileReader()
        reader.readAsDataURL(file)
        reader.onload = () => {
          // Update the picture source of the `img` prop
          pic.value = String(reader.result)
  
          // Show the modal
          isShowModal.value = true
  
          // Clear selected files of input element
          if (!uploadInput.value) return
          uploadInput.value.value = ''
        }
      }
  
      /**
       * Get cropping results
       */
      async function getResult() {
        if (!cropper) return
        const base64 = cropper.getDataURL()
        const blob: Blob | null = await cropper.getBlob()
        if (!blob) return
  
        const file = await cropper!.getFile({
          fileName: 'Test file name, optional',
        })
  
        // console.log({ base64, blob, file })
        result.dataURL = base64
        result.blobURL = URL.createObjectURL(blob)
        this.$emit("croppedImage", file);//result.blobURL);
        // preview_logo = result.blobURL
        isShowModal.value = false
      }
  
      
  
      return {
        options: props.options,
        croppedImage:'',
        // Data
        uploadInput,
        pic,
        result,
        isShowModal,
  
        // Methods
        selectFile,
        getResult,
      }
    },
  })
  </script>