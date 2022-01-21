<template>
  <b-row align-h="center">
    <b-col cols="4" class="show-pages">
      <p>Pages:</p>

      <b-list-group class="page-list">
        <b-list-group-item v-for="(link, index) in $getLinksInNav()" :key="index" class="page-item" >
          <link-to :link="link" :extendClass="link.name" />
        </b-list-group-item>
      </b-list-group>
    </b-col>
  </b-row>
</template>

<script>
import LinkTo from '@/components/Common/LinkTo'

export default {
  name: 'ViewHome',
  components: { LinkTo },
}
</script>
