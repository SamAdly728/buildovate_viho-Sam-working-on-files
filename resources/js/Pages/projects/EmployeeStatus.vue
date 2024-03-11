<template>
  <div class="card employee-status">
    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
      <div class="left-content" style="padding-right: 10px;" >
        <h6>INSTALLERS STATUS</h6>
        <small style="color: #1e5bb2;" >
          <span>Contract Fullfillment: 5/7</span><br>
          <span>You still need to fulfill 2 more items on the contract</span>
        </small>
      
      </div>
      
      <div class="right-content"><button class="btn btn-add">+ Add</button></div>
    </div>
    <div class="card-body"  style="height:384px;overflow: scroll;">
      <div class="user-status">
        <table class="table">
          <thead class="centered-header">
            <tr>
              <th style="width: 35%;">Performed By</th>
              <th style="width: 25%;">Progress</th>
              <th style="width: 15%;">Days</th>
              <th style="width: 25%;"></th>
            </tr>
          </thead>
          <tbody>
            <template v-for="(item, index) in items" :key="item.id">
              <tr>
                <td class="bd-t-none u-s-tb">
                  <div class="align-middle image-sm-size d-flex align-items-center"><img class="img-radius align-top m-r-15 rounded-circle" :src="item.photo" alt="">
                    <div class="d-inline-block">
                      <h6>{{ item.name }}</h6>
                      <div class="scope-job">{{ item.position }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-flex align-items-center mx-3">
                      <!-- <span class="steps-left">{{ item.progress }}%</span>
                      <div class="progress flex-grow-1" style="height:8px;">
                          <div class="bg-primary progress-bar" role="progressbar" :style="'width: '+item.progress+'%;'" :aria-valuenow="item.progress" aria-valuemin="0" aria-valuemax="100"></div>
                      </div> -->
                      <apexchart type="radialBar" height="100" :options="chartOptions" :series="[item.progress]"></apexchart>
                  </div>
                </td>
                <td>{{ item.days }}</td>
                <td>
                  <button class="btn btn-primary btn-sm p-2" @click="toggleDetails(index)">
                      {{ item.showDetails ? 'Show Less' : 'Show More' }}
                    </button>
                </td>
              </tr>
              <tr v-if="item.showDetails">
                <td colspan="4">
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
        </table>
      </div>
    </div>
  </div>
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

const chartOptions = {
  chart: {
    type: 'radialBar',
    height: '20px', // Set a fixed height to make the chart smaller
    width: '20px', // Set a fixed width to make the chart smaller
    sparkline: {
      enabled: true
    },
  },
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 0,
        size: '15%', // Adjust the size of the hollow center
      },
      track: {
        strokeWidth: '100%', // Set to 100% for the full track width
        background: '#f2f2f2', // Optional: Set the track color
        opacity: 0.5, // Optional: Set the track opacity
        margin: 0, // Optional: Set the space between the track and the progress bar
      },
      dataLabels: {
        name: {
          show: false,
        },
        value: {
          formatter: function (val) {
            return parseInt(val) + '%';
          },          
          offsetY: 5,
          fontSize: '10px',
        }
      },
      // Adjust the stroke width here, the number is the pixel value for the width of the bar
      stroke: {
        lineCap: 'round',
        width: 1
      },
    }
  },
  colors: ['#1e5bb2'], // Set the color of the progress bar here
  labels: ['Progress'],
};


function toggleDetails(index) {
  let itemData = items.value;
  itemData[index].showDetails = !itemData[index].showDetails;
}

</script>

<style scoped>
.btn-primary {
  background-color: #1e5bb2 !important;
  border-color: #1e5bb2 !important;
}

.btn-add {
  border: 2px solid #1e5bb2;
  background-color: #FFFFFF;
  color: #1e5bb2;
  padding: 4px 25px;
  font-size: 14px;
  border-radius: 4px;
  cursor: pointer;
  outline: none;
  transition: all 0.3s ease;
}

.btn-add:hover {
  background-color: #007BFF; /* Color on hover */
  color: #FFFFFF; /* Text color on hover */
}

.scope-job{
  border: 2px solid #1e5bb2;
  background-color: #FFFFFF;
  color: #1e5bb2;
  padding: 4px 25px;
  font-size: 10px;
  border-radius: 4px;
}
</style>