<style>
@keyframes zoomIn {
  from {
    transform: scale(0);
  }
  to {
    transform: scale(1);
  }
}

.modal.fade .modal-dialog {
  animation: zoomIn 0.1s ease-out;
}

table {
  table-layout: fixed;
}

</style>
<style scoped>
.nav-tabs .nav-link.active {
  background-color: #739bd4 !important;
  color: white !important;
}

*::-webkit-scrollbar {
  display: none !important;
}
</style>
<template>
  <!-- Container-fluid starts-->

  <div class="p-3">
    <div class="row">
      <div class="col-sm-12">
        <div class="card rounded">
          <div class="card-header pb-1">
            <div class="card-title mb-4">
              <h2 class="text-dark f-w-600">Users</h2>
            </div>
            <div class="d-flex justify-content-between">
              <div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" :class="{'active' : actTab == 'staff'}" @click="activeTab('staff')" id="staff-tabs" data-bs-toggle="tab" href="#staff" role="tab" aria-controls="staff" aria-selected="false">Staff</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" :class="{'active' : actTab == 'pros'}" @click="activeTab('pros')" id="pros-tab" data-bs-toggle="tab" href="#pros" role="tab" aria-controls="pros" aria-selected="false">Pros</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" :class="{'active' : actTab == 'deleted'}" @click="activeTab('deleted')" id="deleted-tab" data-bs-toggle="tab" href="#deleted" role="tab" aria-controls="deleted" aria-selected="false">Deactivated</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" :class="{'active' : actTab == 'pending'}" @click="activeTab('pending')" id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Pending</a>
                  </li>
                </ul>
              </div>
              <div v-if="showAddButtons">
                <button v-if="selectedTab != 'pros'" type="button" class="btn btn-primary-v2 pull-right m-r-10" data-bs-toggle="modal" data-original-title="Add Staff" data-bs-target="#addCrew" @click="addStaffOrPro('staff')">Add Staff</button>
                <button v-else type="button" class="btn btn-primary-v2 pull-right m-r-10" data-bs-toggle="modal" data-original-title="Add Staff" data-bs-target="#addCrew" @click="addStaffOrPro('pros')">Add Pros</button>
              </div>
            </div>
          </div>
          <div class="tab-content" id="content">
            <div class="tab-pane fade show" :class="{'active' : actTab == 'pros'}" id="pros" role="tabpanel" aria-labelledby="pros-tab">
              <pros :proUsers="prosUsers"></pros>
            </div>
            <div class="tab-pane fade show" :class="{'active' : actTab == 'staff'}" id="staff" role="tabpanel" aria-labelledby="staff-tab">
              <allUser ref="allUser" :users="users" :userPayRate="userPayRate" :roles="roles"></allUser>
            </div>
            <div class="tab-pane fade show" :class="{'active' : actTab == 'deleted'}" id="deleted" role="tabpanel" aria-labelledby="deleted-tab">
              <deleted :deactivatedUsers="deactivatedUsers"></deleted>
            </div>
            <div class="tab-pane fade show" :class="{'active' : actTab == 'pending'}" id="pending" role="tabpanel" aria-labelledby="pending-tab">
              <pending :pendingUsers="pendingUsers"></pending>
            </div>
          </div>
        </div>
      </div>
    </div>

    <addUser :id="'addCrew'" :roles="roles" :isStaffOrPro="isStaffOrPro"></addUser>

  </div>
</template>
<script>
import axios from "axios";
import Swal from "sweetalert2"
import slider from "../../components/user_management/Slider.vue"
import allUser from "../../components/user_management/AllUser.vue"
import pros from "../../components/user_management/Pros.vue"
import deleted from "../../components/user_management/Deleted.vue"
import pending from "../../components/user_management/Pending.vue"
import addUser from "../../components/user_management/add_user/AddUserModal.vue"
import {router} from "@inertiajs/vue3";

export default {
  props: ['users', 'roles', 'prosUsers', 'deactivatedUsers', 'pendingUsers', 'userPayRate'],
  components: {slider, allUser, pros, deleted, pending, addUser},
  data() {
    return {
      roles: this.roles,
      filterUserType: '',
      selectedTab: '',
      showAddButtons: true,
      isStaffOrPro: null,
      actTab: false
    }
  },
  mounted() {
    this.actTab = sessionStorage.getItem('selected-tab')
    // if (this.actTab != 'staff') {
    //   sessionStorage.clear()
    //   sessionStorage.setItem('selected-tab', 'staff')
    // }
  },
  methods: {
    addStaffOrPro(key){
      if (key == 'pros') {
        this.isStaffOrPro = key
      }else{
        this.isStaffOrPro = key
      }
    },
    activeTab(tabKey) {
      this.selectedTab = tabKey
      switch (tabKey) {
        case "staff":
          this.updateSession(tabKey)
          this.showAddButtons = true
          this.$refs.allUser.refreshTable()
          router.reload({only: ['users']})
          break
        case "pros":
          this.updateSession(tabKey)
          this.showAddButtons = true
          this.$refs.allUser.refreshTable()
          router.reload({only: ['prosUsers']})
          break
        case "deleted":
          this.updateSession(tabKey)
          this.showAddButtons = false
          this.$refs.allUser.refreshTable()
          router.reload({only: ['deactivatedUsers']})
          break
        case "pending":
          this.updateSession(tabKey)
          this.showAddButtons = false
          this.$refs.allUser.refreshTable()
          router.reload({only: ['pendingUsers']})
          break
        default:
          this.showAddButtons = true
          this.$refs.allUser.refreshTable()
          break
      }
    },
    updateSession(key) {
      sessionStorage.removeItem('selected-tab')
      sessionStorage.setItem('selected-tab', key)
    }
  }
}
</script>

        