// services.js
import axios from '../../utils/axios.js';

const state = {
  services: [],
};

const mutations = {
  SET_SERVICES(state, services) {
    state.services = services;
  },
};

const actions = {
  async fetchServices({ commit }) {
    try {
      const response = await axios.get('/api/services');
      commit('SET_SERVICES', response.data);
    } catch (error) {
      console.error('Error fetching services:', error);
    }
  },
};

const getters = {
  allServices: (state) => state.services,
};

export default {
  namespaced: true, // Important: Enables namespacing for the 'services' module
  state,
  mutations,
  actions,
  getters,
};
