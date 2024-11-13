import axios from '../../utils/axios.js';

const state = {
  heroContent: null,
  aboutContent: null,
  consultationContent: null,
  logoContent: null,  // New state for logo content
};

const mutations = {
  setHeroContent: (state, content) => (state.heroContent = content),
  setAboutContent: (state, content) => (state.aboutContent = content),
  setConsultationContent: (state, content) => (state.consultationContent = content),
  setLogoContent: (state, content) => (state.logoContent = content),  // New mutation for logo content
};

const actions = {
  async fetchHeroContent({ commit }) {
    try {
      const response = await axios.get('/api/content/hero');
      commit('setHeroContent', response.data);
    } catch (error) {
      console.error('Error fetching hero content:', error);
    }
  },
  async fetchAboutContent({ commit }) {
    try {
      const response = await axios.get('/api/content/about');
      commit('setAboutContent', response.data);
    } catch (error) {
      console.error('Error fetching about content:', error);
    }
  },
  async fetchConsultationContent({ commit }) {
    try {
      const response = await axios.get('/api/content/consultation');
      commit('setConsultationContent', response.data);
    } catch (error) {
      console.error('Error fetching consultation content:', error);
    }
  },
  async fetchLogoContent({ commit }) {  // New action to fetch logo content
    try {
      const response = await axios.get('/api/content/logo');
      commit('setLogoContent', response.data);
    } catch (error) {
      console.error('Error fetching logo content:', error);
    }
  },
};

const getters = {
  heroContent: (state) => state.heroContent,
  aboutContent: (state) => state.aboutContent,
  consultationContent: (state) => state.consultationContent,
  logoContent: (state) => state.logoContent,  // New getter for logo content
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
