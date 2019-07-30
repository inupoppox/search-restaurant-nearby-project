<template>
  <div>
    <b-row class="listing mb-5" v-for="index in 3" :key="index">
      <b-col md="6">
          <vue-content-loading :width="300" :height="250">
            <rect x="0" y="0" rx="3" ry="3" width="300" height="200" />
            <rect x="0" y="210" rx="2" ry="2" width="35" height="30" />
            <rect x="45" y="210" rx="2" ry="2" width="150" height="15" />
            <rect x="45" y="233" rx="2" ry="2" width="100" height="10" />
          </vue-content-loading>
      </b-col>
      <b-col md="6">
          <vue-content-loading :width="300" :height="250">
            <rect x="0" y="0" rx="3" ry="3" width="300" height="200" />
            <rect x="0" y="210" rx="2" ry="2" width="35" height="30" />
            <rect x="45" y="210" rx="2" ry="2" width="150" height="15" />
            <rect x="45" y="233" rx="2" ry="2" width="100" height="10" />
          </vue-content-loading>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import VueContentLoading from 'vue-content-loading'

export default {
  components: {
    VueContentLoading
  }
}
</script>
