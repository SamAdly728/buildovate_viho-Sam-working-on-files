<template>
  <div>
    <label :for="checkboxId" class="custom-checkbox-label">
      <input type="checkbox" :id="checkboxId" v-model="isChecked" :checked="isChecked" @change="toggleCheckbox">
      <span class="custom-checkbox" :style="{borderColor: checkboxColor }">
        <i class="fas fa-check" v-if="isChecked"></i>
      </span>
    </label>
  </div>
</template>

<script>
export default {
  props: {
    checkboxId: {
      type: String,
      required: true
    },
    initialColor: {
      type: String,
      default: '#000' // Default color
    }
  },
  data() {
    return {
      isChecked: true,
      checkboxColor: this.initialColor
    };
  },
  methods: {
    toggleCheckbox() {
      this.$emit('change', this.isChecked);
    }
  }
};
</script>

<style scoped>
.custom-checkbox-label {
  position: relative;
  padding-left: 30px; /* space for the custom checkbox */
  cursor: pointer;
}

.custom-checkbox-label input[type="checkbox"] {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
  z-index: 1;
}

.custom-checkbox {
  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: transparent;
  border-radius: 4px;
  border: 2px solid #1e5bb2;
  transition: background-color 0.2s;
}

.custom-checkbox:before {
  content: '';
  position: absolute;
  display: none;
  left: 6px;
  top: 2px;
  width: 6px;
  height: 10px;
  border: solid #1e5bb2;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

.custom-checkbox.checked:before {
  display: block;
}

.custom-checkbox i {
  top: 50%;
  left: 50%;
  transform: translate(10%, -25%);
  font-size: 0.8rem;
}
</style>
