<style>
</style>
<template>
  <div class="card rounded" style="background-color: #F5F9FF">
    <div class="card-body p-2">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Installers</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-tabs" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Users</a></li>
        <li class="nav-item"><a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">All</a></li>
      </ul>
      <div class="text-center mt-2 mb-2">See your installers schedule. Share it with them too.</div>
      <hr style="background-color: #1E5BB2">
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="media mb-3 justify-content-between">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              View All
            </label>
            <span class="pull-">Schedule Shared</span>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              Installer 1
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              Installer 2
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              Installer 3
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="media mb-3 justify-content-between">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              View All
            </label>
            <span class="pull-">Schedule Shared</span>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              User 1
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              User 2
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              User 3
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          <div class="media mb-3 justify-content-between">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              View All
            </label>
            <span class="pull-">Schedule Shared</span>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              Installer 1
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              User 1
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              Installer 2
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              Installer 3
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              User 2
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
          <div class="media">
            <label class="d-block" for="chk-ani">
              <input class="checkbox_animated" id="chk-ani" type="checkbox" >
              User 3
            </label>
            <div class="media-body text-end switch-sm icon-state">
              <label class="switch">
                <input type="checkbox" ><span class="switch-state"></span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
</script>