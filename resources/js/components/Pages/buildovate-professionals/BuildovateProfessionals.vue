<script setup>
import { onMounted, ref, watch } from "vue";
import { GoogleMap, Marker, Circle } from "vue3-google-map";
import Slider from "@vueform/slider";
import SpecialtyItems from "@//components/Pages/buildovate-professionals/SpecialtyItems.vue";
import SearchPro from "@/components/Pages/buildovate-professionals/SearchPro.vue";
import Profile from "@/components/Pages/buildovate-professionals/Profile.vue";
import rectangleImg from "@/assets/img/rectangle-5591.svg";
import { useMainStore } from "@/stores/main";

const store = useMainStore();
const props = defineProps(["records"]);

const center = ref({ lat: 14.8010977, lng: 120.8843322 });
const markers = ref([{ position: { lat: 14.8010977, lng: 120.8843322 } }]);
const mile_radius = ref(2);
const min = ref(5);
const max = ref(50);
const isRefresh = ref(false);
const specialties = ref([]);

const circleOptions = ref({
  center: center.value,
  radius: 1609.34 * mile_radius.value, // 1 mile = 1609.34 meters
  strokeColor: "#FF0000",
  strokeOpacity: 0.8,
  strokeWeight: 2,
  fillColor: "#FF0000",
  fillOpacity: 0.35,
});

const setupCircleOptions = () => {
  isRefresh.value = true;
  console.log("center.value", center.value);
  circleOptions.value.center = center.value;
  circleOptions.value.radius = 1609.34 * mile_radius.value;

  setTimeout(() => {
    isRefresh.value = false;
  }, 100);
};

const handleChange = () => {
  console.log("handleChange");

  let checkedCounter = 0;
  let selectedSpecialties = [];
  $(".single-checkbox").each(function () {
    if (this.checked) {
      selectedSpecialties.push(this.value);
      checkedCounter++;
    }
  });
  specialties.value = selectedSpecialties;

  const payload = {
    search: "",
    specialties: specialties.value,
  };

  // console.log("payload", payload);
  store.setSelectedPro(null);
  store.setSearchQuery(payload);
  store.getPros();
};

watch(mile_radius, () => {
  setupCircleOptions();
});

watch(center, () => {
  setupCircleOptions();
});

onMounted(() => {
  store.setSearchQuery(null);
  handleChange();
});
</script>
<template>
  
  <div v-if="store.isMaximize" class="card p-3 m-3">
    <Profile></Profile>
  </div>
  <div v-else class="row m-4">
    <div class="col-md-3">
      <div class="card" style="height: 100vh">
        <div class="d-flex flex-column justify-content-center align p-3">
          <div class="">
            <div class="select-location select inter-medium-jaguar-16px mb-3">Select Location</div>
            <div class="">
              <img v-if="isRefresh" class="rectangle-5591" :src="rectangleImg" alt="Rectangle 5591" />

              <GoogleMap v-else style="width: 100%; height: 200px" mapTypeId="terrain" :center="center" :zoom="12">
                <Marker
                  :options="{ position: center }"
                  :key="index"
                  v-for="(m, index) in markers"
                  :position="m.position"
                  :clickable="true"
                  :draggable="true"
                ></Marker>
                <Circle :options="circleOptions"></Circle>
              </GoogleMap>
              <div class="mt-4 mb-3" style="width: 100%">
                <div class="filter-by-distance inter-medium-jaguar-16px mb-3">Filter By Distance</div>
                <div class="text-right inter-medium-jaguar-14px fw-light">{{ mile_radius }}Miles</div>
                <Slider :min="min" :max="max" v-model="mile_radius" class="slider-blue" style="width: 100%" />
              </div>
            </div>
          </div>
          <div>
            <SpecialtyItems :records="props.records" @checkboxChange="handleChange"></SpecialtyItems>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <SearchPro></SearchPro>
    </div>
  </div>
</template>

<style src="@vueform/slider/themes/default.css"></style>
<style src="@/assets/css/pros.css"></style>
