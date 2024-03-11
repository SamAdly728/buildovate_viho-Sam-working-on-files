<template>
    <div class="card b-primary-v2 b-radius-10 shadow-sm mt-3">
      <div class="card-body">
        <!--Make administrator area-->
        <div v-if="isStaffOrPro == 'staff' || !newUser">
          <label class="d-block">
            <input @change="toggleMakeAdmin" class="checkbox_animated" type="checkbox" >Make Administrator
          </label>
          <small class="d-block f-12 text-muted f-w-500 m-l-30">Gives full access to the user.</small>
        </div>
        <!--End make administrator area-->
        <hr v-if="(showPermissionLevels && isStaffOrPro == 'staff') || !newUser">
        <!--Preset area-->
        <transition>
        <div v-if="(showPermissionLevels && isStaffOrPro == 'staff') || !newUser">
          <h5 class="card-title">Preset Permissions levels</h5>
          <small class="f-12 text-muted f-w-500">Start with a preset permission level, and customize further as needed.</small>
          <div class="mt-3">
            <div v-for="r in roles">
              <label class="d-block mt-2" for="edo-ani" >
                <input class="radio_animated" id="edo-ani" type="radio" name="rdo-ani"> {{r.role_display_name}}
              </label>
              <div class="text-wrap m-l-35">
                <small class="f-12 text-muted f-w-500 ">{{r.role_description}}</small>
              </div>
            </div>
          </div>
        </div>
        </transition>
        <!--End preset area-->
        <hr v-if="(showPermissionLevels && isStaffOrPro == 'staff') || !newUser">
        <!--Permission area-->
        <div class="pull-right">
          <button class="btn btn-primary-v2 btn-sm">Save Permissions</button>
        </div>
      </div>
    </div>
</template>
<script>
export default {
  props: ['roles', 'isStaffOrPro', 'newUser'],
  data() {
    return {
      showPermissionLevels: true
    }
  },
  methods: {
    toggleMakeAdmin() {
      this.showPermissionLevels = !this.showPermissionLevels
    }
  },
  mounted() {
  }
}
</script>