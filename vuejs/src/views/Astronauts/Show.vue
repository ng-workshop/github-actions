<template>
  <div :id="title">
    <loader v-if="isLoading()" />

    <astronauts-show v-if="!isLoading()" :astronaut="getAstronaut()"/>
  </div>
</template>

<script>
import {mapActions, mapGetters, mapMutations } from 'vuex';

import AstronautsShow from '@/components/Astronauts/Show'
import Loader from '@/components/Loader'

export default {
  name: 'ViewAstronautsShow',
  components: {
    AstronautsShow,
    Loader,
  },
  data() {
    return {
      title: 'Astronaut',
    }
  },
  destroyed() {
    this.clear()
  },
  methods: {
    ...mapActions({
      loadAstronaut: 'astronaut/LOAD',
    }),
    ...mapGetters({
      getAstronaut: 'astronaut/GET',
      isLoading: 'astronaut/IS_LOADING',
      hasErrors: 'astronaut/HAS_ERRORS',
      getErrors: 'astronaut/GET_ERRORS',
    }),
    ...mapMutations({
      clear: 'astronaut/CLEAR',
    }),
  },
  async created() {
    await this.loadAstronaut(this.$route.params.id)
  },
}
</script>
