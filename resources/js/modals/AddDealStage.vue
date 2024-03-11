<template>
  <div>
    <!-- Use a conditional rendering to show/hide the modal -->
    <form @submit.prevent="submitForm">
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
              <h1 class="modal-title fs-5" id="exampleModalLabel">Add Deal Stage</h1>
              <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
            </div>
            <!-- modal body  -->
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Deal Stage Name</label>
                <input type="text" class="form-control" v-model="formData.deal_stage" />
                <small v-if="v$.deal_stage.$invalid && v$.deal_stage.$dirty" class="error-message"
                  >this field is required</small
                >
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" class="form-control" v-model="formData.description" />
                <small v-if="v$.description.$invalid && v$.description.$dirty" class="error-message"
                  >this field is required</small
                >
              </div>
            </div>
            <!-- modal body end -->
            <div class="modal-footer">
              <button type="button" class="btn btn-light" @click="closeModal">Close</button>
              <button type="submit" class="btn btn-primary-v2">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </form>
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
const emits = defineEmits(["close", "success"]);

const closeModal = () => {
  emits("close");
};

const formData = ref({
  deal_stage: "",
  description: "",
});

const rules = {
  deal_stage: { required },
  description: { required },
};

const v$ = useVuelidate(rules, formData);

const headers = {
  "Content-Type": "multipart/form-data",
  //   Authorization: "Bearer YourAccessToken",
};

async function submitForm() {
  v$.value.$touch(); // This will trigger validation on all fields

  // Check if the form is valid
  if (v$.value.$pending || v$.value.$error) {
    console.log("Form validation failed");
    return;
  }

  const form = new FormData();

  // Iterate over the form data object and append each field to the FormData
  for (const field in formData.value) {
    form.append(field, formData.value[field]);
  }

  try {
    const response = await axios.post("/company/follow-up/deal-stages/store", form, { headers });
    console.log("Response:", response.data);
    closeModal();
    emits("success", true);
    // Handle success (e.g., show a success message)
  } catch (error) {
    console.error("Error submitting form:", error);
    // Handle error (e.g., show an error message)
  }
}
</script>
<style scoped>
.error {
  border-color: red;
}

.error-message {
  color: red;
}
</style>
