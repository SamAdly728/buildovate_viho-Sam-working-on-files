<style scoped>
.progress-bar {
  border-radius: 0%;
  padding: 0px;
}
</style>

<template>
    <div class="card employee-status">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
      <div class="left-content" style="padding-right: 10px;" >
        <h6>MATERIALS STATUS</h6>
        <small style="color: #1e5bb2;" >
          <span>Contract Fullfillment: 4/5</span><br>
          <span>You still need to fulfill 1 more items on the contract</span>
        </small>
      
      </div>
      
      <div class="right-content"><button class="btn btn-add">+ Add</button></div>
    </div>

      <div class="card-body"  style="height:384px;overflow: scroll;">
        <div class="user-status">
          <table class="table">
            <thead class="centered-header">
              <tr>
                <th style="width: 35%;">Material</th>
                <!-- <th scope="col">Vendor</th> -->
                <th style="width: 25%;">Order Status</th>
                <th style="width: 15%;">Payment</th>
                <th style="width: 25%;"></th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(item, index) in items" :key="item.id">
              <tr>
                <td class="bd-t-none u-s-tb">
                  <div class="align-middle image-sm-size d-flex align-items-center"><img class="img-radius align-top m-r-15 rounded-circle" :src="item.photo" alt="">
                    <div class="d-inline-block">
                      <h6>{{ item.material }}</h6>
                      <div class="scope-job">{{ item.vendor }}</div>
                    </div>
                  </div>
                </td>
                <!-- <td>{{ item.vendor }}</td> -->
                <td>
                  <!-- {{ item.order_status }} -->
                  <div class="d-flex align-items-center">
                      <span class="steps-left">{{ item.progress }}%</span>
                      <div class="progress flex-grow-1" style="height:8px;">
                          <div class="bg-primary progress-bar" role="progressbar" :style="'width: '+item.progress+'%;'" :aria-valuenow="item.progress" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                  </div>
                </td>
                <td>{{ item.payment }}</td>
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
                    <th> Notes </th>
                    <th> Items </th>
                    <th> Place Order </th>
                    <th> Total </th>
                  </tr>
                  <tr>
                    <td>{{ item.notes }}</td>
                    <td>{{ item.items }}</td>
                    <td>{{ item.place_order }}</td>
                    <td>{{ item.total }}</td>
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
  { id: 1, material: 'Screws', vendor: 'Home Depot', order_status: "Ordered", payment: "Paid", notes: "test", items:"test", place_order: "100", total:"January 25", photo:"/assets/images/user/4.jpg", showDetails: false, progress: "30" },
  { id: 2, material: 'Pavers', vendor: 'Non Selected', order_status: "Not Ordered", payment: "Paid", notes: "test", items:"test", place_order: "100", total:"January 26", photo:"/assets/images/user/1.jpg", showDetails: false, progress: "30" },
  { id: 3, material: 'Fan', vendor: 'Lowes', order_status: "Ordered", payment: "Paid", notes: "test", items:"test", place_order: "100", total:"January 27", photo:"/assets/images/user/5.jpg",showDetails: false, progress: "30" },
  { id: 4, material: 'Pargola', vendor: '4K Aluminum', order_status: "Ordered", payment: "Paid", notes: "test", items:"test", place_order: "100", total:"January 28", photo:"/assets/images/user/6.jpg", showDetails: false, progress: "30" },
  { id: 5, material: '3D Design', vendor: 'Designer', order_status: "Ordered", payment: "Paid", notes: "test", items:"test", place_order: "100", total:"January 29", photo:"/assets/images/user/7.jpg", showDetails: false, progress: "30" },
]);

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