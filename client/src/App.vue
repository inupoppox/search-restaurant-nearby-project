<template>
  <div id="app">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row align-items-center p-1 px-md-4 mb-3 bg-white box-shadow fixed-top">
      <h5 class="my-0 mr-md-auto font-weight-bold"><router-link to="/"><mark class="red">SCG Quiz</mark> Search Place</router-link></h5>
    </div>
    <!-- Listing View -->
    <transition name="moveInUp">
      <router-view/>
    </transition>
    <!-- Map View -->
    <div class="map">
      <div class="inside-map map">
        <GmapMap
          ref="mapRef"
          :center="{ lat: 13.1608775, lng: 101.4104333 }"
          :zoom="changingZoom"
          style="width: 100%; height: 100%"
        >
          <template v-if="getMarker">
            <gmap-marker
              :key="index"
              v-for="(m, index) in getMarker"
              :position="{lat: parseFloat(m.position.lat), lng: parseFloat(m.position.lng)}"
              @mouseover="setDetailDisplay(m)"
              @mouseout="statusText = null"
              @click="redirectToPlace(m)"
            ></gmap-marker>
          </template>
          <template v-if="statusText">
            <div slot="visible">
              <div class="detailHover">
                <b-row>
                  <b-col md="2">
                    <img :src="statusImg">
                  </b-col>
                  <b-col md="10">
                    {{ statusText }}<br/><span>{{ statusPlaceDetail }}</span>
                  </b-col>
                </b-row>
              </div>
            </div>
          </template>
        </GmapMap>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data () {
    return {
      statusText: '',
      statusImg: '',
      statusPlaceDetail: '',
      changingZoom: 6
    }
  },
  computed: {
    ...mapGetters([
      'getGeolocation',
      'getMarker'
    ])
  },
  watch: {
    getGeolocation (newValue, oldValue) {
      this.$refs.mapRef.$mapPromise.then((map) => {
        map.panTo(newValue.latLng)
      })
      this.changingZoom = newValue.zoom
    }
  },
  methods: {
    setDetailDisplay: function (data) {
      this.statusText = data.text
      this.statusImg = data.photos === '' ? '/img/no-preview.png' : 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=' + data.photos + '&key=' + process.env.VUE_APP_GMAP_KEY
      this.statusPlaceDetail = data.detail
    },
    redirectToPlace: function (data) {
      this.$router.push('/pd/' + data.id)
    }
  }
}
</script>

<style scoped>
mark.red {
    color:#ff0000;
    background: none;
}
</style>
