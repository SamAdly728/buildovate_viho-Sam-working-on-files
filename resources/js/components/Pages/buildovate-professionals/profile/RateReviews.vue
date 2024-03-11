<script setup>
import { useMainStore } from "@/stores/main";
const store = useMainStore();
</script>
<template>
  <div class="row" :class="store.isMaximize ? 'w-50' : ''">
    <div class="col">
      <p class="rating-and-reviews-a">Rating and reviews are verified and are from people who use the service</p>
      <div class="d-flex align-items-center" style="font-size: 12px">
        <div class="d-flex align-items-center">
          <div style="width: 10px; display: block">5</div>
          <div class="rating-star2">★</div>
        </div>
        <div class="ms-2" style="width: 200px">
          <div class="progress" style="height: 10px">
            <div
              class="progress-bar bg-blue"
              role="progressbar"
              style="width: 75%"
              aria-valuenow="75"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div>
        </div>
        <div class="ms-2">(91)</div>
      </div>

      <div class="d-flex align-items-center" style="font-size: 12px">
        <div class="d-flex align-items-center">
          <div style="width: 10px; display: block">4</div>
          <div class="rating-star2">★</div>
        </div>
        <div class="ms-2" style="width: 200px">
          <div class="progress" style="height: 10px">
            <div
              class="progress-bar bg-blue"
              role="progressbar"
              style="width: 59%"
              aria-valuenow="50"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div>
        </div>
        <div class="ms-2">(50)</div>
      </div>

      <div class="d-flex align-items-center" style="font-size: 12px">
        <div class="d-flex align-items-center">
          <div style="width: 10px; display: block">3</div>
          <div class="rating-star2">★</div>
        </div>
        <div class="ms-2" style="width: 200px">
          <div class="progress" style="height: 10px">
            <div
              class="progress-bar bg-blue"
              role="progressbar"
              style="width: 30%"
              aria-valuenow="30"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div>
        </div>
        <div class="ms-2">(20)</div>
      </div>

      <div class="d-flex align-items-center" style="font-size: 12px">
        <div class="d-flex align-items-center">
          <div style="width: 10px; display: block">2</div>
          <div class="rating-star2">★</div>
        </div>
        <div class="ms-2" style="width: 200px">
          <div class="progress" style="height: 10px">
            <div
              class="progress-bar bg-allo"
              role="progressbar"
              aria-valuenow="0"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div>
        </div>
        <div class="ms-2">(0)</div>
      </div>

      <div class="d-flex align-items-center" style="font-size: 12px">
        <div class="d-flex align-items-center">
          <div style="width: 10px; display: block">1</div>
          <div class="rating-star2">★</div>
        </div>
        <div class="ms-2" style="width: 200px">
          <div class="progress" style="height: 10px">
            <div
              class="progress-bar bg-allo"
              role="progressbar"
              aria-valuenow="0-"
              aria-valuemin="0"
              aria-valuemax="0"
            ></div>
          </div>
        </div>
        <div class="ms-2">(0)</div>
      </div>
    </div>
    <div class="col">
      <div class="d-flex justify-content-end" style="margin-right: 26px">
        <div class="rating-star2 mt-1">
          ★★★★★
          <span class="text-muted">5</span>
        </div>
      </div>

      <div class="inter-medium-jaguar-14px">Rating Breakdown</div>
      <div class="row mt-1">
        <div class="col-md-9 inter-normal-bombay-14px">Seller Communication level</div>
        <div class="col">
          <div class="rating-star2">
            ★
            <span class="text-muted">5</span>
          </div>
        </div>
      </div>
      <div class="row mt-1">
        <div class="col-md-9 inter-normal-bombay-14px">Recommend to a friend</div>
        <div class="col">
          <div class="rating-star2">
            ★
            <span class="text-muted">5</span>
          </div>
        </div>
      </div>
      <div class="row mt-1">
        <div class="col-md-9 inter-normal-bombay-14px">Service as described</div>
        <div class="col">
          <div class="rating-star2">
            ★
            <span class="text-muted">5</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
