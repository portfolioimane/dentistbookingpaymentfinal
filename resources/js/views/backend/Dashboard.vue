<template>
  <div class="dashboard">
    <h1>Admin Dashboard</h1>

    <!-- Dashboard Stats Section -->
    <div class="stats">
      <div class="stat-card">
        <h3>Total Appointments</h3>
        <p>{{ totalAppointments }}</p>
      </div>
      <div class="stat-card">
        <h3>Today's Appointments</h3>
        <p>{{ todayAppointments.length }}</p>
      </div>
      <div class="stat-card">
        <h3>New Patients</h3>
        <p>{{ newPatients }}</p>
      </div>
    </div>

    <!-- Recent Appointments Section -->
    <div class="recent-appointments">
      <h2>Recent Appointments</h2>
      <table>
        <thead>
          <tr>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="appointment in recentAppointments" :key="appointment.id">
            <td>{{ appointment.patientName }}</td>
            <td>{{ appointment.date }}</td>
            <td>{{ appointment.time }}</td>
            <td>{{ appointment.status }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: "Dashboard",
  data() {
    return {
      totalAppointments: 150,          // Example data
      todayAppointments: [],           // Example data for today’s appointments
      newPatients: 25,                 // Example data for new patients
      recentAppointments: [            // Example data for recent appointments
        { id: 1, patientName: "John Doe", date: "2024-11-04", time: "10:00 AM", status: "Confirmed" },
        { id: 2, patientName: "Jane Smith", date: "2024-11-04", time: "11:00 AM", status: "Pending" },
        { id: 3, patientName: "Mike Johnson", date: "2024-11-03", time: "2:00 PM", status: "Completed" },
      ],
    };
  },
  methods: {
    fetchDashboardData() {
      // Placeholder method for fetching data, replace with actual API calls
    },
  },
  mounted() {
    this.fetchDashboardData();
  },
};
</script>

<style scoped>
.dashboard {
  padding: 20px;
}

.stats {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.stat-card {
  flex: 1;
  background-color: #f0f8ff;
  padding: 20px;
  border-radius: 8px;
  text-align: center;
}

.stat-card h3 {
  margin: 0;
  color: #007bff;
}

.stat-card p {
  font-size: 24px;
  margin-top: 10px;
}

.recent-appointments {
  margin-top: 20px;
}

.recent-appointments table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

.recent-appointments th, .recent-appointments td {
  padding: 12px;
  border: 1px solid #ddd;
}
</style>
