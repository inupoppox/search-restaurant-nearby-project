export default {
  getAllPlaces: function (state) {
    if (!state.placeDatabase) {
      console.log('API does not fetch yet.')
    } else {
      return state.placeDatabase._embedded.result
    }
  },
  getPlaceFromSearch: function (state) {
    return state.placeFromSearch
  },
  getPagination: function (state) {
    let paginator = {
      total_items: state.placeDatabase._total_items,
      total_page: state.placeDatabase._page_count
    }
    return paginator
  },
  getGeolocation: function (state) {
    return state.mapGeolocation
  },
  getMarker: function (state) {
    if (!state.placeDatabase) {
      console.log('API does not fetch yet.')
    } else {
      let markerArr = []
      const placeDataset = state.placeDatabase._embedded.result
      placeDataset.forEach(
        function (value) {
          let eachPlace = {
            id: value.id,
            photos: value.photos,
            text: value.placename,
            detail: value.vicinity,
            position: {
              lat: value.lati,
              lng: value.longi
            }
          }
          markerArr.push(eachPlace)
        }
      )
      return markerArr
    }
  }
}
