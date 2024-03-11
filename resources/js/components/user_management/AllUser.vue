<style>
.slide-from-left-enter-active,
.slide-from-left-leave-active {
  transition: all .1s ease;
  transform: translateX(-100%);
  z-index: 99999;
}

.slide-from-left-enter,
.slide-from-left-leave-to {
  transform: translateX(-100%);
}

.slide-from-left-enter-to,
.slide-from-left-leave {
  transform: translateX(0);
}


.slide-from-right-enter-active,
.slide-from-right-leave-active {
  transform: translateX(100%);
  z-index: 99999;
}

.slide-from-right-enter,
.slide-from-right-leave-to {
  transform: translateX(100%);
}

.slide-from-right-enter-to,
.slide-from-right-leave {
  transform: translateX(0);
}

.top-half {
  position: fixed;
  top: 0;
  left: 0px;
  right: 0;
  z-index: 10;
}

.overlay {
  position: fixed;
  top: 0;
  right: 0;
  width: 50%;
  height: 100%;
  background: rgba(0, 0, 0, 0.1);
  z-index: 10;
}

.align-header-center {
  text-align: center;
}
</style>
<template>
  <div>
    <transition name="slide-from-right">
      <div @click="showSlider = !showSlider" class="overlay" v-if="showSlider"></div>
    </transition>

    <transition name="slide-from-left">
      <div class="top-half" v-if="showSlider">
        <slider @reload-parent="refreshTable" @close-slider="closeSlider" :userData="userData" :roles="roles"></slider>
      </div>
    </transition>
    <div class="table-responsive p-l-30 p-r-30">
      <table class="table">
        <thead>
        <tr>
          <th style="width: 250px" scope="col">Name</th>
          <th scope="col">Joined</th>
          <th scope="col">Branch</th>
          <th class="align-header-center" scope="col">
            User Type
            <select v-model="filterUserType" @change="refreshTable" class="rounded" name="" id="" style="padding: 3px">
              <option value="">All</option>
              <option v-for="r in roles" :key="r.id" :value="r.id">{{ r.role_display_name }}</option>
            </select>
          </th>
          <th class="align-header-center" scope="col">Account Status</th>
          <th scope="col">Last Activity</th>
          <th scope="col">Mobile App Download</th>
          <th class="align-header-center" width="80"scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="u in userList.data" :key="u.user_id">
          <td>{{ u.display_name }}<br><span class="text-primary">{{ u.email }}<br>{{ u.phone }}</span></td>
          <td>{{formatDateValue(u.created_on)}}</td>
          <td></td>
          <td align="middle">{{ u.role_display_name }}</td>
          <td align="middle"><small v-html="getAccountStatus(u.account_status)"></small></td>
          <td>{{formatDateValue(u.last_logged_in)}}</td>
          <td></td>
          <td align="middle">
            <a @click="toggleSlider(u)" href="#" class="btn btn-xs btn-primary-v2">...
              <div style="position: absolute; margin-left: -25px" v-if="showOption && showOptionKey == u.user_id">
                <div class="bg-white easycreate-dropdown shadow-lg d-flex flex-column">
                          <span class="text-dark f-14 f-w-600 px-3 py-2 d-flex gap-3 bg-hover-primary-primary align-items-center" style="cursor: pointer;">
                            <i class="icofont icofont-exclamation-circle h5" style="color: #1E5BB2"></i>
                            <div class="d-flex flex-column">
                              <a class="text-muted f-12">Click to expand action...</a>
                            </div>
                          </span>
                </div>
              </div>
            </a>
          </td>
        </tr>
        </tbody>
      </table>
      <Paging v-if="users.data.length>0" :data="users" :search="search" :params="params" />
    </div>
  </div>
</template>
<script>
import axios from "axios";
import Paging from "../../components/Paging.vue"
import slider from "../../components/user_management/Slider.vue"
import {router} from "@inertiajs/vue3";

export default {
  props: ['users', 'roles'],
  components: {Paging, slider},
  data() {
    return {
      userList: [],
      search: '',
      params: '',
      filterUserType: '',
      showOption: false,
      showOptionKey: null,
      showSlider: false,
      userData: null
    }
  },
  mounted() {
    this.userList = this.users
  },
  methods: {
    closeSlider(val) {
      this.showSlider = val
    },
    refreshTable(event) {
      if (event){
        this.filterUserType = event.target.value
      }
      axios.post('/company/users/get-all', {role_id: this.filterUserType})
          .then((res) => {
            if (res.data.users) {
              this.userList = res.data.users;
            }
          })
          .catch((error) => {
            console.log(error.message);
          });
    },
    toggleSlider(e) {
      this.showOption = false
      this.showSlider = !this.showSlider
      this.userData = e
    },
    toggleOption(option, key) {
      alert('test')
      this.showOption = option
      this.showOptionKey = key
    },
    getAccountStatus(n) {
      let d = '';
      let clas = '';
      switch (n) {
        case 0:
          d = "Deleted/Inactive";
          clas = "danger";
          break;
        case 1:
          d = "Active";
          clas = "success";
          break;
        case 2:
          d = "Not Validated";
          clas = "warning";
          break;
      }
      return '<span class="badge badge-' + clas + '">' + d + '</span>';
    },
    formatDateValue(date) {

      if (date === "0000-00-00 00:00:00") {
        return "---- -- --";
      }

      let newDate = new Date(date);
      const months = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec"
      ];
      const month = months[newDate.getMonth()];
      const day = newDate.getDate();
      const year = newDate.getFullYear();
      let hours = newDate.getHours();
      const minutes = newDate.getMinutes();
      const ampm = hours >= 12 ? "PM" : "AM";
      hours = hours % 12;
      hours = hours ? hours : 12;
      const minutesStr = minutes < 10 ? "0" + minutes : minutes;
      return `${month} ${day}, ${year}, ${hours}:${minutesStr} ${ampm}`;
    }
  }
}
</script>