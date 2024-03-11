<template>
  <div>
    <!-- Use a conditional rendering to show/hide the modal -->
    <!-- <form @submit.prevent="submitForm"> -->
    <div
      v-if="showModal"
      class="modal fade show"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-modal="true"
      style="display: block"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Settings</h1>
            <button
              type="button"
              class="btn-close"
              @click="closeModal"
              aria-label="Close"
            ></button>
          </div>
          <!-- modal body  -->
          <div class="modal-body">
            <div class="card rounded">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-sm-1 mt-1">
                    <svg
                      style="width: 30px"
                      class="m-r-15"
                      viewBox="0 0 16 16"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M14.72 8.16c0-.497-.045-.975-.127-1.433H8v2.708h3.767a3.22 3.22 0 0 1-1.396 2.113v1.756h2.262c1.323-1.219 2.087-3.013 2.087-5.145Z"
                        fill="#4285F4"
                      ></path>
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M8 15c1.89 0 3.475-.627 4.633-1.696l-2.262-1.756c-.627.42-1.43.668-2.37.668-1.824 0-3.367-1.231-3.918-2.886H1.745v1.814A6.997 6.997 0 0 0 8 15Z"
                        fill="#34A853"
                      ></path>
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M4.083 9.33c-.14-.42-.22-.869-.22-1.33 0-.461.08-.91.22-1.33V4.856H1.745a6.997 6.997 0 0 0 0 6.288L4.083 9.33Z"
                        fill="#FBBC05"
                      ></path>
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M8 3.784c1.028 0 1.95.353 2.676 1.047l2.008-2.008C11.472 1.693 9.887 1 8 1a6.997 6.997 0 0 0-6.255 3.856L4.083 6.67C4.633 5.015 6.177 3.784 8 3.784Z"
                        fill="#EA4335"
                      ></path>
                    </svg>
                  </div>
                  <div class="col-sm-6 mt-2">
                    <span>Google Account</span>
                  </div>
                  <div class="col-sm-3 mt-2">
                    <span>Learn more</span>
                    <svg
                      style="width: 15px"
                      viewBox="0 0 12 12"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                      class="text-muted m-l-5"
                    >
                      <path
                        class=""
                        d="M11 7a.5.5 0 0 0-1 0h1ZM5 2a.5.5 0 0 0 0-1v1Zm5 5v2h1V7h-1Zm-1 3H3v1h6v-1ZM2 9V3H1v6h1Zm1-7h2V1H3v1ZM2 3a1 1 0 0 1 1-1V1a2 2 0 0 0-2 2h1Zm1 7a1 1 0 0 1-1-1H1a2 2 0 0 0 2 2v-1Zm7-1a1 1 0 0 1-1 1v1a2 2 0 0 0 2-2h-1Z"
                        fill="currentColor"
                      ></path>
                      <path
                        class=""
                        d="M4.146 7.146a.5.5 0 1 0 .708.708l-.708-.708ZM10.5 1.5h.5a.5.5 0 0 0-.5-.5v.5Zm-3-.5a.5.5 0 0 0 0 1V1ZM10 4.5a.5.5 0 0 0 1 0h-1ZM4.854 7.854l6-6-.708-.708-6 6 .708.708ZM10.5 1h-3v1h3V1Zm-.5.5v3h1v-3h-1Z"
                        fill="currentColor"
                      ></path>
                    </svg>
                  </div>
                  <div class="col mt-2">
                    <button class="btn btn-xs btn-primary-v2">
                      <a href="follow-up/google">Connect</a>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- modal body end -->
          <div class="modal-footer">
            <button type="button" class="btn btn-light" @click="closeModal">
              Close
            </button>
            <!-- <button type="submit" class="btn btn-primary-v2">Submit</button> -->
          </div>
        </div>
      </div>
    </div>
    <!-- </form> -->
    <!-- Overlay to cover the background when the modal is open -->
    <div v-if="showModal" class="modal-backdrop fade show"></div>
  </div>
</template>
<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import axios from "axios";

const props = defineProps(["showModal"]);
const emits = defineEmits(["close"]);

const closeModal = () => {
  emits("close");
};
</script>
<style scoped>
.error {
  border-color: red;
}

.error-message {
  color: red;
}
</style>
