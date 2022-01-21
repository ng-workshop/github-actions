<template>
  <router-link :to="link.to" custom v-slot="{ navigate }">
    <span :class="classes" @click="navigate" @keypress.enter="navigate" role="link">{{ link.title | capitalize }}</span>
  </router-link>
</template>

<script>
import Link from '@/props/link'

export default {
  name: 'link-to',
  props: {
    link: {
      type: Link,
      require: true,
    },
    extendClass: {
      type: String
    }
  },
  computed: {
    classes() {
      let classes = 'link-to'

      if (this.extendClass) {
        classes += ` link-to-${this.extendClass}`
      }

      return classes
    },
  },
}
</script>

<style lang="scss">

span.link-to {
  color: #007bff;
  text-decoration: underline;

  &:hover {
    cursor: pointer;
    text-decoration: none;
  }
}
</style>
