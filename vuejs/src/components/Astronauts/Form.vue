<template>
  <b-row>
    <b-col cols="8" offset="2">
      <validation-observer ref="observer" v-slot="{ handleSubmit, invalid }">
        <b-form @submit.stop.prevent="handleSubmit(onSubmit)">
          <validation-provider name="username" :rules="{ required: true, min: 5, max: 50 }" v-slot="validationContext">
            <b-form-group
                id="input-group-text-astronaut-username"
                label="Username :"
                label-for="input-test-astronaut-username"
                label-cols="2"
            >
              <b-form-input
                  id="input-test-astronaut-username"
                  name="input-test-astronaut-username"
                  v-model="astronautInput.username"
                  aria-describedby="input-text-feedback-astronaut-username"
                  placeholder="Enter astronaut username"
                  :state="getValidationState(validationContext)"
                  type="text"
                  required
              />

              <b-form-invalid-feedback id="input-text-feedback-astronaut-username">
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <validation-provider name="planet" rules="required|planetChoice" v-slot="validationContext" >
            <b-form-group
                id="input-group-select-astronaut-planet"
                label="Planet :"
                label-for="input-select-astronaut-planet"
                label-cols="2"
            >
              <b-form-select
                  id="input-select-astronaut-planet"
                  name="input-select-astronaut-planet"
                  v-model="astronautInput.planet"
                  :options="planetsOptions"
                  aria-describedby="input-text-feedback-astronaut-planet"
                  :state="getValidationState(validationContext)"
                  required
              />
            </b-form-group>

            <b-form-invalid-feedback id="input-text-feedback-astronaut-planet" force-show>
              {{ validationContext.errors[0] }}
            </b-form-invalid-feedback>
          </validation-provider>

          <validation-provider name="email" rules="required|email" v-slot="validationContext">
            <b-form-group
                id="input-group-email-astronaut-email"
                label="Email: "
                label-for="input-email-astronaut-email"
                label-cols="2"
            >
              <b-form-input
                  id="input-email-astronaut-email"
                  name="input-email-astronaut-email"
                  v-model="astronautInput.email"
                  aria-describedby="input-email-feedback-astronaut-email"
                  placeholder="Enter astronaut email"
                  :state="getValidationState(validationContext)"
                  type="email"
                  required
              />

              <b-form-invalid-feedback id="input-email-feedback-astronaut-email">
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <validation-provider
              name="avatar"
              rules="required|image|ext:jpg,jpeg,png|mimes:image/*|size:150|imageMinWith|imageMaxWith|imageMinHeight|imageMaxHeight"
              v-slot="validationContext"
          >
            <b-form-group
                id="input-group-file-astronaut-avatar"
                label="Avatar: "
                label-for="input-file-astronaut-avatar"
                label-cols="2"
            >
              <b-form-file
                  id="input-file-astronaut-avatar"
                  name="input-file-astronaut-avatar"
                  v-model="astronautInput.avatar"
                  :value="astronautInput.avatar"
                  aria-describedby="input-file-feedback-astronaut-avatar"
                  placeholder="Chose an astronaut avatar or drop it here..."
                  drop-placeholder="Drop file here..."
                  :state="getValidationState(validationContext)"
                  accept="image/*"
                  @input="$emit('uploadAvatar', astronautInput.avatar)"
                  required
              />

              <b-form-invalid-feedback id="input-file-feedback-astronaut-avatar">
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>

              <div
                  class="image-preview"
                  v-if="astronautAvatarPreview || astronautAvatarPreviewIsLoading || astronaut.avatar"
              >
                <loader v-if="astronautAvatarPreviewIsLoading" />
                <b-img
                    v-if="!astronautAvatarPreviewIsLoading"
                    :src="astronautAvatarPreview || astronaut.avatar"
                    alt="Temporary astronaut avatar"
                    thumbnail
                    fluid
                />
              </div>
            </b-form-group>
          </validation-provider>

          <br />
          <hr />
          <br />

          <b-row>
            <b-col cols="1" offset="9">
              <b-button type="submit" variant="primary" :disabled="invalid">Submit</b-button>
            </b-col>
            <b-col cols="1" offset="1">
              <b-button type="reset" variant="danger" @click.prevent="onReset">Reset</b-button>
            </b-col>
          </b-row>
        </b-form>
      </validation-observer>
    </b-col>
  </b-row>
</template>

<script>
import Astronaut from '@/props/astronaut'
import Loader from '@/components/Common/Loader'

export default {
  name: 'astronauts-form',
  components: {
    Loader
  },
  props: {
    astronaut: {
      type: Astronaut,
      required: true,
    },
    astronautAvatarPreview: {
      type: String,
      default: null,
    },
    astronautAvatarPreviewIsLoading: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      planetsOptions: [
        { value: null, text: 'Select astronaut planet' },
        { value: 'donut-factory', text: 'Donut Factory' },
        { value: 'duck-invaders', text: 'Duck Invaders' },
        { value: 'hq', text: 'HQ' },
        { value: 'raccoons-of-asgard', text: 'Raccoons Of Asgard' },
        { value: 'schizo-cats', text: 'Schizo Cats' },
      ],
      astronautInput: Object.assign({}, this.astronaut),
    }
  },
  methods: {
    onSubmit() {
      this.$emit('onSubmit', this.astronautInput)
    },
    onReset() {
      this.$nextTick(() => {
        const self = this

        Object.keys(this.astronautInput).forEach(key => {
          self.astronautInput[key] = this.astronaut[key]
        })

        this.$refs.observer.reset()
      })
    },
  }
}
</script>

<style lang="scss" scoped >
.image-preview {
  margin-top: 25px;
}
</style>
