<template>
  <div class="home">
    <div class="inside-home">
      <!-- Search Section -->
      <div class="search">
        <b-row>
          <b-col md="12">
            <b-col md="6">
              <h5 id="intro-text">วันนี้กินข้าวเที่ยงที่ไหนดีน้า?</h5>
            </b-col>
            <GmapAutocomplete
              placeholder="ค้นหาร้านอาหารบริเวณรอบ"
              @place_changed="usePlace"
            >
            </GmapAutocomplete>
          </b-col>
        </b-row>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  methods: {
    usePlace: function (place) {
      if (place.formatted_address) {
        const placeDetail = {
          id: place.id,
          lat: place.geometry.location.lat(),
          lng: place.geometry.location.lng(),
          name: place.name
        }
        // We need to update state updateSeachQuery
        // for place id to be used for fetch API in Result.vue component later
        this.updateSeachQuery(placeDetail)
        this.$router.push('/s/' + place.name + '/')
      } else {
        // In case that the user does not use autocomplete function
        // and insists on continuing to search for that place input
        this.$router.push('/s/' + place.name + '/')
      }
    },
    ...mapActions([
      'updateSeachQuery'
    ])
  }
}
</script>
