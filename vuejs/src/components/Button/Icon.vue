<template>
  <b-button :to="link.to" :variant="getVariant()">
    <b-icon-pencil variant="info" v-if="type === 'edit'" />
    <b-icon-trash variant="danger" v-else-if="type === 'delete'" />
    <b-icon-blank variant="dark" v-else />
  </b-button>
</template>

<script>
import Link from '@/props/link'
export default {
  name: 'button-icon',
  props: {
    link: {
      type: Link,
      require: true,
    },
    type: {
      type: String,
      require: true,
    },
  },
  methods: {
    getVariant() {
      switch (this.type) {
        case 'edit':
          return 'outline-primary'
        case 'delete':
          return 'outline-danger'
        default:
          return 'outline-dark'
      }
    }
  }
}
</script>
