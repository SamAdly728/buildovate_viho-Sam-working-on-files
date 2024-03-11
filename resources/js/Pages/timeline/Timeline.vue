<script setup>

    import { onMounted, ref, watch } from "vue";
    import ModalAddTimeline from "./ModalAddTimeline.vue";
    import axios from 'axios';

    //const props = defineProps(["type", "id", "leads", "jobsites"]);
    const item = ref([]);
    const show = ref(false);
    const reloadPage = ref(false);
    const items = ref([]);


    const handleReloadPage = () => {
    reloadPage.value = true;
    setTimeout(() => {
        reloadPage.value = false;
    }, 2000);
    };

    const handleEdit = (singleItem) => {
        console.log("Handle Edit");
        item.value = singleItem;
        show.value = !show.value
        console.log(show.value);
    };

    const fetchData = async () => {
        try {
            const response =  await axios.get('/api/timeline/fetch');
            items.value = response.data;
            console.log(items.value);
        } catch (error) {
            console.error(error);
        }
    };

    onMounted(() => {
        fetchData();
    });

    watch([reloadPage], () => {
        if (reloadPage.value) {
            fetchData();
        }
    });
</script>

<template>
  <div class="p-3 contenttop">
    <div class="ps-0">
        <div
          class="tab-pane fade active show"
          id="pills-created"
          role="tabpanel"
          aria-labelledby="pills-created-tab"
        >
          <div class="card mb-0">
            <div class="row gx-5">
              <div class="col">
                <div class="card-header">
                  <div class="">
                    <h5 class="mb-0">Timeline Settings</h5>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="p-3 text-right">
                  <button
                    type="button"
                    class="btn btn-light"
                    data-bs-toggle="modal"
                    data-original-title="test"
                    data-bs-target="#addCrew"
                    data-bs-original-title=""
                    @click="show = !show"
                  >
                    Add
                  </button>
                </div>
              </div>
            </div>

            <div class="p-4">
              <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Sequence</th>
                    <th>Title</th>
                    <th>Icon</th>
                    <th>Content</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in items" :key="item.id">
                    <td>{{ item.id }}</td>
                    <td>{{ item.sequence }}</td>
                    <td>{{ item.title }}</td>
                    <td>{{ item.icon }}</td>
                    <td v-html="item.html_content"></td>
                    <td>{{ item.status ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a data-bs-toggle="modal" data-original-title="test" data-bs-target="#addCrew" data-bs-original-title="" 
                            @click=handleEdit(item)><i class="icofont icofont-pencil-alt-2" style="font-size: 20px"></i></a>
                        <a @click.prevent="removeTodoItem(item.id)"
                        ><i class="icofont icofont-trash ms-2" style="font-size: 20px"></i></a>
                    </td>
                </tr>
                </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
  </div>
  <ModalAddTimeline
    v-show="show"
    :item = "item"
    @reload="handleReloadPage"
  ></ModalAddTimeline>
</template>
