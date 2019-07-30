import Vue from 'vue'

export default {
  setPlaceDatabase (state, data) {
    Vue.set(state, 'placeDatabase', data)
  },
  updateSeachQuery: (state, placeObj) => {
    state.placeFromSearch = placeObj
  },
  updateMapGeolocation: (state, latLng) => {
    state.mapGeolocation = latLng
  },
  resetState: (state) => {
    state.placeFromSearch = ''
  }
}
