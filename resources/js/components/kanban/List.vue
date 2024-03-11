<style scoped>
.kanban-drag{
   min-height: 55px !important;
}
</style>
<template>
   <div data-id="_todo" data-order="1" class="kanban-board" style="width: 295px !important; height:fit-content !important; margin-left: 7px; margin-right: 7px;">
      <header class="kanban-board-header info">
         <div class="kanban-title-board">{{ list_title }}</div>
         <div class="pull-right"><i class="icofont icofont-justify-all"></i></div>
      </header>
      <main class="kanban-drag" style="padding:10px !important;">

         <draggable class="dragArea" :Cards="Cards" @change="log">
            <template v-for="card in Cards" :key="card.id">

               <!-- <a @click="getCard(card)" class="kanban-box" href="javascript:void(0)"> -->
               <a class="kanban-box" href="javascript:void(0)" data-bs-toggle="modal" :data-bs-target="'#cardModal'+card.id">
               <!-- <a @click="getCard(card)" class="kanban-box" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#cardModal"> -->
                     <KanbanCard class="mb-2" :card="card"/>
               </a>
               <div class="modal fade" :id="'cardModal'+card.id" tabindex="-1" aria-labelledby="cardModal" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                     <div class="modal-body">
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                        <CardDetail :card="card" :list_title="list_title"/>
                     </div>
                  </div>
                  </div>
               </div>

            </template>

         </draggable>
         <div v-show="showAddCard" id="newCard">
            <textarea v-model="card_title" v-on:keyup.enter="addCard" id="newCardTitle" class="form-control mb-2" placeholder="Enter a title for this card..." style="border-radius: 8px;"></textarea>
         </div>
         <button v-if="!showAddCard" @click="showAddCard=true;setTheFocus();" class="btn btn-light fs-7 mt-2 text-muted" style="font-weight: 400;width:100%;text-align: left;"><i class="icofont icofont-plus me-2"></i>Add a card</button>
         
         <button  v-if="showAddCard" @click="addCard" class="btn btn-sm btn-primary fs-7" style="font-weight: 400;">Add a card</button> 
         <button  v-if="showAddCard" @click="showAddCard=false" class="btn btn-default fs-7" style="font-weight: bold;">X</button> 
      </main>
      <footer></footer>

      <!-- {{ modalData }} -->

      

      <!-- <div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModal" aria-hidden="true" style="display: none;">
         <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
            <div class="modal-body">
               <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
               {{ modalData }}
               <CardDetail :card_details="modalData" />
            </div>
         </div>
         </div>
      </div> -->

   </div>

   

</template>

<script setup>
import KanbanCard from '@/components/kanban/Card.vue';
import { router } from '@inertiajs/vue3';


</script>

<script>
import { VueDraggableNext } from 'vue-draggable-next';
import CardDetail from '@/components/kanban/CardDetail.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
   props:(['id','title']),
   components: {
      CardDetail,
      draggable: VueDraggableNext,
   },
   data(props) {
      return {
         list_id: props.id,
         list_title: props.title, //board or list title
         Cards:[],
         modalData:[{ id:0}],
         card_details:[],
         showAddCard:false,
         card_title : '',
         enabled: true,
         dragging: false,
      }
  },
  mounted(){
      this.getCards();
  },
  methods:{
      log(event) {
         console.log(event)
      },
      getCard(card){
         // $refs.cardModal.show({
         //    title: 'My Title',
         //    content: 'My Content'
         // });
         // this.$bvModal.show("cardModal");
         // console.log('card',card);
         
         // setTimeout(function(){
            this.modalData = card;
         //    console.log('card_details',this.card_details);
         // },1000);
         // this.$nextTick(() => {
            // this.modalData = card;
            // console.log('card_details',this.modalData);
         // });
      },
      getCards(){
         axios.post('/kanban/get-cards', { 
               list_id: this.list_id
         })
         .then((res) => {
            // console.log('cards',res.data.cards)
            if(res.data.cards)
            {
               this.Cards = res.data.cards;
            }
         })
         .catch((error) => {
               console.log(error.message);
         });
      },
      addCard(){
         if(this.card_title=='')
         {
            Swal.fire({
               html: 'Please name your card.',
               icon: "error",
               buttonsStyling : false,
               confirmButtonText : "OK, Got It!",
               customClass: {
                  confirmButton: 'btn btn-md btn-danger text-white',
            }});

         }else{

            axios.post('/kanban/add-card', { 
                  list_id: this.list_id,
                  card_title:this.card_title
            })
            .then((res) => {
               if(res.data.success)
               {
                  // this.Cards.push({ id: res.last_id, title: this.card_title });
                  this.getCards();
                  this.card_title = '';
                  // this.showAddCard = false;
                  router.reload();
               }else{
                  Swal.fire({
                  title: 'Something went wrong. Please try again later.',
                  icon: "error",
                  buttonsStyling : false,
                  confirmButtonText : "OK, Got It!",
                  customClass: {
                     confirmButton: 'btn btn-md btn-danger text-white',
                  }});
               }
            })
            .catch((error) => {
                  console.log(error.message);
            });
         }
      },
      setTheFocus(){
         // this.card_title.focus();
         document.getElementById('newCardTitle').focus();
      }
   }
}
</script>