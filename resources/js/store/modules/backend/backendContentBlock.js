import axios from '../../../utils/axios.js';

const state = {
    heroContent: {
        title: '',
        text: '',
        button_text: '',
        image_path: null, // Add default value for the image path
    },
    consultationContent: {
        title: '',
        text: '',
        button_text: '',
        image_path: null,
    },
    aboutContent: {
        title: '',
        text: '',
        image_path: null,
    },
    logoPath: null, // New state property for logo
};

const mutations = {
    setHeroContent: (state, content) => {
        state.heroContent = content;
    },
    setConsultationContent: (state, content) => {
        state.consultationContent = content;
    },
    setAboutContent: (state, content) => {
        state.aboutContent = content;
    },
    setLogoContent: (state, path) => {
        state.logoPath = path; // Mutation for updating the logo path
    },
};

const actions = {
    async fetchHeroContent({ commit }) {
        try {
            const response = await axios.get('/api/content/herosection');
            console.log("Fetched hero content:", response.data); // Log the response data
            commit('setHeroContent', response.data);
        } catch (error) {
            console.error("Error fetching hero content:", error); // Log any errors
        }
    },
    async updateHeroContent({ dispatch }, payload) {
        try {
            await axios.post('/api/content/herosection', payload);
            dispatch('fetchHeroContent'); // Refresh content after update
            alert('Hero section updated successfully!');
        } catch (error) {
            console.error("Error updating hero content:", error); // Log any errors
            alert('Failed to update hero section. Please try again.');
        }
    },

    async fetchConsultationContent({ commit }) {
        try {
            const response = await axios.get('/api/content/consultationsection');
            console.log("Fetched consultation content:", response.data);
            commit('setConsultationContent', response.data);
        } catch (error) {
            console.error("Error fetching consultation content:", error);
        }
    },
    
    async updateConsultationContent({ dispatch }, payload) {
        try {
            await axios.post('/api/content/consultationsection', payload);
            dispatch('fetchConsultationContent'); // Refresh content after update
            alert('Consultation section updated successfully!');
        } catch (error) {
            console.error("Error updating consultation content:", error);
            alert('Failed to update consultation section. Please try again.');
        }
    },

    async fetchAboutContent({ commit }) {
        try {
            const response = await axios.get('/api/content/aboutsection');
            console.log("Fetched about content:", response.data);
            commit('setAboutContent', response.data);
        } catch (error) {
            console.error("Error fetching about content:", error);
        }
    },
    
    async updateAboutContent({ dispatch }, payload) {
        try {
            await axios.post('/api/content/aboutsection', payload);
            dispatch('fetchAboutContent'); // Refresh content after update
            alert('About section updated successfully!');
        } catch (error) {
            console.error("Error updating about content:", error);
            alert('Failed to update about section. Please try again.');
        }
    },

    async fetchLogoContent({ commit }) {
        try {
            const response = await axios.get('/api/content/logosection'); // Endpoint to fetch the logo
            console.log("Fetched logo:", response.data);
            commit('setLogoContent', response.data.logo_path); // Assuming the response contains the logo_path
        } catch (error) {
            console.error("Error fetching logo:", error);
        }
    },

    async updateLogoContent({ dispatch }, payload) {
        try {
            await axios.post('/api/content/logosection', payload); // Endpoint to update the logo
            dispatch('fetchLogoContent'); // Refresh logo after update
            alert('Logo updated successfully!');
        } catch (error) {
            console.error("Error updating logo:", error);
            alert('Failed to update logo. Please try again.');
        }
    },
};

const getters = {
    heroContent: (state) => state.heroContent,
    consultationContent: (state) => state.consultationContent,
    aboutContent: (state) => state.aboutContent,
    logoContent: (state) => state.logoPath, // Getter for logo path
};

export default {
    namespaced: true, // Ensure the module is namespaced
    state,
    getters,
    actions,
    mutations,
};
