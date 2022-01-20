<template>
  <router-link :to="link.to" custom v-slot="{ navigate }">
    <span class="link" @click="navigate" @keypress.enter="navigate" role="link">{{ link.title | capitalize }}</span>
  </router-link>
</template>

<script>
import LinkType from '@/props/link'

export default {
  name: 'html-link',
  props: {
    link: {
      type: LinkType,
      require: true,
    }
  },
}
</script>

<style lang="scss">

span.link {
  color: $primary;
  text-decoration: underline;
}
</style>
