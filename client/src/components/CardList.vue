<template>
  <router-link :to="'/pd/'+ id">
    <div class="listing-item-container">
      <div class="listing-item">
        <img :src="image" alt="">
        <div class="listing-item-content">
          <h3>{{ name }}</h3>
          <span>{{ vicinity }}</span>
        </div>
        <span class="like-icon"></span>
      </div>
      <div class="star-rating">
        <div class="rating-box">
            <div class="rating" :style="styling"></div>
        </div>
      </div>
    </div>
  </router-link>
</template>

<script>
export default {
  data () {
    var formData = {
      id: this.place.id,
      name: this.place.placename,
      vicinity: this.place.vicinity,
      rating: this.place.rating,
      image: this.place.photos === '' ? '/img/no-preview.png' : 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=' + this.place.photos + '&key=' + process.env.VUE_APP_GMAP_KEY
    }
    return formData
  },
  props: {
    place: {
      type: Object,
      required: true
    }
  },
  computed: {
    styling: function () {
      return {
        width: this.rating * 20 + '%'
      }
    }
  }
}
</script>
