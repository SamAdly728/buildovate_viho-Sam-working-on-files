
<style scoped>
.popup {
  background: white;
  padding: 0px;
  border-radius: 5px;
  width: 330px;
}
</style>
<template>
  <div v-if="showPopup" class="popup" :style="popupStyle">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h6 class="card-title">Move Cards</h6>
        <!-- Close Button -->
        <button type="button" class="close" @click="emitClosePopup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Card Body -->
      <div class="card-body p-3">
        
        <div class="form">
          <!-- Start date -->
          <div class="form-group">
            <label for="entity">Select Destination</label>
            <select class="form-control" name="entity" id="entity" v-model = card.entityType>
              <option value="non-work">Non-Work</option>
              <option value="projects">Projects</option>
              <option value="leads">Leads</option>
            </select>
          </div>
          <div class="form-group">
            <label for="position">Positions</label>
            <select class="form-control"  name="position" id="position">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>
        </div>

      </div>
      <!-- Card Footer -->
      <div class="card-footer p-0" style="display: flex; justify-content: center; gap: 10px;">
          <button class="btn btn-primary  w-100 mb-3"  @click="saveForm">Move</button>
          <button class="btn btn-secondary  w-100 mb-3"  @click="emitClosePopup">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['showPopup', 'position','card'],
  // data(props) {
  //   return {
  //     card:props.card,
  //     date: new Date(),
  //   };
  // },
  computed: {
    popupStyle() {
      return {
        position: 'absolute',
        top: this.position.top + 'px',
        left: this.position.left + 'px'
      }
    },
  },
  methods: {
    emitClosePopup() {
        this.$emit('close-popup');
    },
    saveForm() {
      let formData = {
        entityType: this.card.entityType,
        sequence: this.card.sequence,
      };
      this.$emit('save-form', formData);
    },
    
  },  
};
</script>

