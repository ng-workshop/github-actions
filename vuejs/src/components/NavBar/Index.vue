<template>
    <b-navbar toggleable="lg" type="dark" variant="dark">
      <b-navbar-brand :to="links[0].to">{{ title }}</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <nav-bar-item v-for="(link, index) in links" :key="index" :link="link" />
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
</template>

<script>
import NavBarItem from '@/components/NavBar/Item'

export default {
  name: 'nav-bar',
  components: {
    NavBarItem
  },
  props: {
    links: {
      type: Array,
      require: true
    }
  },
  data() {
    return {
      title: 'VueJS',
    }
  },
}
</script>
