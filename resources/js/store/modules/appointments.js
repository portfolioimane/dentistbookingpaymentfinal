import axios from '../../utils/axios.js'; // Ensure this path is correct

const state = {
  appointment: {
    service_id: '',
    date: '',
    start_time: '',
    end_time: '',
  },
  availableSlots: [],
  user: null,
  token: localStorage.getItem('user-token') || '',
};

const mutations = {
  SET_APPOINTMENT(state, appointment) {
    state.appointment = appointment;
  },
  SET_AVAILABLE_SLOTS(state, slots) {
    state.availableSlots = slots;
  },
  SET_USER(state, user) {
    state.user = user;
  },
  SET_TOKEN(state, token) {
    state.token = token;
  },
};

const actions = {
  async getAppointmentById({ commit }, appointmentId) {
    try {
      const response = await axios.get(`/api/appointments/${appointmentId}`);
      commit('SET_APPOINTMENT', response.data);
      return response.data;
    } catch (error) {
      console.error('Error fetching appointment:', error);
      throw error;
    }
  },

  async bookAppointment({ commit, dispatch }, appointmentData) {
    try {
      const response = await axios.post('/api/appointments', appointmentData);

      const appointmentId = response.data.appointment ? response.data.appointment.id : null;
      const token = response.data.token;
      localStorage.setItem('user-token', token);

      // Commit token to state
      commit('SET_TOKEN', token);

      console.log('Appointment booked successfully:', response.data);

      await dispatch('auth/checkAuth', null, { root: true });

      return response.data;
    } catch (error) {
      console.error('Appointment booking failed:', error.response?.data || error.message);
      throw error.response?.data || error.message;
    }
  },

  async fetchAvailableSlots({ commit }, { date, service_id }) {
    if (!date || !service_id) return;
    try {
      const response = await axios.get('/api/available-slots', {
        params: { date, service_id },
      });
      commit('SET_AVAILABLE_SLOTS', response.data);
    } catch (error) {
      console.error('Error fetching available slots:', error.response?.data || error.message);
    }
  },

  setAppointment({ commit }, appointment) {
    commit('SET_APPOINTMENT', appointment);
  },

  async updateAppointmentStatus({ commit }, { id, payment_status, payment_method }) {
    try {
      const response = await axios.patch(`/api/appointments/${id}/update-status`, {
        payment_status,
        payment_method,
      });

      commit('SET_APPOINTMENT', response.data.appointment);
      return response.data;
    } catch (error) {
      console.error('Error updating appointment status:', error.response?.data || error.message);
      throw error.response?.data || error.message;
    }
  },

  async confirmBooking({ dispatch }, { id, payment_method, stripePaymentMethodId = null }) {
    try {
      const payload = { payment_method };
      if (stripePaymentMethodId) {
        payload.stripePaymentMethodId = stripePaymentMethodId;
      }

      const response = await axios.patch(`/api/appointments/${id}/confirm`, payload);
      await dispatch('getAppointmentById', id);

      return response.data;
    } catch (error) {
      console.error('Error confirming booking:', error.response?.data || error.message);
      throw error.response?.data || error.message;
    }
  },

  async confirmPaypalPayment({ commit }, { id, orderID }) {
    try {
      const response = await axios.post('/api/appointments/confirm-paypal', {
        id,
        orderID,
      });

      console.log('Response from PayPal confirmation:', response.data);
      return response.data;
    } catch (error) {
      if (error.response) {
        console.error('Error confirming PayPal payment:', error.response.data);
        throw error.response.data;
      } else {
        console.error('Network error confirming PayPal payment:', error.message);
        throw new Error('Network error: Unable to confirm payment. Please try again.');
      }
    }
  },
};

const getters = {
  currentAppointment: (state) => state.appointment,
  availableSlots: (state) => state.availableSlots,
  isAuthenticated: (state) => !!state.token,
  user: (state) => state.user,
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
