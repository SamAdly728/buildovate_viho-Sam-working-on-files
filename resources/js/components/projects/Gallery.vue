<template>
   <div class="row">
      <div :class="showDetails ? 'col-9' : 'col-12'">
         <div class="gallery my-gallery card-body row p-0">
            <figure class="gallery-item col-md-4 col-sm-6 mb-1 p-1" itemprop="associatedMedia" v-for="item in items" :key="n">
               <div class="card p-0 custom-rounded">
                  <div class="card-body p-0 m-0">
                     <figcaption class="p-3 bg-gray" itemprop="caption description"><i class="fas fa-image icon-image"></i>  {{ item.title }}</figcaption>
                     
                     <a :href="item.image" itemprop="contentUrl" data-size="1600x950">
                        <img class="img-thumbnail rounded-3 p-0" :src="item.image" itemprop="thumbnail" alt="Image description" style="width: 100%; height: auto;">
                     </a>
                  </div>
                  <div class="card-img-overlay d-flex justify-content-end">
                     <div class="dropdown">
                     <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                     </a>
                     <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                     </ul>
                     </div>
                  </div>
               </div>
            </figure>

         </div>
      </div>
      <div class="col-3 details-panel" v-if="showDetails">
         <div class="card  custom-rounded">
            <div class="card-header d-flex justify-content-between align-items-center p-2 m-1 bg-gray">
               <h6 class="bg-gray"><i class="fas fa-image icon-image"></i> {{selectedImage.title}}</h6>
               <button type="button" class="close" @click="showDetails = false">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="card-body p-1 ">
               <ul class="nav nav-tabs  justify-content-center pb-2">
                  <li class="nav-item">
                     <a class="nav-link active" href="#">Details</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">Activity</a>
                  </li>
               </ul>
               
               <div class = "pt-2">
                  <img :src="selectedImage.image" class="card-img-top p-0 custom-rounded" alt="Descriptive Alt Text">
               </div>
               <div class="access-info my-3">
                  <h6>Who has access</h6>
                  <div class="d-flex">
                     <img :src="selectedImage.image" alt="First User" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                     <div class="mx-2 divider-line"></div>
                     <img :src="selectedImage.image" alt="Second User" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                  </div>
                  <p><small>Owned by you. Shared with Jacob Hill.</small></p>
                  <button type="button" class="btn btn-outline-primary btn-block">Manage Access</button>
               </div>
               <div class="file-details">
                  <h6>File Details</h6>
                  <p>Type: <br> <strong>PDF</strong></p>
                  <p>Size: <br> <strong>5.7 MB</strong></p>
                  <p>Location: <br> <strong>Resume/Firenext</strong></p>
                  <p>Owner: <br> <strong>Me</strong></p>
                  <p>Modified:  <br> <strong>10 Jan 2024 by me</strong></p>

                  Description
                  <input type="text" class="form-control custom-outline" placeholder="Add description">
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
export default {
  data() {
    return {
      showDetails: false, // This will control the visibility of the details panel
      items: [
         { id: 1, title: 'Item 1', image: '/assets/images/landing/demo/1.jpg', description: 'Description for Item 1' },
         { id: 2, title: 'Item 2', image: '/assets/images/landing/demo/2.jpg', description: 'Description for Item 2' },
         { id: 3, title: 'Item 3', image: '/assets/images/landing/demo/3.jpg', description: 'Description for Item 2' },
         { id: 4, title: 'Item 4', image: '/assets/images/landing/demo/1.jpg', description: 'Description for Item 2' },
         { id: 5, title: 'Item 5', image: '/assets/images/landing/demo/1.jpg', description: 'Description for Item 2' },
         { id: 6, title: 'Item 6', image: '/assets/images/big-lightgallry/01.jpg', description: 'Description for Item 2' },
         { id: 7, title: 'Item 7', image: '/assets/images/big-lightgallry/01.jpg', description: 'Description for Item 2' },
         { id: 8, title: 'Item 8', image: '/assets/images/big-lightgallry/01.jpg', description: 'Description for Item 2' },
         { id: 8, title: 'Item 9', image: '/assets/images/big-lightgallry/01.jpg', description: 'Description for Item 2' },
         { id: 10, title: 'Item 10', image: '/assets/images/big-lightgallry/01.jpg', description: 'Description for Item 10' },
      ],
      selectedImage:{
         id: 1,
         title: 'Item 1', 
         image: '/assets/images/landing/demo/1.jpg', 
         description: 'Description for Item 1'
      }
    };
  },
  methods: {
    showImage(item){
      this.showDetails = true;
      // Display details in this side
      this.selectedImage = item;
    }
  },
};
</script>

<style scoped>

.col-9, .col-12 {
  transition: flex-basis 0.3s ease;
}

.gallery-item {
  flex: 0 0 20%; /* Each item should take up 25% of the row */
  max-width: 20%; /* Maximum width for each item is also 25% */
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.access-section {
  margin-top: 20px;
}

.file-details {
  margin-top: 20px;
}

.file-details div {
  margin-bottom: 5px;
}

.divider-line {
  border-left: 1px solid #000; /* Adjust color as needed */
  height: 35px; /* Adjust height as needed */
  display: inline-block; /* Align with the images */
  margin-left: 10px; /* Space from the left image */
  margin-right: 10px; /* Space from the right image */
  vertical-align: middle; /* Center align vertically if needed */
}

.custom-outline {
  background-color: transparent; /* Make the background transparent */
  border: 1px solid #1e5bb2; /* Bootstrap's default border color */
  box-shadow: none; /* Remove the default box-shadow if there is any */
}

.custom-outline:focus {
  border-color: #80bdff; /* Bootstrap's default focus color */
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Bootstrap's default focus shadow */
}

</style>
