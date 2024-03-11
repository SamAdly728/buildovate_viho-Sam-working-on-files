<script setup>
import { useMainStore } from "@/stores/main";
const store = useMainStore();
</script>
<template>
  <div class="d-flex align-items-center">
    <div>
      <img class="rectangle-5646" src="@/assets/img/rectangle-5646@2x.png" alt="Rectangle 5646" />
    </div>
    <div>
      <div class="ms-3">
        <div class="mb-2">
          <img class="rectangle-56 rounded" src="@/assets/img/01.jpg"/>
        </div>
        <div>
          <img class="rectangle-56 rounded" src="@/assets/img/01.jpg"/>
        </div>
      </div>
    </div>
    <div v-if="store.isMaximize">
      <div class="ms-3">
        <div class="mb-2">
          <img class="rectangle-56" src="@/assets/img/01.jpg" alt="Rectangle 5647" />
        </div>
        <div>
          <img class="rectangle-56 rounded" src="@/assets/img/01.jpg"/>
        </div>
      </div>
    </div>
    <div v-if="store.isMaximize">
      <div class="ms-3">
        <div class="mb-2">
          <img class="rectangle-56" src="@/assets/img/01.jpg" alt="Rectangle 5647" />
        </div>
        <div>
          <img class="rectangle-56 rounded" src="@/assets/img/01.jpg"/>
        </div>
      </div>
    </div>
    <div v-if="store.isMaximize">
      <div class="ms-3">
        <div class="mb-2">
          <img class="rectangle-56" src="@/assets/img/01.jpg" alt="Rectangle 5647" />
        </div>
        <div>
          <img class="rectangle-56 rounded" src="@/assets/img/01.jpg"/>
        </div>
      </div>
    </div>
    <div v-if="store.isMaximize">
      <div class="ms-3">
        <div class="mb-2">
          <img class="rectangle-56" src="@/assets/img/01.jpg" alt="Rectangle 5647" />
        </div>
        <div>
          <img class="rectangle-56 rounded" src="@/assets/img/01.jpg"/>
        </div>
      </div>
    </div>
    <div v-if="store.isMaximize">
      <div class="ms-3">
        <div class="mb-2">
          <img class="rectangle-56" src="@/assets/img/01.jpg" alt="Rectangle 5647" />
        </div>
        <div>
          <img class="rectangle-56 rounded" src="@/assets/img/01.jpg"/>
        </div>
      </div>
    </div>

    <div class="ms-5">
      <img class="polygon-2" src="@/assets/img/polygon-2.svg" alt="Polygon 2" />
      <div class="x6-more inter-normal-jaguar-14px mt-5">6 + more</div>
    </div>
  </div>
</template>

<style scoped></style>
