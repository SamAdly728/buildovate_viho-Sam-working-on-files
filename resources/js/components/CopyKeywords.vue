<template>
  <h6 class="form-label f-w-600">
    Keywords <small class="text-muted">(click to copy)</small>
  </h6>
  <div
    class="d-flex flex-row flex-wrap gap-2 p-2 rounded"
    style="background-color: rgb(198, 238, 246)"
  >
    <button
      type="button"
      class="chips"
      v-for="item in data"
      @click="copyToClipboard(item.value)"
    >
      <small>{{ item.keyword }}</small>
    </button>
  </div>

  <!-- Bootstrap Alert -->
  <div
    v-if="showAlert"
    class="alert alert-success alert-dismissible fade show fixed-top mt-3 keyword-alert"
    role="alert"
  >
    <strong><i class="fa-solid fa-check me-2"></i> Copied!</strong> to
    clipboard.
    <button
      type="button"
      class="btn-close"
      @click="closeAlert"
      aria-label="Close"
    ></button>
  </div>
</template>
<script setup>
import { ref } from "vue";
const data = [
  {
    keyword: "lead_title",
    value: "{lead_title}",
  },
  {
    keyword: "lead_description",
    value: "{lead_description}",
  },
  {
    keyword: "appointment_by",
    value: "{appointment_by}",
  },
  {
    keyword: "appointment_date",
    value: "{appointment_date}",
  },
  {
    keyword: "first_name",
    value: "{first_name}",
  },
  {
    keyword: "last_name",
    value: "{last_name}",
  },
  {
    keyword: "lead_source",
    value: "{lead_source}",
  },
  {
    keyword: "email_address",
    value: "{email_address}",
  },
  {
    keyword: "mobile_phone",
    value: "{mobile_phone}",
  },
  {
    keyword: "address",
    value: "{address}",
  },
];

const showAlert = ref(false);

const copyToClipboard = (value) => {
  const textarea = document.createElement("textarea");
  textarea.value = value;
  document.body.appendChild(textarea);
  textarea.select();
  document.execCommand("copy");
  document.body.removeChild(textarea);

  // Show the alert
  showAlert.value = true;

  // Hide the alert after a delay (e.g., 3 seconds)
  setTimeout(() => {
    showAlert.value = false;
  }, 1000);
};

const closeAlert = () => {
  showAlert.value = false;
};
</script>
<style scoped>
.keyword-alert {
  width: 50%;
  transform: translate(-50%, 0);
  position: fixed;
  top: 0;
  left: 50%;

  background-color: #0d6efd;
  color: white;
}

.chips {
  padding: 0;
  margin: 0;
  border: none;
  background-color: transparent;
  border-bottom: 1px solid rgb(93, 92, 92);
  display: inline-block;
}

.chips:hover {
  color: #0d6efd;
  border-bottom: 1px solid #0d6efd;
}
</style>
