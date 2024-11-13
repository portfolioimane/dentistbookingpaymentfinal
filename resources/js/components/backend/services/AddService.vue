<template>
  <div class="add-service-container">
    <h1>Add New Service</h1>
    <form @submit.prevent="submitForm" class="service-form">
      <div class="form-group">
        <label for="name">Service Name:</label>
        <input type="text" id="name" v-model="newService.name" required placeholder="e.g., Teeth Cleaning" />
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" v-model="newService.description" required placeholder="Describe the service"></textarea>
      </div>

      <div class="form-group">
        <label for="cost">Cost (in MAD):</label>
        <input type="number" id="cost" v-model="newService.cost" required placeholder="e.g., 500" min="0" />
      </div>

      <div class="form-group">
        <label for="duration">Duration (minutes):</label>
        <input type="number" id="duration" v-model="newService.duration" required placeholder="e.g., 30" min="1" />
      </div>

      <div class="form-group">
        <label for="image">Upload Image:</label>
        <input type="file" id="image" @change="handleImageUpload" accept="image/*" />
      </div>

      <div class="button-group">
        <button type="submit" class="btn primary">Add Service</button>
        <router-link to="/admin/services" class="btn secondary">Cancel</router-link>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      newService: {
        name: '',
        description: '',
        cost: '',
        duration: '',
        image: null,
      },
    };
  },
  methods: {
    handleImageUpload(event) {
      this.newService.image = event.target.files[0];
    },
    async submitForm() {
      const formData = new FormData();
      formData.append("name", this.newService.name);
      formData.append("description", this.newService.description);
      formData.append("cost", this.newService.cost);
      formData.append("duration", this.newService.duration);
      if (this.newService.image) {
        formData.append("image", this.newService.image);
      }

      await this.$store.dispatch("addService", formData);
      this.$router.push("/admin/services"); // Redirect to services after adding
    },
  },
};
</script>

<style scoped>
.add-service-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 2rem;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.add-service-container h1 {
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
