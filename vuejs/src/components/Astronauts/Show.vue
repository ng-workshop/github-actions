<template>
  <b-row>
    <b-col cols="2"/>

    <b-col cols="1">
      <b-img-lazy
          :src="astronaut.avatar"
          rounded="circle"
          alt="Astronaut avatar"
          fluid-grow
      />
    </b-col>

    <b-col cols="1"/>

    <b-col cols="6">
      <b-row>
        <b-col cols="3">
          <p class="text-right">
            <b>Username :</b>
          </p>
        </b-col>
        <b-col>
          <p class="text-left">{{ astronaut.username }}</p>
        </b-col>
      </b-row>

      <b-row>
        <b-col cols="3">
          <p class="text-right">
            <b>Email :</b>
          </p>
        </b-col>
        <b-col>
          <p class="text-left">{{ astronaut.email }}</p>
        </b-col>
      </b-row>

      <b-row>
        <b-col cols="3">
          <p class="text-right">
            <b>Planet :</b>
          </p>
        </b-col>
        <b-col>
          <p class="text-left">{{ astronaut.formattedPlanetName }}</p>
        </b-col>
      </b-row>

      <b-row>
        <b-col cols="3">
          <p class="text-right">
            <b>Created at :</b>
          </p>
        </b-col>
        <b-col>
          <p class="text-left">{{ $formatDate(astronaut.createdAt) }}</p>
        </b-col>
      </b-row>

      <b-row>
        <b-col cols="3">
          <p class="text-right">
            <b>Updated at :</b>
          </p>
        </b-col>
        <b-col>
          <p class="text-left">{{ $formatDate(astronaut.updatedAt) }}</p>
        </b-col>
      </b-row>

      <hr />

      <b-row>
        <b-col>
          <b-button :to="{ name: 'astronauts-edit', params: { id: astronaut.id}}" variant="outline-info">Edit</b-button>
        </b-col>
        <b-col>
          <b-button :to="{ name: 'astronauts-delete', params: { id: astronaut.id}}" variant="outline-danger">Remove</b-button>
        </b-col>
      </b-row>
    </b-col>
  </b-row>
</template>

<script>
import { Astronaut } from '../../props';

export default {
  name: 'astronauts-show',
  props: {
    astronaut: {
      type: Astronaut,
      required: true
    }
  }
}
</script>

<style scoped>

</style>
