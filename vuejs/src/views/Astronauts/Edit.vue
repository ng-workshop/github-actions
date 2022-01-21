<template>
  <div :id="title">
    <loader v-if="astronautIsLoading()" />

    <astronauts-form
        v-if="!astronautIsLoading()"
        :astronaut="getAstronaut()"
        :astronautAvatarPreview="getAstronautAvatarPreview()"
        :astronautAvatarPreviewIsLoading="astronautAvatarPreviewIsLoading()"
        @uploadAvatar="onUploadAvatar"
        @onSubmit="onSubmit"
    />
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import AstronautsForm from '@/components/Astronauts/Form'
import Loader from '@/components/Common/Loader'

export default {
  name: 'ViewAstronautsEdit',
  components: {
    AstronautsForm,
    Loader
  },
  data() {
    return {
      title: 'edit astronaut',
    }
  },
  async created() {
    await this.loadAstronaut(this.$route.params.id)
  },
  methods: {
    ...mapActions({
      loadAstronaut: 'astronaut/LOAD',
      uploadAstronautAvatar: 'astronautsAvatar/UPLOAD',
      saveAstronaut: 'astronaut/SAVE',
    }),
    ...mapGetters({
      getAstronaut: 'astronaut/GET',
      getAstronautAvatarPreview: 'astronautsAvatar/GET_BASE64_ENCODED',
      getAstronautAvatarFilename: 'astronautsAvatar/GET_FILE_NAME',
      astronautAvatarPreviewIsLoading: 'astronautsAvatar/IS_LOADING',
      astronautIsLoading: 'astronaut/IS_LOADING',
      astronautHasErrors: 'astronaut/HAS_ERRORS',
    }),
    onUploadAvatar(file) {
      this.uploadAstronautAvatar(file)
    },
    async onSubmit(astronaut) {
      await this.saveAstronaut({...astronaut, ...{avatar: this.getAstronautAvatarFilename()}})

      if (!this.astronautHasErrors()) {
        await this.$router.push({ name: 'astronauts-list'})
      }
    }
  }
}
</script>
