<template>
  <div class="container-fluid">
  
    <Categories />
    
    <div class="row mb-4">
      <div class="col-sm-12 text-center">
          <a href="#" class="btn btn-outline-success">ACTIVE</a>&nbsp;
          <a href="#" class="btn btn-outline-success">MISSING DETAILS</a>&nbsp;
          <a href="#" class="btn btn-outline-success">DELIVERED</a>&nbsp;
          <a href="#" class="btn btn-outline-success">COMPLETED</a>&nbsp;
          <a href="#" class="btn btn-outline-success">CANCELLED</a>&nbsp;
          <a href="#" class="btn btn-outline-success">ALL</a>&nbsp;
      </div>
    </div>
  
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>Floor Plan Orders</h5><span>Use a class<code>table</code> to any table.</span>
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Job</th>
                  <th scope="col">Customer Contact</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Plan Type</th>
                  <th scope="col">Order Date</th>
                  <th scope="col">Age</th>
                  <th scope="col">Status</th>
                  <th scope="col">Salesperson</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Alexander</td>
                  <td>Orton</td>
                  <td>@mdorton</td>
                  <td>Admin</td>
                  <td>USA</td>
                  <td>lorem</td>
                  <td>ipsum</td>
                </tr>
                <tr>
                  <th scope="row">1</th>
                  <td>Alexander</td>
                  <td>Orton</td>
                  <td>@mdorton</td>
                  <td>Admin</td>
                  <td>USA</td>
                  <td>lorem</td>
                  <td>ipsum</td>
                </tr>
                <tr>
                  <th scope="row">1</th>
                  <td>Alexander</td>
                  <td>Orton</td>
                  <td>@mdorton</td>
                  <td>Admin</td>
                  <td>USA</td>
                  <td>lorem</td>
                  <td>ipsum</td>
                </tr>
                <tr>
                  <th scope="row">1</th>
                  <td>Alexander</td>
                  <td>Orton</td>
                  <td>@mdorton</td>
                  <td>Admin</td>
                  <td>USA</td>
                  <td>lorem</td>
                  <td>ipsum</td>
                </tr>
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  
  </template>
  
  <script setup>
  import Categories from "@/Pages/production/plans_permits/Categories.vue";
  import Link from "@/components/Link.vue";
  
  </script>
  
  