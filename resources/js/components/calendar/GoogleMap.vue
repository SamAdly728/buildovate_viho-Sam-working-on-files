<template>
<!--  <GoogleMap-->
<!--      :center="{ lat: 40.7128, lng: -74.0060 }"-->
<!--      :zoom="12"-->
<!--      :mapTypeId="google.maps.MapTypeId.ROADMAP"-->
<!--      style="width: 100%; height: 100vh;"-->
<!--  >-->
    <GoogleMap
        :center="{ lat: 40.7128, lng: -74.0060 }"
        :zoom="12"
        style="width: 100%; height: 20vh;"
    >
    <Marker
        v-for="(marker, index) in markers"
        :key="index"
        :position="marker.position"
        :clickable="true"
        :draggable="false"
        @click="markerClicked(marker)"
    />
  </GoogleMap>
</template>
<script>
import { GoogleMap, Marker } from 'vue3-google-map'
export default {
  components: {
    GoogleMap,
    Marker
  },
  setup() {
    const markers = [
      { position: { lat: 40.71427, lng: -74.00597 } },
    ];

    function markerClicked(marker) {
      console.log('Marker clicked!', marker);
    }

    return { markers, markerClicked };
  }
};
</script>