<template>
  <div id="app" class="p-15">
    <div class="col-12" style="height:800px">
      <div class="card">
        <div class="card-header pb-0">
          <h5>Kanban</h5>
        </div>
        <div class="card-body">
            <div id="KanbanContainer" class=" kanban-container" style="width: 100%;overflow-x: scroll;display:-webkit-box">
              
              <template v-for="k in Lists" :key="k.id">
                <!-- LIST -->
                <div v-if="Cards[k.id]" data-id="_todo" data-order="1" class="kanban-board" style="width: 295px !important; height:fit-content !important; margin-left: 7px; margin-right: 7px;">
                  <header class="kanban-board-header info">
                    <div class="kanban-title-board">{{ k.title }}</div>
                    <div class="pull-right"><i class="icofont icofont-justify-all"></i></div>
                  </header>
                  <main class="kanban-drag" style="padding:10px !important;">
                    
                      <draggable class="dragArea" @change="log">
                          <template v-for="card in Cards[k.id]" :key="card.id">

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
                                      <CardDetail :card="card" :list_title="k.title"/>
                                  </div>
                                </div>
                                </div>
                            </div>
                          </template>
                      </draggable>

                    <div v-show="k.showAddCard" id="newCard">
                        <textarea v-model="k.card_title" v-on:keyup.enter="addCard(k.id, k.card_title)" :id="'newCardTitle'+k.id" class="form-control mb-2" placeholder="Enter a title for this card..." style="border-radius: 8px;"></textarea>
                    </div>
                    <button v-if="!k.showAddCard" @click="k.showAddCard=true;setTheFocus();" class="btn btn-light fs-7 mt-2 text-muted" style="font-weight: 400;width:100%;text-align: left;"><i class="icofont icofont-plus me-2"></i>Add a card</button>
                    
                    <button  v-if="k.showAddCard" @click="addCard(k.id, k.card_title)" class="btn btn-sm btn-primary fs-7" style="font-weight: 400;">Add a card</button> 
                    <button  v-if="k.showAddCard" @click="k.showAddCard=false" class="btn btn-default fs-7" style="font-weight: bold;">X</button> 
                  </main>
                  <footer></footer>
                </div>
                
              </template>
              <!-- New LIST -->
              <div class="kanban-board" style="width: 295px !important; height:fit-content !important; margin-left: 7px; margin-right: 7px;-webkit-box-shadow:none;box-shadow:none;">
                <main class="kanban-drag" style="padding: 10px !important;min-height: 55px !important;">
                  <div v-if="showAddList" id="newList">
                      <input type="text" v-model="list_title" class="form-control mb-2" placeholder="Enter list title..." style="border-radius: 8px;">
                  </div>
                  <button v-if="!showAddList" @click="showAddList=true" type="button" class="btn btn-light fs-7 text-muted" style="font-weight: 400;width: 100%;text-align: left;"><i class="icofont icofont-plus me-2"></i>Add List</button>
                  
                  <button  v-if="showAddList" @click="addList" type="button" class="btn btn-sm btn-primary fs-7" style="font-weight: 400;">Add List</button> 
                  <button  v-if="showAddList" @click="showAddList=false"  type="button" class="btn btn-default fs-7" style="font-weight: bold;">X</button> 
                </main>
                <footer></footer>
              </div>

            </div>
        </div>
      </div>
    </div>


    
  </div>
</template>


<script setup>
// import KanbanList from '@/components/kanban/List.vue';
import { VueDraggableNext } from 'vue-draggable-next';
import KanbanCard from '@/components/kanban/Card.vue';
import CardDetail from '@/components/kanban/CardDetail.vue';
import { router } from '@inertiajs/vue3';

</script>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  props:(['lists','cards']),
  mounted(){
    this.scrollRight();
  },
  components: {
      CardDetail,
      draggable: VueDraggableNext,
  },
  data(props) {

    // console.log('lists',props.lists);
    // console.log('cards',props.cards);
    return {
      Lists: props.lists,
      Cards: props.cards,
      showAddList:false,
      list_title:'',

      showAddCard:false,
      // card_title : '',
      
    }
  },
  methods:{
    log(event) {
        console.log(event)
    },
    addList(){
      if(this.list_title=='')
      {
        Swal.fire({
          html: 'Please name your list.',
          icon: "error",
          buttonsStyling : false,
          confirmButtonText : "OK, Got It!",
          customClass: {
            confirmButton: 'btn btn-md btn-danger text-white',
        }});

      }else{

        axios.post('/kanban/add-list', { 
          list_title:this.list_title
        })
        .then((res) => {
          if(res.data.success)
          {
            this.Lists.push({ id: res.data.last_id, title: this.list_title });
            this.list_title = '';
            this.showAddList = false;
            this.scrollRight();
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
    addCard(list_id, card_title){
         if(card_title=='')
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
                  list_id: list_id,
                  card_title:card_title
            })
            .then((res) => {
               if(res.data.success)
               {
                  // this.Cards.push({ id: res.last_id, title: this.card_title });
                  this.getCards(list_id);
                  document.getElementById("newCardTitle"+list_id).value = "";
                  // var textarea = document.querySelector('#newCardTitle'+list_id);

                  // console.log('textarea',textarea);
                  // textarea.value='';
                  // card_title = '';
                  // this.showAddCard = false;
                  // router.reload();
               }else{
                  Swal.fire({
                  title: 'Failed! '+res.data.message,
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
      getCards(list_id){
         axios.post('/kanban/get-cards', { 
               list_id: list_id
         })
         .then((res) => {
            // console.log('cards',res.data.cards)
            if(res.data.cards)
            {
               this.Cards[list_id] = res.data.cards;
            }
         })
         .catch((error) => {
               console.log(error.message);
         });
      },
      setTheFocus(){
         // this.card_title.focus();
         document.getElementById('newCardTitle').focus();
      },
      scrollRight(){
        var element = document.getElementById('KanbanContainer');
        element.scrollLeft = element.scrollWidth + 200;
      }
  }
}
</script>
