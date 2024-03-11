<template>
  <div  v-if="showPopup" class="popup" :style="popupStyle">

    <div class="card p-0 m-0">
      <div class="card-header m-0 p-2">
        <div style="padding: 10px;">
          <button class="close-btn" @click="emitClosePopup">&times;</button>
          <h6 class="text-center">Labels</h6>
        </div>
        <div class="mb-0">
          <input type="text" class="form-control" placeholder="Search labels..." v-model="searchQuery">
        </div>
      </div>
      <div class="card-body m-0 p-2">
        <div v-for="label in filteredLabels" :key="label.id" class="d-flex align-items-center mb-2">
          <input 
          class="form-check-input me-2" 
          type="checkbox" 
          :id="'label-' + label.id" 
          :checked="isChecked(label)"
          @change="handleSelect(label)" >
          <label class="form-check-label flex-grow-1" :for="'label-' + label.id" :style="{backgroundColor: label.color}">
            {{ label.title }}
          </label>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
  import axios from 'axios';
  export default {
    props: ['showPopup', 'position','selectedLabel'],
    data() {
      return {
        searchQuery: '',
        labels: [],
        selected: []
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
    mounted(){
     this.getAllLabels();
   },  
   computed: {
    filteredLabels() {
      return this.labels.filter(label => 
        label.title.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    }
  },
    methods: { 
        handleSelect(label) {
            this.$emit('save-form', label);
        },
        isChecked(label) {
          return this.selected.some(selectedLabel => selectedLabel.id === label.id);
        },
        emitClosePopup() {
            this.$emit('close-popup');
        },
        getAllLabels() {
          axios.post(`/api/todo/getLabels`)
          .then((res) => {
              if(res.data){
                this.labels = res.data.data;
              }
          })
          .catch((error) => {
                  console.log(error.message);
          });
        }
    }
  };
  </script>
  
  <style scoped>
    .popup {
        border: 1px solid #ccc;
        padding: 10px;
        background-color: white;
        width: 300px;
        z-index: 100;
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
    .form-check-label {
      display: block;
      padding: 0.375rem 0.75rem;
      margin-bottom: 0.375rem;
      border-radius: 0.25rem;
      color: black;
      cursor: pointer;
      flex-grow: 1; 
    }
    .form-check-input {
      margin-top: 0;
      margin-bottom: 0;
      margin-right: 0.5rem; /* Space between the checkbox and the label text */
    }
  </style>
  