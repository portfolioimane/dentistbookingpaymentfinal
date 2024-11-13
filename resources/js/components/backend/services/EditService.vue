<template>
  <div class="edit-service-container">
    <h1>Edit Service</h1>
    <form @submit.prevent="submitForm" class="service-form">
      <div class="form-group">
        <label for="name">Service Name:</label>
        <input type="text" id="name" v-model="service.name" required placeholder="e.g., Teeth Cleaning" />
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" v-model="service.description" required placeholder="Describe the service"></textarea>
      </div>

      <div class="form-group">
        <label for="cost">Cost (in MAD):</label>
        <input type="number" id="cost" v-model="service.cost" required placeholder="e.g., 500" min="0" />
      </div>

      <div class="form-group">
        <label for="duration">Duration (minutes):</label>
        <input type="number" id="duration" v-model="service.duration" required placeholder="e.g., 30" min="1" />
      </div>

      <div class="form-group">
        <label for="image">Upload New Image (optional):</label>
        <input type="file" id="image" @change="handleImageUpload" accept="image/*" />
      </div>

      <div class="button-group">
        <button type="submit" class="btn primary">Update Service</button>
        <router-link to="/admin/services" class="btn secondary">Cancel</router-link>
      </div>
    </form>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  data() {
    return {
      service: {
        name: '',
        description: '',
        cost: '',
        duration: '',
        image: null,
      },
    };
  },
  computed: {
    ...mapGetters(['currentService']),
  },
  methods: {
    handleImageUpload(event) {
      this.service.image = event.target.files[0];
    },
async submitForm() {
  const formData = new FormData();
  formData.append("name", this.service.name);
  formData.append("description", this.service.description);
  formData.append("cost", this.service.cost);
  formData.append("duration", this.service.duration);
  
  // Append _method to specify PUT request
  formData.append("_method", "PUT");

  if (this.service.image) {
    formData.append("image", this.service.image);
  }

  await this.$store.dispatch("updateService", { id: this.$route.params.id, data: formData });
  this.$router.push("/admin/services"); // Redirect to services after updating
},

    async fetchService() {
      const serviceId = this.$route.params.id;
      await this.$store.dispatch('fetchServiceById', serviceId); // Fetch the service using the Vuex action
      this.service = { ...this.currentService }; // Update local service data
    },
  },
  mounted() {
    this.fetchService(); // Fetch the service data when the component mounts
  },
};
</script>

<style scoped>
.edit-service-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 2rem;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.edit-service-container h1 {
  margin-bottom: 1.5rem;
  color: #333;
  font-size: 1.75rem;
  text-align: center;
}

.service-form .form-group {
  margin-bottom: 1rem;
}

.service-form label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.5rem;
  color: #555;
}

.service-form input[type="text"],
.service-form input[type="number"],
.service-form input[type="file"],
.service-form textarea {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

.service-form input[type="file"] {
  padding: 0.5rem;
}

.service-form textarea {
  resize: vertical;
  min-height: 100px;
}

.button-group {
  display: flex;
  justify-content: space-between;
  margin-top: 1.5rem;
}

.btn {
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  text-align: center;
}

.btn.primary {
  background-color: #28a745;
  color: #fff;
}

.btn.secondary {
  background-color: #6c757d;
  color: #fff;
}

.btn:hover {
  opacity: 0.9;
}
</style>
