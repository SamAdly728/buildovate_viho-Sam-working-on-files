<style>
.custom-modal-body-background {
  background: #ececec !important;
}
</style>
<template>
  <div class="p-3">
    <div class="card rounded-3">
      <div class="card-header rounded-3 p-3">
        <h5 class="mb-0">
          <span class="text-muted">Phone Number Management</span>
        </h5>
      </div>
      <hr class="mb-0 mt-0" />
      <div class="card-body p-3">
        <!-- Company Number Start-->
        <div class="mb-5">
          <div class="container-sm">
            <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
              <h6 class="mb-0">
                <span class="text-muted">Company</span>
              </h6>
              <button class="btn btn-primary btn-sm">Manage Phone Numbers</button>
            </div>
            <div class="row rounded-3 shadow-sm">
              <div class="col-6 border-end py-3">
                {{ primaryNumber.number_title }}
              </div>
              <div class="col-4 border-end py-3">
                <i class="fas fa-phone-alt me-3" aria-hidden="true"></i>{{ primaryNumber.company_number }}
              </div>
              <div class="col-2 py-3">
                <div class="dropdown w-100">
                  <button
                    class="btn bg-white dropdown-toggle text-muted"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    style="width: 100% !important"
                  >
                    Actions
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end bg-white">
                    <li>
                      <a class="dropdown-item py-3" href="#"><i class="fa-solid fa-pen me-3"></i>Change Number</a>
                    </li>
                    <li>
                      <a class="dropdown-item py-3" href="#"><i class="fa-solid fa-retweet me-3"></i>Swap Number</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Company Number End-->

        <!-- Team Number Start-->
        <div>
          <div class="container-sm">
            <div class="d-flex flex-row justify-content-between mb-3 align-items-center">
              <h6 class="mb-0">
                <span class="text-muted">Team Inbox</span>
              </h6>
              <button class="btn btn-primary btn-sm">Manage Team Numbers</button>
            </div>
            <div class="row rounded-3 shadow-sm" v-for="(item, index) in teamNumbers" :key="index">
              <div class="col-6 border-end py-3">
                {{ item.number_title }}
              </div>
              <div class="col-4 border-end py-3">
                <i class="fas fa-phone-alt me-3" aria-hidden="true"></i>{{ item.company_number }}
              </div>
              <div class="col-2 py-3">
                <div class="dropdown w-100">
                  <button
                    class="btn bg-white dropdown-toggle text-muted"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    style="width: 100% !important"
                  >
                    Actions
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end bg-white">
                    <li>
                      <a class="dropdown-item py-3" href="#"><i class="fa-solid fa-pen me-3"></i>Change Number</a>
                    </li>
                    <li>
                      <a class="dropdown-item py-3" href="#"><i class="fa-solid fa-retweet me-3"></i>Swap Number</a>
                    </li>
                    <li>
                      <a class="dropdown-item py-3" href="#"><i class="fa-solid fa-arrow-right me-3"></i>Move Number</a>
                    </li>
                    <li>
                      <a class="dropdown-item py-3" href="#"><i class="fa-solid fa-trash-can me-3"></i>Remove Number</a>
                    </li>
                    <li>
                      <a class="dropdown-item py-3" href="#"><i class="fa-solid fa-pen me-3"></i>Edit Label</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Team Number End -->
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["companyNumbers"],

  data() {
    return {
      primaryNumber: "",
      teamNumbers: [],
    };
  },

  mounted() {
    this.primaryNumber = this.companyNumbers.find((number) => number.is_primary === true);

    this.teamNumbers = this.companyNumbers.filter((number) => number.is_primary === false);

    console.log(this.teamNumbers); // proxy (array)
  },
};
</script>
