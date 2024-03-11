<template>
    <div v-if="showPopup" class="popup" :style="popupStyle">
        <button class="close-btn" @click="emitClosePopup">&times;</button>
        <p class="text-center">Members</p>
      <input type="text" v-model="searchTerm" @input="searchMembers" placeholder="Search members...">
      <div class="card">
        <div class="card-title">Users | Installes | All</div>
        <ul v-if="members.length">
          <li v-for="member in members" :key="member.id" @click="selectMember(member)"  class="member-item">{{ member.display_name }}</li>
        </ul>
      </div>

    </div>
</template>
  
  <script>
  import axios from 'axios';
  export default {
    props: ['showPopup', 'position'],
    data() {
      return {
        searchTerm: '',
        members: []
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
     this.getAllMember();
   },
    methods: {
      async searchMembers() {
        axios.post(`/api/todo/search-members`, { 
            query: this.searchTerm,
            type: "search"
        })
        .then((res) => {
            if(res.data){
                this.members = res.data.data;
            }
        })
        .catch((error) => {
                console.log(error.message);
        });
      },    
        selectMember(member) {
            this.$emit('member-selected', member);
        },    
        emitClosePopup() {
            this.$emit('close-popup');
        },
        getAllMember() {
          axios.post(`/api/todo/search-members`, { 
            query: "",
            type: "all"
          })
          .then((res) => {
              if(res.data){
                  this.members = res.data.data;
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
        width: 200px;
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
  </style>
  