<template>
  <div id="app">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <h5>API</h5>
          <p class="mb-0">add item, add board, delete board:</p>
        </div>
        <div class="card-body">
            <div class="kanban-container" style="width: 1800px;">
              <template v-for="k in Kanbans" :key="k.id">
                <KanbanList :id="k.id" :title="k.title" />
              </template>
            </div>

          <button class="btn btn-primary" @click="addList">Add List</button>
          <button class="btn btn-secondary" id="addToDo">Add element in &quot;To Do&quot; Board</button>
          <button class="btn btn-danger mb-0" id="removeBoard">Remove &quot;Done&quot; Board</button>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import KanbanList from '@/components/kanban/List.vue';
</script>

<script>
export default {
  data() {
    var Kanbans =  [
      { "id":1, "title" : "Scope of Work" },
      { "id":2, "title" : "Engineering" },
      { "id":3, "title" : "Jobsite" },
      { "id":4, "title" : "Material" },
      { "id":5, "title" : "Crew" },
      { "id":6, "title" : "Financial" },
      
    ];
    return {
      Kanbans,
    }
    
  },
}
</script>
