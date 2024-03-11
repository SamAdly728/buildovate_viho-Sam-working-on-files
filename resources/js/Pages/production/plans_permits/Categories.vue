<template>

  <div class="row">

    <div class="col-sm-6 col-xl-4 col-lg-6">
      <Link preserve-scroll href="/production/plans-and-permits/site-plan">
      <div class="card browser-widget">
        <div class="media card-body bg-success">
          <div class="media-img"><img src="https://dev2.buildovate.io/assets/images/dashboard/chrome.png" alt=""></div>
          <div class="p20 text-center" style="padding: 22px 0px 0px 17px;">
              <h4>Site Plan</h4>
          </div>
        </div>
      </div>
      </Link>
    </div>

    <div class="col-sm-6 col-xl-4 col-lg-6">
      <Link preserve-scroll href="/production/plans-and-permits/engineering-plan">
      <div class="card browser-widget">
        <div class="media card-body bg-success">
          <div class="media-img"><img src="https://dev2.buildovate.io/assets/images/dashboard/folder.png" alt=""></div>
          <div class="p20 text-center" style="padding: 22px 0px 0px 17px;">
              <h4>Engineering Plan</h4>
          </div>
        </div>
      </div>
      </Link>
    </div>

    <div class="col-sm-6 col-xl-4 col-lg-6">
      <Link preserve-scroll href="/production/plans-and-permits/permit-services">
      <div class="card browser-widget">
        <div class="media card-body bg-success">
          <div class="media-img"><img src="https://dev2.buildovate.io/assets/images/dashboard/folder1.png" alt=""></div>
          <div class="p20 text-center" style="padding: 22px 0px 0px 17px;">
              <h4>Permit Services</h4>
          </div>
        </div>
      </div>
      </Link>
    </div>

  </div>

</template>

<script setup>
import { Link } from "@inertiajs/vue3";

</script>

