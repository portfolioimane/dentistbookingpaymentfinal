<template>
  <div class="form-container">
    <h2>Update Logo</h2>
    <form @submit.prevent="updateContent">
      <div class="form-group">
        <label for="logoImage">Logo Image</label>
        <input
          type="file"
          id="logoImage"
          @change="handleImageUpload"
          class="form-file"
        />
        <div v-if="imagePreview" class="image-preview">
          <img :src="imagePreview" alt="Logo Preview" class="preview-img" />
        </div>
      </div>
      <button type="submit" class="submit-button">Update Logo</button>
    </form>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  data() {
    return {
      imagePreview: null, // To store the preview URL
      logoContent: { image_path: null }, // Initialize the logoContent object in the data
    };
  },
  computed: {
    ...mapGetters('backendContentBlock', ['logoContent']),
  },
  methods: {
    ...mapActions('backendContentBlock', ['updateLogoContent', 'fetchLogoContent']),
    
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.logoContent.image_path = file; // Store the file object for upload
        this.imagePreview = URL.createObjectURL(file); // Update the preview
      } else {
        this.imagePreview = null; // Reset preview if no file selected
      }
    },

    async updateContent() {
      const formData = new FormData();
      // Append image only if it exists
      if (this.logoContent.image_path) {
        formData.append('image_path', this.logoContent.image_path);
      }

      try {
        await this.updateLogoContent(formData);
        alert('Logo updated successfully!');
      } catch (error) {
        console.error("Error updating logo:", error);
        alert('Failed to update logo. Please try again.');
      }
    },
  },

  created() {
    this.fetchLogoContent().then(() => {
      if (this.logoContent.image_path) {
        // Set the initial image preview to the current logo URL
        this.imagePreview = `${window.APP_URL}/storage/${this.logoContent.image_path}`;
      }
    });
  },
};
</script>

<style scoped>
.form-container {
  padding: 20px;
  background: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 5px;
  max-width: 600px;
  margin: auto;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.form-group {
  margin-bottom: 15px;
}
.form-file {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  transition: border-color 0.3s;
}
.form-file:focus {
  border-color: #007bff;
  outline: none;
}
.image-preview {
  margin-top: 10px;
}
.preview-img {
  max-width: 100%;
  max-height: 200px;
  border-radius: 4px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}
.submit-button {
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 12px 20px;
  cursor: pointer;
  font-size: 16px;
  width: 100%;
  transition: background-color 0.3s;
}
.submit-button:hover {
  background-color: #0056b3;
}
</style>
