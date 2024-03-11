<style scoped>
.progress-bar {
  border-radius: 0%;
  padding: 0px;
}
</style>
<template>
  <tbody>
    <template v-for="(item, index) in items" :key="item.id">
    <tr>
      <td class="bd-t-none u-s-tb">
        <div class="align-middle image-sm-size d-flex align-items-center"><img class="img-radius align-top m-r-15 rounded-circle" :src="item.photo" alt="">
          <div class="d-inline-block">
            <h6>{{ item.name }}</h6>
          </div>
        </div>
      </td>
      <td>{{ item.position }}</td>
      <td>
        <div class="d-flex align-items-center">
            <span class="steps-left">{{ item.progress }}%</span>
            <div class="progress flex-grow-1" style="height:8px;">
                <div class="bg-primary progress-bar" role="progressbar" :style="'width: '+item.progress+'%;'" :aria-valuenow="item.progress" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
      </td>
      <td>{{ item.days }}</td>
      <td>
        <button class="btn btn-primary btn-sm" @click="toggleDetails(index)">
            {{ item.showDetails ? 'Show Less' : 'Show More' }}
          </button>
      </td>
    </tr>
    <tr v-if="item.showDetails">

      <td colspan="5">
        <table>
        <tr>
          <th> Description </th>
          <th> Agreements </th>
          <th> Payments </th>
          <th> Schedule </th>
          <th> Issues </th>
          <th> Photos </th>
          <th> Files </th>
        </tr>
        <tr>
          <td>{{ item.description }}</td>
          <td>{{ item.agreements }}</td>
          <td>{{ item.payments }}</td>
          <td>{{ item.schedule }}</td>
          <td>{{ item.Issues }}</td>
          <td>
            <div class="align-middle image-sm-size d-flex align-items-center"><img class="img-radius align-top m-r-15 rounded-circle" :src="item.photo" alt="">
            </div>
          </td>
          <td>{{ item.files }}</td>
        </tr>
      </table>
      </td>
    </tr>
  </template>
</tbody>

</template>

<script setup>
import { ref } from 'vue';

const items = ref([
  { id: 1, name: 'John Deo', position: 'Designer', progress: "30", days: "2 Year", description: "test", agreements:"test", payments: "100", schedule:"January 25", photo:"/assets/images/user/4.jpg",files:"", showDetails: false },
  { id: 2, name: 'Holio Mako', position: 'Developer', progress: "70", days: "3 Year", description: "test", agreements:"test", payments: "100", schedule:"January 26", photo:"/assets/images/user/1.jpg",files:"", showDetails: false },
  { id: 3, name: 'Mohsib lara', position: 'Tester', progress: "50", days: "5 Month", description: "test", agreements:"test", payments: "100", schedule:"January 27", photo:"/assets/images/user/5.jpg",files:"", showDetails: false },
  { id: 4, name: 'Hileri Soli', position: 'Designer', progress: "10", days: "3 Month", description: "test", agreements:"test", payments: "100", schedule:"January 28", photo:"/assets/images/user/6.jpg",files:"", showDetails: false },
  { id: 5, name: 'Pusiz bia', position: 'Designer', progress: "90", days: "5 Year", description: "test", agreements:"test", payments: "100", schedule:"January 29", photo:"/assets/images/user/7.jpg",files:"", showDetails: false },
]);

function toggleDetails(index) {
  let itemData = items.value;
  itemData[index].showDetails = !itemData[index].showDetails;
}
</script>