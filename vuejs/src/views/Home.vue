<template>
  <b-row align-h="center">
    <b-col cols="4">
      <p>Pages:</p>

      <b-list-group>
        <b-list-group-item v-for="(link, index) in $getLinksInNav()" :key="index">
          <html-link :link="link" />
        </b-list-group-item>
      </b-list-group>
    </b-col>
  </b-row>
</template>

<script>
import HtmlLink from '@/components/Html/Link'

export default {
  name: 'ViewHome',
  components: {HtmlLink},
  comments: {
    HtmlLink,
  }
}
</script>
