<template>
  <div :id="$route.name">
    <b-row>
      <b-col>
        <h2>{{ $route.meta.title | capitalize }}</h2>
      </b-col>
    </b-row>

    <hr />

    <router-view />
  </div>
</template>

<script>
export default {
  name: 'ViewDefault',
}
</script>
