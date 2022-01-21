<template>
  <b-nav-item :to="link.to" :active="isActive" :class="`nav-link-${link.name}`">
    {{ link.title | capitalize }}
  </b-nav-item>
</template>

<script>
import Link from '@/props/link'

export default {
  name: 'nav-bar-item',
  props: {
    link: {
      type: Link,
      require: true,
    }
  },
  computed: {
    isActive() {
      return this.link.name === this.$route.name
    }
  },
}
</script>
