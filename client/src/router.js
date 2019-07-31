import Vue from 'vue'
import Router from 'vue-router'
import Search from './views/Search.vue'
import Result from './views/Result.vue'
import NotFound from './views/NotFound.vue'
import PlaceDetail from './views/PlaceDetail.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/',
      name: 'search',
      component: Search
    },
    {
      path: '/s/:query/:pid?',
      name: 'result',
      component: Result,
      props: true
    },
    {
      path: '/pd/:id',
      name: 'place-detail',
      component: PlaceDetail,
      props: true
    },
    {
      path: '/404',
      name: 'not-found',
      component: NotFound
    },
    {
      path: '*',
      redirect: '/404'
    }
  ]
})
