<template>
  <div class="home">
    <div class="inside-home">
      <!-- Search Section -->
      <div class="search">
        <b-row>
          <b-col md="12">
            <b-row>
              <b-col md="1">
                <router-link to="/"><div class="back-btn"></div></router-link>
              </b-col>
              <b-col md="6">
                <h4>{{ this.place.name }}</h4>
              </b-col>
            </b-row>
          </b-col>
        </b-row>
      </div>
      <!-- Place Listing -->
      <div class="place-card-listing-container">
        <b-row class="listing">
          <b-col md="6">
            <h6 id="intro-text">ผลการค้นหาทั้งหมด {{getPagination.total_items}} สถานที่รอบๆตัวคุณ</h6>
          </b-col>
        </b-row>
        <template v-if="loading">
          <LoadingCard></LoadingCard>
        </template>
        <template v-else>
          <b-row class="listing">
              <!-- Card Item -->
              <b-col col lg="6" md="12" v-for="p in getAllPlaces" v-bind:key="p.id">
                <CardList :place=p></CardList>
              </b-col>
          </b-row>
        </template>
      </div>
      <div class="mb-4">
        <b-pagination-nav v-model="currentPage" :link-gen="linkGen" :number-of-pages="getPagination.total_page" align="center" use-router></b-pagination-nav>
      </div>
    </div>
  </div>
</template>

<script>
import CardList from '@/components/CardList.vue'
import LoadingCard from '@/components/LoadingCard.vue'
import { mapActions, mapGetters } from 'vuex'

export default {
  components: {
    CardList,
    LoadingCard
  },
  props: {
    query: {
      required: true
    },
    pid: {
      pid: Number,
      required: false
    }
  },
  data () {
    return {
      place: '',
      loading: false,
      currentPage: this.pid === undefined ? 1 : this.pid
    }
  },
  methods: {
    linkGen (pageNum) {
      return pageNum === 1 ? './' : `./${pageNum}`
    },
    ...mapActions([
      'fetchData',
      'updateSeachQuery',
      'updateMapGeolocation',
      'clearSearchQuery'
    ])
  },
  computed: {
    ...mapGetters([
      'getAllPlaces',
      'getPlaceFromSearch',
      'getPagination'
    ])
  },
  mounted: async function () {
    this.loading = true
    // In case user insists on continuing to search for that specific place input
    // This function will find candidate place that match with user's input
    if (this.getPlaceFromSearch.id === undefined) {
      try {
        const findFromTextURL = process.env.VUE_APP_ROOT_API + 'findcand/' + this.query + '/'
        let response = await this.$http.get(findFromTextURL)
        this.place = response.data
      } catch (error) {
        // In case that not found place, we link to 404 page
        this.$router.push('/404')
      }
    // In case user use autocomplete from search place
    // The place detail can use normally
    } else {
      this.place = this.getPlaceFromSearch
    }

    // After we get the place id then, we connect to backend to fetch list of restaurant
    this.place.pid = this.pid === undefined ? 1 : this.pid
    this.updateMapGeolocation({ latLng: { lat: this.place.lat, lng: this.place.lng }, zoom: Math.floor(Math.random() * (17 - 16 + 1) + 16) })
    this.fetchData(this.place).then((result) => {
      this.loading = false
    })

    // After get all done, we need to clear search history for next use
    this.clearSearchQuery()
  },
  watch: {
    currentPage: function (newValue, oldValue) {
      this.loading = true
      const formData = {
        id: this.place.id,
        lat: this.place.lat,
        lng: this.place.lng,
        pid: newValue
      }
      this.fetchData(formData).then((result) => {
        this.loading = false
      })
    }
  }
}
</script>
