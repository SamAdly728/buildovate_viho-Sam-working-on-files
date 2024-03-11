<script setup>
import Professionals from "@/components/Pages/buildovate-professionals/Professionals.vue";
</script>
<template>
  <Transition>
    <div class="card p-4">
      <div class="">
        <input
          type="text"
          class="search-for-pro inter-normal-fun-blue-14px-2 form-control"
          placeholder="Search for pro"
          style="border: none; width: 100%; background-color: #f4f8ff; border-radius: 6px; padding: 10px"
        />
      </div>

      <div class="d-flex items-align-center mt-3">
        <div class="saved-searches inter-medium-trout-16px">Saved Searches:</div>
        <div class="inter-normal-fun-blue-14px ms-2">exterior home</div>
        <div class="inter-normal-fun-blue-14px">flooring</div>
      </div>

      <div class="frame-1000009603 mt-3">
        <div class="professionals-you-might-like inter-medium-jaguar-18px">Professionals you might like</div>
      </div>

      <ul class="nav nav-tabs border-tab mt-4 overflow-auto" id="top-tab" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link active inter-medium-fun-blue-16px"
            id="top-home-tab"
            data-bs-toggle="tab"
            href="#top-home"
            role="tab"
            aria-controls="top-home"
            aria-selected="true"
            style="color: rgb(172, 168, 168); padding-left: 1px; padding-right: 2px"
            >My Feed</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link segoeui-normal-tuna-16px"
            id="profile-top-tab"
            data-bs-toggle="tab"
            href="#top-profile"
            role="tab"
            aria-controls="top-profile"
            aria-selected="false"
            style="color: rgb(172, 168, 168)"
            >Best Matches</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link segoeui-normal-tuna-16px"
            id="contact-top-tab"
            data-bs-toggle="tab"
            href="#top-contact"
            role="tab"
            aria-controls="top-contact"
            aria-selected="false"
            style="color: rgb(172, 168, 168)"
            >Most Recent</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link segoeui-normal-tuna-16px"
            id="favorite-top-tab"
            data-bs-toggle="tab"
            href="#top-favorite"
            role="tab"
            aria-controls="top-favorite"
            aria-selected="false"
            style="color: rgb(172, 168, 168)"
            >Favorite (0)</a
          >
        </li>
      </ul>
      <div class="tab-content" id="top-tabContent">
        <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
          <Professionals></Professionals>
        </div>
        <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
          Best matches content
        </div>
        <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
          Most recent content
        </div>
        <div class="tab-pane fade" id="top-favorite" role="tabpanel" aria-labelledby="favorite-top-tab">
          Favorite content
        </div>
      </div>
    </div>
  </Transition>
</template>
