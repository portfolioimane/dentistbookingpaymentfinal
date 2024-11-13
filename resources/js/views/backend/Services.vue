<template>
  <div class="services">
    <h1>Manage Services</h1>
    
    <table class="services-table">
      <thead>
        <tr>
          <th>Service ID</th>
          <th>Name</th>
          <th>Description</th>
          <th>Cost (MAD)</th>
          <th>Duration (min)</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="service in services" :key="service.id">
          <td>{{ service.id }}</td>
          <td>{{ service.name }}</td>
          <td>{{ service.description }}</td>
          <td>{{ parseFloat(service.cost).toFixed(2) }}</td>
          <td>{{ service.duration }}</td>
          <td>
            <img :src="service.image ? `/storage/${service.image}` : '/images/services/default-service.png'" 
                 alt="Service Image" 
                 style="max-width: 100px; max-height: 100px;" 
                 v-if="service.image || !service.image"/>
          </td>
          <td>
            <button class="btn secondary" @click="editService(service)">Edit</button>
            <button class="btn danger" @click="confirmDelete(service.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>


<script>
import { mapGetters } from 'vuex';

export default {
  name: 'Services',
  computed: {
    ...mapGetters(['allServices']),
    services() {
      return this.allServices;
    },
  },
  methods: {
    editService(service) {
      // Logic to edit the service (e.g., navigate to edit page)
      this.$router.push({ name: 'EditService', params: { id: service.id } }); // Assuming you have a route for editing
    },
    confirmDelete(serviceId) {
      if (confirm("Are you sure you want to delete this service? This action cannot be undone.")) {
        this.deleteService(serviceId);
      }
    },
    async deleteService(serviceId) {
      await this.$store.dispatch('deleteService', serviceId);
    },
  },
  mounted() {
    // Fetch services when the component is mounted
    this.$store.dispatch('fetchServices');
  },
};
</script>

<style scoped>
.services {
  padding: 20px;
  background-color: #f9f9f9; /* Light background for contrast */
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
  color: #2196F3; /* Adjusted heading color */
  margin-bottom: 20px;
  text-align: center; /* Center the title */
}

.btn {
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn.primary {
  background-color: #2196F3; /* Updated primary button color */
  color: white;
}

.btn.secondary {
  background-color: #f39c12; /* Secondary button color */
  color: white;
}

.btn.danger {
  background-color: #e74c3c; /* Danger button color */
  color: white;
}

.btn:hover {
  opacity: 0.9; /* Slightly darken on hover */
}

.services-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.services-table th,
.services-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}

.services-table th {
  background-color: #2196F3; /* Changed to sidebar blue */
  color: white;
}

.services-table tbody tr:nth-child(even) {
  background-color: #f2f2f2; /* Zebra striping for rows */
}
</style>
