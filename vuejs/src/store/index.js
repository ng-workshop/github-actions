import Vue from 'vue'
import Vuex from 'vuex'

import astronaut from '@/store/modules/astronaut';
import astronauts from '@/store/modules/astronauts';
import astronautsAvatar from '@/store/modules/astronauts-avatar';
import loader from '@/store/modules/loader';

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
