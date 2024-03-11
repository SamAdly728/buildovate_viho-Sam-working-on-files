<style scoped>
.accordion {
  cursor: pointer;
  width: 100%;
  border: none;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}

.active, .accordion:hover {
  background-color: #E6EDEF;
  content: '\002B';
  color: #6c757d;
  padding: 10px;
  border-radius: 5px;
}

.accordion:after {
  content: '\002B';
  color: #6c757d;
  font-weight: bold;
  float: right !important;
}

.active:after {
  content: "\2212";
}

.panel {
  padding: 0 18px;
  background-color: white;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
.zoom_icon {
  -ms-transform: scale(1.5); /* IE 9 */
  -webkit-transform: scale(1.5); /* Safari 3-8 */
  transform: scale(2);
  transition: all 300ms ease;
  -o-transition: all 300ms ease;
  -ms-transition: all 300ms ease;
  -moz-transition: all 300ms ease;
  -webkit-transition: all 300ms ease;
}

</style>

<template>
  <div class="job-left-aside custom-scrollbar">
    <div class="file-sidebar">
      <div class="card">
        <div class="card-body">
          <ul>
            <li class="">
              <div id="accordion" class="accordion">
                <i class="files-icon icofont icofont-files text-muted mr-1"></i>
                <span class="text-muted">Files</span>
              </div>
              <div id="panel" class="panel mt-2">
                <Link href="/files/user_files/design"><div class="btn btn-outline-light btn-sm mb-1 txt-dark"><i class="fa fa-folder txt-warning mr-2"></i><span>Designs</span></div></Link>
                <Link href="/files/user_files/contract"><div class="btn btn-outline-light btn-sm mb-1 txt-dark"><i class="fa fa-folder txt-warning mr-2"></i><span>Contracts</span></div></Link>
                <Link href="/files/user_files/checklist"><div class="btn btn-outline-light btn-sm mb-1 txt-dark"><i class="fa fa-folder txt-warning mr-2"></i><span>Checklists</span></div></Link>
                <Link href="/files/user_files/engineering"><div class="btn btn-outline-light btn-sm mb-1 txt-dark"><i class="fa fa-folder txt-warning mr-2"></i><span>Engineering Plans</span></div></Link>
                <Link href="/files/user_files/site"><div class="btn btn-outline-light btn-sm mb-1 txt-dark"><i class="fa fa-folder txt-warning mr-2"></i><span>Site Plans</span></div></Link>
                <Link href="/files/user_files/architectural"><div class="btn btn-outline-light btn-sm mb-1 txt-dark"><i class="fa fa-folder txt-warning mr-2"></i><span>Architectural Drawings</span></div></Link>
                <Link href="/files/user_files/permit"><div class="btn btn-outline-light btn-sm mb-1 txt-dark"><i class="fa fa-folder txt-warning mr-2"></i><span>Permits</span></div></Link>
                <Link href="/files/user_files/inspection"><div class="btn btn-outline-light btn-sm mb-1 txt-dark"><i class="fa fa-folder txt-warning mr-2"></i><span>Inspections</span></div></Link>
                <Link href="/files/user_files/warranty"><div class="btn btn-outline-light btn-sm mb-1 txt-dark"><i class="fa fa-folder txt-warning mr-2"></i><span>Warranties</span></div></Link>
                <Link href="/files/user_files/document"><div class="btn btn-outline-light btn-sm txt-dark"><i class="fa fa-folder txt-warning mr-2"></i><span>Documents</span></div></Link>
                <div class="justify-content-center flex mt-2" v-if="userFolder.length > 0">
                  <small @click="toggleShow" class="text-muted">--Show More--</small>
                </div>
              </div>
            </li>
            <li v-for="folder in userFolder">
              <div class="" style="padding: 0 18px" v-if="showMore">
                <Link :href="'/files/folders/content/'+folder.file_folder_id">
                  <div class="btn btn-outline-light btn-sm mb-1 txt-dark">
                    <i class="fa fa-folder txt-warning mr-2"></i>
                    <span>{{folder.folder_name}}</span>
                  </div>
                </Link>
              </div>
            </li>
            <hr>
            <li>
              <Link href="/files/user_files/photos" class="btn btn-light" @mouseleave="zoomIcon.zoomPhoto = false" @mouseover="zoomIcon.zoomPhoto = true">
                <i :class="{ zoom_icon: zoomIcon.zoomPhoto }" class="icofont icofont-social-photobucket mr-3 text-warning"></i>
                <span class="text-muted">Photos</span>
              </Link>
            </li>
            <li>
              <Link href="/files/user_files/videos" class="btn btn-light" @mouseleave="zoomIcon.zoomVideo = false" @mouseover="zoomIcon.zoomVideo = true">
                <i :class="{ zoom_icon: zoomIcon.zoomVideo }" class="left-side-icon icofont icofont-ui-video mr-3 text-info"></i>
                <span class="text-muted">Videos</span>
              </Link>
            </li>
            <li>
              <Link href="/files/user_files/googleDrive" class="btn btn-light" @mouseleave="zoomIcon.zoomDrive = false" @mouseover="zoomIcon.zoomDrive = true" style="display: flex">
                <img :class="{ zoom_icon: zoomIcon.zoomDrive }" class="mr-3" style="width: 13px; height: 13px" :src="googleDriveIcon" alt="">
                <span class="text-muted">Google Drive</span>
                <span class="text-muted" style="margin-left: auto"><small>Not Connected</small></span>
              </Link>
            </li>
            <li>
              <Link href="/files/user_files/dropbox" class="btn btn-light" @mouseleave="zoomIcon.zoomDropbox = false" @mouseover="zoomIcon.zoomDropbox = true" style="display: flex">
                <i :class="{ zoom_icon: zoomIcon.zoomDropbox }" class="icofont icofont-social-dropbox mr-3 text-primary"></i>
                <span class="text-muted">Dropbox</span>
                <span class="text-muted" style="margin-left: auto"><small>Not Connected</small></span>
              </Link>
            </li>
            <li>
              <a href="/files/user_files/starred" class="btn btn-light" @mouseleave="zoomIcon.zoomStarred = false" @mouseover="zoomIcon.zoomStarred = true">
                <i :class="{ zoom_icon: zoomIcon.zoomStarred }" class="icofont icofont-star-alt-1 mr-3"></i>
                <span class="text-muted">Starred</span>
              </a>
            </li>
            <li>
              <Link href="/files/user_files/trash" class="btn btn-light" @mouseleave="zoomIcon.zoomTrash = false" @mouseover="zoomIcon.zoomTrash = true">
                <i :class="{ zoom_icon: zoomIcon.zoomTrash }" class="icofont icofont-trash mr-3 text-danger">
                </i><span class="text-muted">Trash</span>
              </Link>
            </li>
            <li>
              <Link href="/files/user_files/settings" class="btn btn-light" @mouseleave="zoomIcon.zoomSettings = false" @mouseover="zoomIcon.zoomSettings = true">
                <i :class="{ zoom_icon: zoomIcon.zoomSettings }" class="icofont icofont-gears mr-3 text-dark"></i>
                <span class="text-muted">Settings</span>
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<script>
export default {
  props: ['userFolder'],
  data() {
    return {
      showMore: false,
      filesIcon: false,
      googleDriveIcon: window.location.origin + '/assets/images/googledrive.png',
      zoomIcon: {
        zoomPhoto: false,
        zoomVideo: false,
        zoomDrive: false,
        zoomDropbox: false,
        zoomStarred: false,
        zoomTrash: false,
        zoomSettings: false
      }
    }
  },
  mounted() {
    this.accordion()
  },
  methods: {
    toggleShow: function() {
      this.showMore = !this.showMore
    },
    accordion: function (){
      let el = document.getElementsByClassName("accordion");
      let i;
      let mainEl = $('#accordion').addClass('active')
      let pan = $('#panel').css('maxHeight', '380px')

      for (i = 0; i < el.length; i++) {
        el[i].addEventListener("click", function() {
          this.classList.toggle("active");
          let panel = this.nextElementSibling;
          if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
          } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
          }
        });
      }
    }
  }
}
</script>
