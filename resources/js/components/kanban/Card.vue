<style scoped>
.kanban-item .list{
   opacity: 1 !important;
}
.kanban-box:hover{
   border: 2px solid #1e5bb2;
}
.kanban-box{
   color: #000000 !important;
}
</style>
<template>
   <div class="kanban-item" v-if="card">
      <!-- <a @click="getCard" class="kanban-box" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#cardModal"> -->
      <div class="kanban-box">
         
         <div class="d-flex mb-3">
            <h6>{{ card.title }}</h6>
            <span class="badge bg-primary text-light" style="margin-bottom:10px">
               <i class="fa fa-clock-o mx-1"></i>{{ card.deadline }}
            </span>
         </div>
         <div class="media">
            <img class="rounded-circle" :src="(card.thumbnail!='') ? '/uploads/thumbs/'+card.thumbnail : '' " alt="" data-original-title="" title="">
            <div class="media-body">
               <p>{{ card.description }}</p>
            </div>
         </div>
         <div class="d-flex mt-3">
            <ul class="list">
               <!-- <li v-if="card.deadline!=''">
                  <span class="badge bg-warning text-dark">
                     <i class="fa fa-clock"></i>{{ card.deadline }}
                  </span>
               </li> -->
               <!-- <li v-if="card.has_comments>0"><i class="fa fa-comments-o"></i>{{ card.has_comments }}</li> -->
               <li v-if="card.has_description>0"><i class="fa fa-indent"></i>{{ card.has_description }}</li>
               <li v-if="card.has_attachments>0"><i class="fa fa-paperclip"></i>{{ card.has_attachments }}</li>
               <!-- <li><i class="fa fa-eye"></i></li> -->
            </ul>
            <div class="customers">
               <ul>
                  <li class="d-inline-block"><img class="img-20 rounded-circle" :src="'/assets/images/user/3.jpg'" alt="" data-original-title="" title=""></li>
                  <li class="d-inline-block"><img class="img-20 rounded-circle" :src="'/assets/images/user/1.jpg'" alt="" data-original-title="" title=""></li>
                  <li class="d-inline-block"><img class="img-20 rounded-circle" :src="'/assets/images/user/5.jpg'" alt="" data-original-title="" title=""></li>
                  <li class="d-inline-block me-3">
                  <p class="f-12">+5</p>
                  </li>
               </ul>
            </div>
         </div>
      </div>

      <!-- <div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="exampleModalCenter" aria-hidden="true" style="display: none;">
         <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-body">
                  <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                  <CardDetail :card_details="card" ></CardDetail>
               </div>
            </div>
         </div>
      </div> -->

   </div>
</template>

<script setup>

// import CardDetail from '@/components/kanban/CardDetail.vue';

// var props = defineProps(['card']);
// var card_details = [];
// function getCard(){
      // console.log('open card detail',props.card);
      // card_details = props.card;
      // this.card_details = props.card;
// }
</script>

<script>

import axios from 'axios';
import Swal from 'sweetalert2';

export default {
   props:(['card']),
   data(props) {
      console.log('Card:card_id',props.card.id);
      return {
         card: props.card
      }
  },
  methods:{
   
   getCard2(){
      console.log('open card detail',this.card.id);
      this.card_details = this.card.id;
   //    axios.post('/kanban/get-card', { 
   //          card_id: this.card.id
   //    })
   //    .then((res) => {
   //       // console.log('data',res.data.card)
   //       if(res.data.card)
   //       {
   //          this.card_data = res.data.card;
   //       }
   //    })
   //    .catch((error) => {
   //          console.log(error.message);
   //    });
   }
  }
}
</script>