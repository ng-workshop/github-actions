<template>
  <div>
    <b-row align-h="end">
      <b-col cols="2">
        <b-button :to="{ name: 'astronaut-new' }" variant="primary" class="button-astronaut-new">Create</b-button>
      </b-col>
    </b-row>

    <hr />

    <loader v-if="isLoading()" />

    <astronauts-table v-if="!isLoading() && !hasErrors()" :astronauts="getAstronauts()" />
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

import AstronautsTable from '@/components/Astronauts/Table'
import Loader from '@/components/Common/Loader'

export default {
  name: 'ViewAstronautsList',
  components: {
    AstronautsTable,
    Loader,
  },
  methods: {
    ...mapActions({
      loadAstronauts: 'astronauts/LOAD'
    }),
    ...mapGetters({
      getAstronauts: 'astronauts/GET',
      isLoading: 'loader/IS_LOADING',
      hasErrors: 'error/HAS',
    }),
  },
  async created() {
    await this.loadAstronauts()
  },
}
</script>
