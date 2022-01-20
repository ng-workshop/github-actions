<template>
  <b-nav-item :to="link.to" :active-class="activeClass">
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
  data() {
    return {
      activeClass: '',
    }
  },
  computed() {
    this.activeClass = this.link.name === this.$route.name ? 'active' : ''
  },
}
</script>
