<template>
  <b-button :to="link.to" :variant="getVariant()" :class="classes">
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
      default: null,
    },
    extendClass: {
      type: String
    }
  },computed: {
    classes() {
      let classes = `button-icon button-icon-${this.type || 'default'}`

      if (this.extendClass) {
        classes += ` button-icon-${this.extendClass}`
      }

      return classes
    }
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
  },

}
</script>
