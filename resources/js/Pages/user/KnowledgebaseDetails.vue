<template>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-3 xl-40">
          <div class="job-sidebar"><a class="btn btn-primary job-toggle" href="javascript:void(0)">Knowledge filter</a>
            <div class="job-left-aside custom-scrollbar custom-scrollbar">
              <div class="default-according style-1 faq-accordion job-accordion" id="accordionoc">
                <div class="row">
                  <div class="col-xl-12">
                    <div class="card">
                      <div class="card-header">
                        <h5 class="mb-0 p-0">
                          <button type="button" class="btn btn-link" data-bs-toggle="collapse2" data-bs-target="#collapseicon1">Knowledge Categories</button>
                        </h5>
                      </div>
                      <div class="collapse2" id="collapseicon1" aria-labelledby="collapseicon1" data-bs-parent="#accordion">
                        <div class="categories">
                          &nbsp;<br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                        </div>
                        <!-- <div class="categories">
                          <div class="learning-header"><span class="f-w-600">Design</span></div>
                          <ul>
                            <li><a href="#">UI Design </a><span class="badge badge-primary pull-right">28</span></li>
                            <li><a href="#">UX Design </a><span class="badge badge-primary pull-right">35</span></li>
                            <li><a href="#">Interface Design </a><span class="badge badge-primary pull-right">17</span></li>
                            <li><a href="#">User Experience </a><span class="badge badge-primary pull-right">26</span></li>
                          </ul>
                        </div>
                        <div class="categories pt-0">
                          <div class="learning-header"><span class="f-w-600">Development</span></div>
                          <ul>
                            <li><a href="#">Frontend Development</a><span class="badge badge-primary pull-right">48</span></li>
                            <li><a href="#">Backend Development</a><span class="badge badge-primary pull-right">19</span></li>
                          </ul>
                        </div> -->
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-12">
                    <div class="card">
                      <div class="card-header">
                        <h5 class="mb-0 p-0">
                          <button class="btn btn-link" data-bs-toggle="collapse2" data-bs-target="#collapseicon2" aria-expanded="true" aria-controls="collapseicon2">
                            Speak to Someone
                          </button>
                        </h5>
                      </div>
                      <div class="collapse2 show" id="collapseicon2" aria-labelledby="collapseicon2" data-bs-parent="#accordion">
                        <div class="upcoming-course card-body text-center">
                          <h4 class="text-success">Live Agent: (855) 455 - 1234 </h4>

                          <div class="card target-sec">
                            <div class="card-header pb-0" style="border-bottom:none !important">                                     
                              <ul class="target-list">
                                <li>   
                                  <a href="#">                                   
                                    <h6>Live <br>Chat</h6>
                                  </a>  
                                </li>
                                <li>   
                                  <a href="#">                                   
                                    <h6>Live <br>Zoom</h6>
                                  </a>  
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-9 xl-60 box-col-8">                        
          <div class="blog-single">
            <div class="blog-box">
              <div class="card"><img class="img-fluid w-100" src="https://dev2.buildovate.io/assets/images/knowledgebase/1.jpg" alt="blog-main"></div>
              <div class="card">
                <div class="card-body">
                  <div class="blog-details">                                  
                    <h4 class="mt-0">{{ article.title }}</h4>
                    <div class="single-blog-content-top" v-html="article.content">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
</template>

<script setup>
defineProps(['article']);
// import KLink from "@/components/KLink.vue"; //knowledegebase link
// import VueFeather from 'vue-feather';

</script>
