<!-- AutomationModal.vue -->
<style scoped>
.modal-dialog {
  min-width: 50%;
  min-height: 80dvh;
}

.first-sentence {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
}

.automate-select {
  border: none;
  text-decoration: underline;
  text-decoration-skip-ink: none;
  text-underline-offset: 0.3em;
  background-color: white;
}

.automate-select ul {
  padding: 20px;
}

.automate-select li {
  margin-top: 10px;
  margin-bottom: 10px;
  cursor: pointer;
}
</style>

<template>
  <div>
    <!-- Use a conditional rendering to show/hide the modal -->
    <div
      v-if="openModal"
      class="modal fade show"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-modal="true"
      style="display: block"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Automation</h1>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- first sentence  -->
            <div class="d-flex flex-row gap-2 align-items-center">
              <i class="fa-regular fa-circle-dot"></i>
              <span>When</span>
              <div class="dropdown">
                <button class="automate-select" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  {{ firstSentence.firstSelect ? firstSentence.firstSelect : "this happens" }}
                </button>
                <ul class="dropdown-menu">
                  <li
                    v-for="(item, index) in firstSentence"
                    :key="index"
                    :value="item.label"
                    :on-click="setFirstSelect(item.label)"
                  >
                    <i :class="item.icon"></i> {{ item.label }}
                  </li>
                </ul>
              </div>
            </div>

            <div class="first-sentence">
              <select
                class=""
                aria-label="Default select example"
                v-model="firstSentence.firstSelect"
                @change="setFirstSentenceSecondSelect"
              >
                <option value="" disabled>Select an option</option>
                <option v-for="(item, index) in firstSentence" :key="index" :value="item.label">
                  {{ item.label }}
                </option>
              </select>

              <!-- {{ firstSentence }} -->

              <select
                class=""
                aria-label="Default select example"
                v-model="firstSentence.secondSelect"
                @change="setFirstSentenceThirdSelect($event)"
                v-if="firstSentenceSecondSelectOptions.length"
              >
                <option value="" disabled>Select an option</option>
                <option v-for="(item, index) in firstSentenceSecondSelectOptions" :key="index" :value="item.label">
                  {{ item.label }}
                </option>
              </select>

              <select
                class=""
                aria-label="Default select example"
                v-model="firstSentence.thirdSelect"
                v-if="firstSentenceThirdSelectOptions.length"
              >
                <option value="" disabled>Select an option</option>
                <option v-for="(item, index) in firstSentenceThirdSelectOptions" :key="index" :value="item">
                  {{ item }}
                </option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" @click="closeModal">Close</button>
            <button type="button" class="btn btn-primary-v2">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Overlay to cover the background when the modal is open -->
    <div v-if="openModal" class="modal-backdrop fade show"></div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      firstSentenceSecondSelectOptions: [],

      firstSentenceThirdSelectOptions: [],

      firstSentence: {
        firstSelect: "",
        secondSelect: "",
        thirdSelect: "",
      },

      secondSentence: {
        firstSelect: "",
        secondSelect: "",
        thirdSelect: "",
      },

      firstSentence: [
        {
          label: "a lead",
          icon: "fa-solid fa-user",
          options: [
            {
              label: "is created",
              options: [],
            },
            {
              label: "has a status",
              options: ["scheduled", "in progress", "estimated", "approved"],
            },
            {
              label: "is scheduled",
              options: [],
            },
          ],
        },
        {
          label: "a job",
          icon: "fa-solid fa-user",
          options: [
            {
              label: "is created",
              options: [],
            },
            {
              label: "has a status",
              options: ["submitted", "in progress", "canceled", "done", "pending", "done pending approval"],
            },
          ],
        },
        {
          label: "an estimate",
          icon: "fa-solid fa-user",
          options: [
            {
              label: "is created",
              options: [],
            },
            {
              label: "is sent",
              options: [],
            },
            {
              label: "is approved",
              options: [],
            },
            {
              label: "is declined",
              options: [],
            },
            {
              label: "is won",
              options: [],
            },
          ],
        },
        {
          label: "an invoice",
          icon: "fa-solid fa-user",
          options: [
            { label: "is created", options: [] },
            { label: "is sent", options: [] },
            { label: "is due", options: [] },
            { label: "is part due", options: [] },
            { label: "is paid in full", options: [] },
          ],
        },
        {
          label: "a call",
          icon: "fa-solid fa-user",
          options: [
            { label: "is completed", options: [] },
            { label: "is missed", options: [] },
            { label: "goes to voicemail", options: [] },
          ],
        },
      ],
    };
  },
  props: {
    openModal: {
      type: Boolean,
      required: true,
    },
  },

  methods: {
    closeModal() {
      this.$emit("closeModal");
    },

    setFirstSelect(selected) {
      this.firstSentence.firstSelect = selected;
    },

    setFirstSentenceSecondSelect() {
      const selectedOption = this.firstSentence.find((item) => item.label === this.firstSentence.firstSelect);

      this.firstSentenceSecondSelectOptions = selectedOption.options;
    },

    setFirstSentenceThirdSelect(event) {
      const thirdSelectOptions = this.firstSentenceSecondSelectOptions.find(
        (item) => item.label === this.firstSentence.secondSelect
      );

      this.firstSentenceThirdSelectOptions = thirdSelectOptions.options;
      console.log(this.firstSentenceThirdSelectOptions, "bar");
    },
  },
  mounted() {},
};
</script>

<style scoped>
/* Add any additional styles you need */
.select-automation {
  transition: width 0.3s ease; /* Add a transition for a smooth effect */
}
</style>
