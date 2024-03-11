<script setup>
import { ref, watch } from "vue";
const companyLogo = ref(
  "https://buildovate-development.s3.us-west-1.amazonaws.com/ConstructionWorkerAvatar.png"
);

const useful = ref("");
const funny = ref("");
const cool = ref("");

const isUseful = ref(false);
const isFunny = ref(false);
const isCool = ref(false);

watch([isUseful, isFunny, isCool], () => {
  if (isUseful.value) {
    useful.value = "1";
  } else {
    useful.value = "";
  }

  if (isFunny.value) {
    funny.value = "1";
  } else {
    funny.value = "";
  }

  if (isCool.value) {
    cool.value = "1";
  } else {
    cool.value = "";
  }
});
</script>
<template>
  <div class="your-msg">
    <div class="media">
      <img
        class="img-50 img-fluid m-r-20 rounded-circle"
        alt=""
        :src="companyLogo"
      />
      <div class="media-body">
        <span class="f-w-600"
          >Jason Borne
          <span>1 Year Ago <i class="fa fa-reply font-primary"></i></span
        ></span>
        <p><span class="star-rating txt-warning">★★★★★</span>5</p>

        <p>
          we are working for the dance and sing songs. this car is very awesome
          for the youngster. please vote this car and like our post
        </p>
        <div>
          <button
            class="btn btn-square btn-outline-info btn-sm"
            type="button"
            @click="isUseful = !isUseful"
          >
            <i class="icofont icofont-check-circled"></i> Useful
            <span class="ms-1">{{ useful }}</span>
          </button>
          <button
            class="btn btn-square btn-outline-info btn-sm ms-2"
            type="button"
            @click="isFunny = !isFunny"
          >
            <i class="icofont icofont-emo-simple-smile"></i> Funny
            <span class="ms-1">{{ funny }}</span>
          </button>
          <button
            class="btn btn-square btn-outline-info btn-sm ms-2"
            type="button"
            @click="isCool = !isCool"
          >
            <i class="icofont icofont-emo-smirk"></i> Cool
            <span class="ms-1">{{ cool }}</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
