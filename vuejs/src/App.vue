<template>
  <div id="app">
    <nav-bar :links="$getLinksInNav()"/>
    <b-container id="container" fluid>
      <router-view />
    </b-container>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar/Index";

export default {
  name: 'App',
  components: {
    NavBar
  }
}
</script>

<style lang="scss">

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#container {
  margin-top: 50px;
}
</style>
