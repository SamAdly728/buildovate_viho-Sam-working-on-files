<script setup>
import { computed, onMounted, ref } from "vue";
import { useMainStore } from "@/stores/main";

import tempImg from "@/assets/img/rectangle-5641.svg";
import tempImg2 from "@/assets/img/rectangle-5641-1.svg";
import tempImg3 from "@/assets/img/rectangle-5641-2.svg";
import heartImg from "@/assets/img/interface---heart-02.svg";
import wavyCheck from "@/assets/img/warning---wavy-check.svg";

const store = useMainStore();
const isFavorite = ref(false);

const images = ref([tempImg, tempImg2, tempImg3]);
const bgImg = ref("");

const props = defineProps(["item"]);
const tempProfileImg = ref("https://buildovate-development.s3.us-west-1.amazonaws.com/ConstructionWorkerAvatar.png");

const getCompanyImage = computed(() => {
  return {
    backgroundImage: `url(${bgImg.value})`,
  };
});

const chooseRandomImg = () => {
  const randomIndex = Math.floor(Math.random() * images.value.length); // Generate a random index
  return images.value[randomIndex]; // Return the word at the random index
};

const profile_image = computed(() => {
  return props.item.profile_image
    ? `https://buildovate-development.s3.us-west-1.amazonaws.com/${props.item.profile_image}`
    : tempProfileImg.value;
});

const handleOpen = () => {
  store.setSelectedPro(props.item);
  store.maximizeProfile(false);
  store.minimizeProfile(true);

  store.setRightPanel(true);
  store.setMessage("This is a test message");
};

const handleFavorite = () => {
  isFavorite.value = !isFavorite.value;
};

onMounted(() => {
  
  bgImg.value = chooseRandomImg();
});
</script>
<template>
  <div class="card professional-card" @click="handleOpen">
    <div class="company-image" :style="getCompanyImage">
      <a v-if="isFavorite" href="#" @click.prevent="handleFavorite"
        ><i class="icofont icofont-heart-alt interface-heart_02 text-danger" style="font-size: 20px"></i
      ></a>

      <img v-else class="interface-heart_02" :src="heartImg" alt="Favorite" @click.prevent="handleFavorite" />
    </div>
    <div class="d-flex">
      <div>
        <img class="rectangle-img rounded" :src="profile_image" alt="Rectangle 5638" data-v-a371ae08="" />
      </div>
      <div class="ms-2">
        <div class="d-flex item-align-center">
          <div class="pros-name">{{ props.item.firstname }} {{ props.item.lastname }}</div>
          <img class="warning-wavy_-check" :src="wavyCheck" alt="Warning / Wavy_Check" />
        </div>

        <div class="rating-star">
          ★★★★★
          <span class="text-muted">(27)</span>
        </div>
      </div>
    </div>
    <div class="specialties-12 inter-normal-jaguar-16px">Specialties</div>
    <div style="height: 50px; overflow-y: scroll">
      <div class="frame-100000958">
        <div class="frame-1000009545" v-for="(tag, index) in props.item.tags" :key="index">
          <div class="inter-normal-trout-8px">
            {{ tag }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
