<template>
  <b-row>
    <b-col>
      <b-table striped head-variant="dark" :fields="fields" :items="astronauts">
        <template #cell(id)="data">
          <link-to :link="data.value" :extendClass="`astronaut-show-id-${data.value.params.id}`" />
        </template>
        <template #cell(avatar)="data"><b-avatar :src="data.value" /></template>
        <template #cell(createdAt)="data">{{ $formatDate(data.value) }}</template>
        <template #cell(updatedAt)="data">{{ $formatDate(data.value) }}</template>
        <template #cell(actions)="data">
          <b-row align-h="center">
            <b-col cols="4">
              <button-icon
                  :link="data.value.edit"
                  type="edit"
                  :extendClass="`astronaut-edit-id-${data.value.edit.params.id}`"
              />
            </b-col>
            <b-col cols="4">
              <button-icon
                  :link="data.value.delete"
                  type="delete"
                  :extendClass="`astronaut-delete-id-${data.value.edit.params.id}`"
              />
            </b-col>
          </b-row>
        </template>
      </b-table>
    </b-col>
  </b-row>
</template>

<script>
import ButtonIcon from '@/components/Common/ButtonIcon'
import LinkTo from '@/components/Common/LinkTo'

export default {
  name: 'astronauts-table',
  components: {
    ButtonIcon,
    LinkTo,
  },
  props: {
    astronauts: {
      type: Array,
      require: true,
    }
  },
  data() {
    return {
      fields: [
        { key: 'id', label: 'id', formatter: (value, key, item) => item.links.show },
        'avatar',
        'username',
        'email',
        { key: 'formattedPlanetName', label: 'planet' },
        { key: 'createdAt', label: 'created at' },
        { key: 'updatedAt', label: 'updated at' },
        { key: 'actions', label: 'actions', formatter: (value, key, item) => ({
            edit: item.links.edit,
            delete: item.links.delete
          })
        },
      ]
    }
  },
}
</script>

<style lang="scss" >
.table > tbody > tr > td {
  vertical-align: middle;
}
</style>
