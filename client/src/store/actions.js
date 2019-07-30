import UserProvider from '@/resources/user_provider'
const userService = new UserProvider()

export default {
  // Fetch place detail from backend api
  async fetchData ({ commit }, dataObj) {
    const prepareURL = dataObj.id + '/' + dataObj.lat + '/' + dataObj.lng + '/?page=' + dataObj.pid
    const data = await userService.getUser(prepareURL)
    commit('setPlaceDatabase', data)
    return data
  },
  // Update and store search query
  updateSeachQuery: ({ commit }, placeObj) => {
    commit('updateSeachQuery', placeObj)
  },
  // Update and store map geolocation for display
  updateMapGeolocation: ({ commit }, latLng) => {
    commit('updateMapGeolocation', latLng)
  },
  // Clear the search query for next use
  clearSearchQuery: ({ commit }) => {
    commit('resetState')
  }
}
