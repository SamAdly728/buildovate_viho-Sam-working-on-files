<template>
  <div class="live-demo">

    <div class="dropzone p-0" @click="$refs.uploadInput.click()" data-bs-toggle="modal" data-bs-target="#cropModal" style="cursor: pointer;width:300px;height: 100px; ;">
      <input type="file" ref="uploadInput" @change="selectFile" accept="image/jpg, image/jpeg, image/png, image/gif" style="display:none" class="form-control" name="logo">
      <img v-if="result.dataURL && result.blobURL" :src="result.blobURL" class="preview_design" style="width:100%;height:100%;border-radius: 15px;"/>
      <div v-else class="dz-message needsclick" >
        <i class="ki-duotone ki-file-up text-primary fs-3x">
          <span class="path1"></span>
          <span class="path2"></span>
        </i>
        <div class="ms-4">
          <b class="fs-6 fw-bold text-gray-900 mb-1">Click to Upload Logo</b><br>
          <span class="fs-7 fw-semibold text-gray-400">258 X 90</span>
        </div>
      </div>
    </div>

    <!-- Select a picture for cropping -->
    <section class="section">
      <p>Click the button to select the picture first, and it will enter the cutting process.</p>

      <!-- Set a button that invokes selecting an image -->
      <button class="select-picture" data-bs-toggle="modal" data-bs-target="#cropModal">
        <span>Select Picture</span>
        <input
          ref="uploadInput2"
          type="file"
          accept="image/jpg, image/jpeg, image/png, image/gif"
          @change="selectFile"
        />
      </button>
    </section>

    <!-- Crop result preview -->
    <section class="section" v-if="result.dataURL && result.blobURL">
      <p>A preview of the cropped Base64 image</p>
      <div class="preview">
        <img :src="result.dataURL" />
      </div>
      <p>A preview of the cropped blob image:</p>
      <div class="preview">
        <img :src="result.blobURL" />
      </div>
      <p>Press F12 to see the printed base64 / blob / file results.</p>
    </section>

    
    <div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="">Crop Image</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                    <!-- The component imported from `vue-picture-cropper` plugin -->
                    <VuePictureCropper
                      :boxStyle="{
                        width: '100%',
                        height: '100%',
                        backgroundColor: '#f8f8f8',
                        margin: 'auto',
                      }"
                      :img="pic"
                      :options="{
                        viewMode: 1,
                        dragMode: 'move',
                        aspectRatio: 16 / 9,
                        cropBoxResizable: false,
                      }"
                      :presetMode="{
                        mode: 'fixedSize',
                        width: 300,
                        height: 100,
                      }"
                    />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
              <button class="btn btn-secondary" @click="getResult" data-bs-dismiss="modal">Crop</button>
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
  components: {
    VuePictureCropper,
  },
  setup() {
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

      console.log({ base64, blob, file })
      result.dataURL = base64
      result.blobURL = URL.createObjectURL(blob)
      // preview_logo = result.blobURL
      isShowModal.value = false
    }

    

    return {

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