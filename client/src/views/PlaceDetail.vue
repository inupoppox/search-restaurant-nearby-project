<template>
  <div class="home">
    <div class="inside-home">
      <!-- Search Section -->
      <div class="single-place">
        <template v-if="!loading">
          <img :src="this.placeDetail.image">
        </template>
        <div class="single-place-title">
          <b-row>
            <b-col md="12" class>
              <b-row>
                <b-col md="1">
                  <template v-if="!loading">
                    <router-link :to=this.prevRoute.path><div class="back-btn"></div></router-link>
                  </template>
                </b-col>
                <b-col md="11">
                  <template v-if="loading">
                    <vue-content-loading :width="300" :height="10">
                      <rect x="0" y="0" rx="4" ry="4" width="100" height="10" />
                    </vue-content-loading>
                  </template>
                  <template v-else>
                    <h4>{{this.placeDetail.placename}}</h4>
                  </template>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
        </div>
      </div>
      <div class="single-place-container">
        <template v-if="loading">
          <VclList></VclList>
        </template>
        <template v-else>
          ที่อยู่: {{this.placeDetail.vicinity}}
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { VueContentLoading, VclList } from 'vue-content-loading'

export default {
  data () {
    return {
      placeDetail: '',
      prevRoute: null,
      loading: false
    }
  },
  components: {
    VclList,
    VueContentLoading
  },
  props: {
    id: {
      required: true
    }
  },
  methods: {
    getData: async function () {
      try {
        this.loading = true
        const endpointURL = process.env.VUE_APP_ROOT_API + 'placedetail/' + this.id
        let res = await this.$http.get(endpointURL)
        if (res.data.result.length > 0) {
          this.loading = false
          this.placeDetail = res.data.result[0]
          this.placeDetail.image = res.data.result[0].photos === '' ? '/img/no-preview.png' : 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=' + res.data.result[0].photos + '&key=' + process.env.VUE_APP_GMAP_KEY
        }
        return (res.data.result[0])
      } catch (error) {
        alert(error.response.data.message) // catches both errors
      }
    },
    ...mapActions([
      'updateMapGeolocation'
    ])
  },
  beforeRouteEnter (to, from, next) {
    next(vm => {
      vm.prevRoute = from
    })
  },
  created () {
    this.getData().then((result) => {
      console.log(result)
      this.updateMapGeolocation({ latLng: { lat: parseFloat(result.lati), lng: parseFloat(result.longi) }, zoom: 19 })
    })
  }
}
</script>
