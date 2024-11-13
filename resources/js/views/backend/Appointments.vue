<template>
  <div class="appointments-container">
    <h2>Appointments</h2>
    <table class="appointments-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Date</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Service</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="appointment in appointments" :key="appointment.id">
          <td>{{ appointment.name }}</td>
          <td>{{ appointment.email }}</td>
          <td>{{ appointment.phone }}</td>
          <td>{{ appointment.date }}</td>
          <td>{{ appointment.start_time }}</td>
          <td>{{ appointment.end_time }}</td>
          <td>{{ appointment.service.name }}</td>
          <td>
            <select v-model="appointment.status" @change="updateStatus(appointment.id, appointment.status)" class="status-select">
              <option v-for="status in possibleStatuses" :key="status" :value="status">{{ status }}</option>
            </select>
          </td>
          <td>
            <div class="action-buttons">
              <button @click="deleteAppointment(appointment.id)" class="delete-button">Delete</button>
              <button @click="viewDetails(appointment.id)" class="details-button">View Details</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      possibleStatuses: ['pending', 'confirmed', 'completed', 'canceled'],
    };
  },
  computed: {
    appointments() {
      return this.$store.getters.allAppointments; // Assuming appointments include name, email, and phone
    },
  },
  created() {
    this.$store.dispatch('fetchAppointments'); // Fetch appointments from the store
  },
  methods: {
    updateStatus(appointmentId, newStatus) {
      this.$store.dispatch('changeAppointmentStatus', { appointmentId, newStatus });
    },
    deleteAppointment(appointmentId) {
      this.$store.dispatch('deleteAppointment', appointmentId);
    },
    viewDetails(appointmentId) {
      // Implement the view details logic, e.g., navigate to a details page or open a modal
      console.log(`Viewing details for appointment ID: ${appointmentId}`);
    },
  },
};
</script>

<style scoped>
.appointments-container {
  max-width: 1200px;
  margin: auto;
  padding: 20px;
  font-family: Arial, sans-serif;
  overflow: hidden; /* Prevents scrolling */
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

.appointments-table {
  width: 100%; /* Full width of the container */
  border-collapse: collapse;
  table-layout: fixed; /* Ensures fixed column widths */
}

.appointments-table th,
.appointments-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
  overflow: hidden; /* Prevents text overflow */
  white-space: nowrap; /* Prevents text wrapping */
  text-overflow: ellipsis; /* Adds ellipsis for overflowing text */
}

/* Fixed widths for each column */
.appointments-table th:nth-child(1),
.appointments-table td:nth-child(1) {
  width: 15%; /* Name */
}

.appointments-table th:nth-child(2),
.appointments-table td:nth-child(2) {
  width: 20%; /* Email */
}

.appointments-table th:nth-child(3),
.appointments-table td:nth-child(3) {
  width: 15%; /* Phone */
}

.appointments-table th:nth-child(4),
.appointments-table td:nth-child(4) {
  width: 10%; /* Date */
}

.appointments-table th:nth-child(5),
.appointments-table td:nth-child(5) {
  width: 10%; /* Start Time */
}

.appointments-table th:nth-child(6),
.appointments-table td:nth-child(6) {
  width: 10%; /* End Time */
}

.appointments-table th:nth-child(7),
.appointments-table td:nth-child(7) {
  width: 10%; /* Service */
}

.appointments-table th:nth-child(8),
.appointments-table td:nth-child(8) {
  width: 10%; /* Status */
}

.appointments-table th:nth-child(9),
.appointments-table td:nth-child(9) {
  width: 10%; /* Actions */
}

.appointments-table th {
  background-color: #2196F3; /* Change to sidebar blue */
  color: white; /* Text color */
  text-transform: uppercase;
}

.appointments-table tbody tr:hover {
  background-color: #f5f5f5;
}

/* Enhanced styles for the status select */
.status-select {
  padding: 10px;
  border-radius: 4px;
  border: 1px solid #ccc;
  font-size: 14px;
  cursor: pointer;
  background-color: #f9f9f9; /* Light background color */
  transition: border-color 0.3s, box-shadow 0.3s;
}

.status-select:focus {
  border-color: #2196F3; /* Blue border on focus */
  box-shadow: 0 0 5px rgba(33, 150, 243, 0.5); /* Blue shadow */
}

.action-buttons {
  display: flex;
  flex-direction: column; /* Stack buttons vertically */
  gap: 5px; /* Space between buttons */
}

.delete-button {
  background-color: #f44336; /* Red */
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 5px;
  cursor: pointer;
}

.delete-button:hover {
  background-color: #d32f2f; /* Darker red */
}

.details-button {
  background-color: #2196F3; /* Blue */
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 5px;
  cursor: pointer;
}

.details-button:hover {
  background-color: #1976D2; /* Darker blue */
}
</style>
