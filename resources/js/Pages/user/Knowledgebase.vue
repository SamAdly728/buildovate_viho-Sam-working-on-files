<template>
    <!-- Container-fluid starts-->
    <div class="container-fluid faq-section">
      <div class="row">
        <div class="col-12">
          <div class="knowledgebase-bg" style="background-image: url('/assets/images/knowledgebase/bg_1.png'); background-size: contain; background-position: center center; display: block;background-repeat: no-repeat;">
            
          </div>
          <div class="knowledgebase-search">
            <div style="padding-left: 115px;padding-top: 0px;">
              <h2 class="text-warning fs-1" style="font-weight: 600;">EASILY MANAGE <br>YOUR PROJECTS</h2><br>
              <h3 class="text-white">How Can I help you?</h3>
              <form class="form-inline" action="#" method="get">
                <div class="form-group w-100 mb-0"><i data-feather="search"></i>
                  <input class="form-control-plaintext w-100" type="text" placeholder="Type question here" title="">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-xl-4 xl-50 col-lg-6 box-col-6">
          <div class="card bg-primary">
            <div class="card-body">
              <div class="media faq-widgets">
                <div class="media-body">
                  <h5>Articles</h5>
                  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                </div>
                <!-- <i data-feather="book-open"></i> -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 xl-50 col-lg-6 box-col-6">
          <div class="card bg-primary">
            <div class="card-body">
              <div class="media faq-widgets">
                <div class="media-body">
                  <h5>Knowledgebase</h5>
                  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                </div>
                <!-- <i data-feather="aperture"></i> -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-aperture"><circle cx="12" cy="12" r="10"></circle><line x1="14.31" y1="8" x2="20.05" y2="17.94"></line><line x1="9.69" y1="8" x2="21.17" y2="8"></line><line x1="7.38" y1="12" x2="13.12" y2="2.06"></line><line x1="9.69" y1="16" x2="3.95" y2="6.06"></line><line x1="14.31" y1="16" x2="2.83" y2="16"></line><line x1="16.62" y1="12" x2="10.88" y2="21.94"></line></svg>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-12 xl-100 box-col-12">
          <div class="card bg-primary">
            <div class="card-body">
              <div class="media faq-widgets">
                <div class="media-body">
                  <h5>Support</h5>
                  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                </div>
                <!-- <vue-feather type="file-text"></vue-feather> -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="header-faq">
            <h5 class="mb-0">knowledge articles by category </h5>
          </div>
          <div class="row browse">

            <template v-for="cat in categories" :key="cat.id">
              <div class="col-xl-4 xl-50 col-md-6">
                <div class="faq-image product-img">
                  <img class="img-fluid" src="https://dev2.buildovate.io/assets/images/faq/1.jpg" alt="">
                </div>
                <div class="browse-articles">
                  <h6>
                    <span>
                      <vue-feather type="archive"></vue-feather>
                    </span>
                    {{ cat.title }}
                  </h6>

                  <ul v-if="articles[cat.id]">
                    
                    <li v-for="art in articles[cat.id]" :key="art.id">
                      <KLink 
                        href="/user/knowledgebase/details" 
                        :name="art.title"
                        :data="{ id: art.id }"
                        >
                      </KLink>
                    </li>
                   
                    <!-- <li>
                        <a class="f-w-600 font-primary" href="knowledge-detail.html">            
                        <i class="me-1" data-feather="arrow-right"></i><span>See More (40)</span></a>
                    </li> -->
                  </ul>
                </div>
              </div>
            </template>

          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
</template>

<script setup>
import KLink from "@/components/KLink.vue"; //knowledegebase link
import VueFeather from 'vue-feather';
defineProps(['categories','articles']);

</script>

