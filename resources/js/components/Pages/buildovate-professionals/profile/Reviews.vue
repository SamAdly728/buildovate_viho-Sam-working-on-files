<script setup>
import { useMainStore } from "@/stores/main";
const store = useMainStore();
</script>
<template>
  <div class="overlap-group-2">
    <input type="text" style="background: transparent; border: none; width: 100%" placeholder="Share your thoughts" />
    <div class="buttons">
      <img class="mdiface-outline" src="@/assets/img/mdi-face-outline-1.svg" alt="mdi:face-outline" />
      <img class="lucidecamera" src="@/assets/img/lucide-camera-1.svg" alt="lucide:camera" />
      <div class="button-1"><div class="show-more button-s">Submit</div></div>
    </div>
  </div>

  <div class="row align-items-center mt-3">
    <div class="col inter-medium-jaguar-16px">All Reviews</div>
    <div class="col">
      <select
        class="form-control"
        style="
          font-size: 16px;
          font-weight: 400;
          height: 57px;
          letter-spacing: 0;
          line-height: 26px;
          position: relative;
          white-space: nowrap;
          /* width: 182px; */
          border: #32323214 solid 1px;
          color: #141718;
        "
      >
        <option value="">Newest</option>
      </select>
    </div>
  </div>

  <div class="social-chat">
    <div class="your-msg">
      <div class="media">
        <img
          class="img-50 img-fluid m-r-20 rounded-circle"
          alt=""
          src="@/assets/img/avatar-placeholder-1@2x.png"
        />
        <div class="media-body">
          <span class="f-w-600"
            >Jason Borne <span>1 Year Ago <i class="fa fa-reply font-primary"></i></span
          ></span>
          <p>
            we are working for the dance and sing songs. this car is very awesome for the youngster. please vote this
            car and like our post
          </p>
        </div>
      </div>
    </div>
    <div class="your-msg">
      <div class="media">
        <img
          class="img-50 img-fluid m-r-20 rounded-circle"
          alt=""
          src="@/assets/img/avatar-placeholder-2@2x.png"
        />
        <div class="media-body">
          <span class="f-w-600"
            >Kristin Watson <span>1 Year Ago <i class="fa fa-reply font-primary"></i></span
          ></span>
          <p>
            we are working for the dance and sing songs. this car is very awesome for the youngster. please vote this
            car and like our post
          </p>
        </div>
      </div>
    </div>

    <div class="your-msg">
      <div class="media">
        <img
          class="img-50 img-fluid m-r-20 rounded-circle"
          alt=""
          src="@/assets/img/avatar-placeholder@2x.png"
        />
        <div class="media-body">
          <span class="f-w-600"
            >Diane Lane <span>1 Year Ago <i class="fa fa-reply font-primary"></i></span
          ></span>
          <p>
            we are working for the dance and sing songs. this car is very awesome for the youngster. please vote this
            car and like our post
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
