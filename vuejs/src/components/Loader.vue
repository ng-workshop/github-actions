<template>
  <div>
    <p><strong>Loading …</strong></p>
    <b-spinner style="width: 5rem; height: 5rem;" label="Loading …" />
  </div>
</template>

<script>
export default {
  name: 'loader'
}
</script>

<style lang="scss" scoped>
p {
  margin-bottom: 5rem;
}
</style>
