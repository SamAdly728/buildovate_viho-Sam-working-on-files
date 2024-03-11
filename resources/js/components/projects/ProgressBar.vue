<style scoped>
.progress-bar{
    border-radius: 0 !important;
}
.progress{
   height: 24px !important;
}
</style>
<template>
   <div class="col-12">
      <h6>Progress Bar</h6>
      <div class="progress mb-4">
         <div class="progress-bar-animated bg-primary progress-bar-striped" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <div class="row mb-3">
         <div class="col-4">
           <span class="h6"> Money In </span>
         </div>
         <div class="col-6">
           <span class="h6"> $13,000 out of $50,000 </span>
         </div>
      </div>
      <div class="row mb-3">
         <div class="col-4">
           <span class="h6"> Money Out </span>
         </div>
         <div class="col-6">
           <span class="h6"> $7,500 out of $23,000 </span>
         </div>
      </div>
      <div class="row mb-3">
         <div class="col-4">
           <span class="h6"> Installers </span>
         </div>
         <div class="col-6">
            <div class="progress">
            <div class="progress-bar-animated progress-bar-striped bg-secondary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
         </div>
      </div>
      <div class="row mb-3">
         <div class="col-4">
           <span class="h6"> Materials </span>
         </div>
         <div class="col-6">
            <div class="progress">
            <div class="progress-bar-animated progress-bar-striped bg-secondary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
         </div>
      </div>
      <div class="row mb-3">
         <div class="col-4">
           <span class="h6"> Commissions </span>
         </div>
         <div class="col-6">
            <span class="h6"> $1,200 out of $5,000 </span>
         </div>
      </div>
      <div class="row mb-3">
         <div class="col-4">
           <span class="h6"> To Do's </span>
         </div>
         <div class="col-6">
            <span class="h6"> 12 out of 15 </span>
         </div>
      </div>
   </div>
   <!-- <div class="col">
      <div class="progress">
      <div class="progress-bar-animated bg-primary progress-bar-striped" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <div class="progress">
      <div class="progress-bar-animated progress-bar-striped bg-secondary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <div class="progress">
      <div class="progress-bar-animated progress-bar-striped bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <div class="progress">
      <div class="progress-bar-animated progress-bar-striped bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
   </div> -->
</template>
