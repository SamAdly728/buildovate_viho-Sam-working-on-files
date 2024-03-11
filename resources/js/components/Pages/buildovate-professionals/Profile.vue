<script setup>
import { onMounted, ref } from "vue";
import { useMainStore } from "@/stores/main";
import Specialties from "@/components/Pages/buildovate-professionals/profile/Specialties.vue";
import PhotosVideos from "@/components/Pages/buildovate-professionals/profile/PhotosVideos.vue";
import RateReviews from "@/components/Pages/buildovate-professionals/profile/RateReviews.vue";
import Reviews from "@/components/Pages/buildovate-professionals/profile/Reviews.vue";

import tempImg from "@/assets/img/rectangle-5641.png";
import heartIcon from "@/assets/img/x-close-2.svg";
import maximizeIcon from "@/assets/img/x-close-1.svg";
import miniimizeIcon from "@/assets/img/x-close-1-1.svg";
import closeIcon from "@/assets/img/x-close.svg";
import houseIcon from "@/assets/img/navigation---house-01-1.svg";
import phoneIcon from "@/assets/img/communication---phone-1.svg";
import wavyCheck from "@/assets/img/warning---wavy-check.svg";
import { computed } from "vue";

const store = useMainStore();

const tempProfileImg = ref("https://buildovate-development.s3.us-west-1.amazonaws.com/ConstructionWorkerAvatar.png");

const getCompanyImage = computed(() => {
  return {
    backgroundImage: `url(${tempImg})`,
  };
});

const getMargin = computed(() => {
  return {
    backgroundImage: `url(${tempImg})`,
  };
});

const handleMaximize = () => {
  store.minimizeProfile(false);
  store.maximizeProfile(true);
  store.setRightPanel(false);
};

const handleMinimize = () => {
  store.maximizeProfile(false);
  store.minimizeProfile(true);
  store.setRightPanel(true);
};

const handleClose = () => {
  store.minimizeProfile(false);
  store.maximizeProfile(false);
  store.setRightPanel(false);
};
</script>
<template>
  <!-- {{ store.selectedPro }} -->
  <div class="p-5" v-if="store.isMinimize">
    <div class="row -mt-30px">
      <div class="col-10">
        <div class="d-flex justify-content-center">
          <img class="rectangle-5641" src="@/assets/img/rectangle-5641-1.svg" alt="Rectangle 5641" />
        </div>
      </div>
      <div class="col d-flex justify-content-between mt-2">
        <img :src="heartIcon" alt="x-close" class="x" />
        <img :src="maximizeIcon" alt="x-close" class="x" @click="handleMaximize" />
        <img :src="closeIcon" alt="x-close" class="x" @click="handleClose" />
      </div>
    </div>
  </div>
  <div v-if="store.isMaximize">
    <div class="company-image d-flex justify-content-end" :style="getCompanyImage" style="width: 100%; height: 220px">
      <div class="m-2">
        <img :src="heartIcon" alt="x-close" class="x" style="height: 32px" />
        <img :src="miniimizeIcon" alt="x-close" class="x ms-2" @click="handleMinimize" style="height: 32px" />
        <img :src="closeIcon" alt="x-close" class="x ms-2" @click="handleClose" style="height: 32px" />
      </div>
    </div>
  </div>

  <div class="p-4">
    <!-- Basic Info -->

    <div class="d-flex">
      <div>
        <img
          :src="tempProfileImg"
          class="profile-image"
          :class="store.isMinimize ? 'profile-image-min' : 'profile-iamge-max'"
        />
      </div>
      <div class="row justify-content-between" :class="store.isMinimize ? 'mt-3' : ''" style="width: 100%">
        <div class="col-md-7 ml-md-auto">
          <div class="ms-3">
            <div class="d-flex item-align-center">
              <div
                class="mooki-mezdayen"
                :class="store.isMinimize ? 'inter-medium-jaguar-20px' : 'inter-medium-jaguar-24px'"
              >
                {{ store.selectedPro?.firstname }} {{ store.selectedPro?.lastname }}
              </div>
              <img class="warning-wavy_-check" :src="wavyCheck" alt="Warning / Wavy_Check" />
            </div>

            <div class="mt-2" :class="store.isMinimize ? 'rating-star' : 'rating-star-12px'">
              ★★★★★
              <span class="text-muted">(27)</span>
            </div>

            <div class="d-flex align-items-center mt-2">
              <div>
                <img class="navigation-house_01" :src="houseIcon" />
              </div>
              <div class="ms-2" :class="store.isMinimize ? 'inter-normal-trout-10px' : 'inter-normal-trout-14px'">
                {{ store.selectedPro?.city }} {{ store.selectedPro?.state }} {{ store.selectedPro?.zipcode }}
              </div>

              <div v-if="store.isMaximize" class="ms-2 d-flex align-items-center">
                <div>
                  <img class="communication-phone" :src="phoneIcon" alt="Communication / Phone" />
                </div>
                <div class="ms-2" :class="store.isMinimize ? 'inter-normal-trout-10px' : 'inter-normal-trout-14px'">
                  {{ store.selectedPro?.business_phone }} {{ store.selectedPro?.cell_phone }}
                </div>
                <span class="ms-3" style="font-size: 15px">
                  <i class="icofont icofont-brand-linkedin"></i>
                  <i class="icofont icofont-social-facebook ms-2"></i>
                  <i class="icofont icofont-social-twitter ms-2"></i>
                </span>
              </div>
            </div>

            <div v-if="store.isMinimize" class="d-flex align-items-center">
              <div>
                <img class="communication-phone" :src="phoneIcon" alt="Communication / Phone" />
              </div>
              <div class="ms-2" :class="store.isMinimize ? 'inter-normal-trout-10px' : 'inter-normal-trout-14px'">
                {{ store.selectedPro?.business_phone }} {{ store.selectedPro?.cell_phone }}
              </div>
              <span class="ms-3" style="font-size: 15px">
                <i class="icofont icofont-brand-linkedin"></i>
                <i class="icofont icofont-social-facebook ms-2"></i>
                <i class="icofont icofont-social-twitter ms-2"></i>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-5 ml-md-auto text-right">
          <div class="flex">
            <div class="d-flex align-items-center justify-content-end mb-3">
              <div class="frame-1000009705">
                <img class="frame-1000009706" src="@/assets/img/frame-1000009706-1.svg" alt="Frame 1000009706" />
                <div class="contactor inter-normal-jaguar-12px">Contactor</div>
              </div>
              <div class="frame-1000009706-1 ms-2">
                <div class="recommended-by inter-normal-trout-12px">Recommended by</div>
              </div>
            </div>

            <button class="btn btn-squart btn-blue"><i class="icofont icofont-plus"></i> Add to Project</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Specialties -->
    <div class="inter-medium-jaguar-20px mb-3">Specialties</div>
    <Specialties></Specialties>

    <!-- Latest Photoes & Videos -->
    <div class="inter-medium-jaguar-16px mt-3 mb-3">Latest Photos & Videos</div>

    <PhotosVideos></PhotosVideos>

    <!-- Rates -->
    <div class="inter-medium-jaguar-16px mt-3 mb-3">Rates Reviews</div>
    <RateReviews></RateReviews>

    <!-- Reviews -->
    <div class="inter-medium-mine-shaft-24px mt-3">Reviews</div>
    <Reviews></Reviews>
  </div>
</template>

<style scoped></style>
