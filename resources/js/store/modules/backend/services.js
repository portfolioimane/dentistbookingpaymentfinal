import axios from '../../../utils/axios.js';

const state = {
  services: [],
  service: {
    id: null,
    name: '',
    description: '',
    cost: 0,
    duration: 0,
    image: null,
  },
};

const mutations = {
  SET_SERVICES(state, services) {
    state.services = services;
  },
  SET_SERVICE(state, service) {
    state.service = { ...service }; // Spread the service object to ensure a fresh copy
  },
  UPDATE_SERVICE(state, updatedService) {
    const index = state.services.findIndex(service => service.id === updatedService.id);
    if (index !== -1) {
      // Update the service in the local state
      state.services.splice(index, 1, { ...updatedService });
    }
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
  async fetchServiceById({ commit }, serviceId) {
    try {
      const response = await axios.get(`/api/services/${serviceId}`);
      commit('SET_SERVICE', response.data);
    } catch (error) {
      console.error('Error fetching service:', error);
    }
  },
  async addService({ dispatch }, service) {
    try {
      await axios.post('/api/services', service);
      dispatch('fetchServices');
    } catch (error) {
      console.error('Error adding service:', error);
    }
  },
async updateService({ dispatch }, { id, data }) {
  try {
    await axios.post(`/api/services/${id}`, data, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      params: {
        _method: 'PUT' // Specify that the intended method is PUT
      }
    });
    dispatch('fetchServices'); // Fetch updated services list
  } catch (error) {
    console.error('Error updating service:', error);
  }
},

  async deleteService({ dispatch }, serviceId) {
    try {
      await axios.delete(`/api/services/${serviceId}`);
      dispatch('fetchServices');
    } catch (error) {
      console.error('Error deleting service:', error);
    }
  },
};

const getters = {
  allServices: (state) => state.services,
  currentService: (state) => state.service,
};

export default {
  state,
  mutations,
  actions,
  getters,
};
