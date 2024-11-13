import axios from '../../../utils/axios.js';

const state = {
  appointments: [],
};

const mutations = {
  SET_APPOINTMENTS(state, appointments) {
    state.appointments = appointments;
  },
  UPDATE_APPOINTMENT_STATUS(state, { appointmentId, status }) {
    const appointment = state.appointments.find(app => app.id === appointmentId);
    if (appointment) {
      appointment.status = status; // Update the status in the local state
    }
  },
  REMOVE_APPOINTMENT(state, appointmentId) {
    state.appointments = state.appointments.filter(app => app.id !== appointmentId); // Remove the appointment from the state
  },
};

const actions = {
  async fetchAppointments({ commit }) {
    try {
      const response = await axios.get('/api/appointments');
      commit('SET_APPOINTMENTS', response.data);
    } catch (error) {
      console.error('Error fetching appointments:', error);
    }
  },
  
  async changeAppointmentStatus({ commit }, { appointmentId, newStatus }) {
    try {
      await axios.put(`/api/appointments/${appointmentId}`, { status: newStatus });
      commit('UPDATE_APPOINTMENT_STATUS', { appointmentId, status: newStatus }); // Update local state
    } catch (error) {
      console.error('Error changing appointment status:', error);
    }
  },

  async deleteAppointment({ commit }, appointmentId) {
    try {
      await axios.delete(`/api/appointments/${appointmentId}`);
      commit('REMOVE_APPOINTMENT', appointmentId); // Update the state to remove the appointment
    } catch (error) {
      console.error('Error deleting appointment:', error);
    }
  },
  // Other actions for fetching and updating appointments
};

const getters = {
  allAppointments: (state) => state.appointments,
};

export default {
  state,
  mutations,
  actions,
  getters,
};
