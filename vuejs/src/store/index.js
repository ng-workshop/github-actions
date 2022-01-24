import Vue from 'vue'
import Vuex from 'vuex'

import astronaut from './modules/astronaut'
import astronauts from './modules/astronauts'
import astronautsAvatar from './modules/astronauts-avatar'
import loader from './modules/loader'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    astronaut,
    astronauts,
    astronautsAvatar,
    loader,
  },
  namespaced: true
})
