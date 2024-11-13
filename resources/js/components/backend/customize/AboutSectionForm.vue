<template>
  <div class="form-container">
    <h2>Update About Section</h2>
    <form @submit.prevent="updateContent">
      <div class="form-group">
        <label for="aboutTitle">Title</label>
        <input
          type="text"
          id="aboutTitle"
          v-model="aboutContent.title"
          required
          class="form-input"
        />
      </div>
      <div class="form-group">
        <label for="aboutText">Text</label>
        <textarea
          id="aboutText"
          v-model="aboutContent.text"
          required
          class="form-textarea"
        ></textarea>
      </div>
      <div class="form-group">
        <label for="aboutImage">Image</label>
        <input
          type="file"
          id="aboutImage"
          @change="handleImageUpload"
          class="form-file"
        />
        <div v-if="imagePreview" class="image-preview">
          <img :src="imagePreview" alt="Image Preview" class="preview-img" />
        </div>
      </div>
      <button type="submit" class="submit-button">Update About Section</button>
    </form>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  data() {
    return {
      imagePreview: null, // To store the preview URL
    };
  },
  computed: {
    ...mapGetters('backendContentBlock', ['aboutContent']),
  },
  methods: {
    ...mapActions('backendContentBlock', ['updateAboutContent', 'fetchAboutContent']),
    
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.aboutContent.image_path = file; // Store the file object for upload
        this.imagePreview = URL.createObjectURL(file); // Update the preview
      } else {
        this.imagePreview = null; // Reset preview if no file selected
      }
    },

    async updateContent() {
      const formData = new FormData();
      formData.append('title', this.aboutContent.title);
      formData.append('text', this.aboutContent.text);
      // Append image only if it exists
      if (this.aboutContent.image_path) {
        formData.append('image_path', this.aboutContent.image_path);
      }

      try {
        await this.updateAboutContent(formData);
        alert('About section updated successfully!');
      } catch (error) {
        console.error("Error updating about content:", error);
        alert('Failed to update About section. Please try again.');
      }
    },
  },

  created() {
    this.fetchAboutContent().then(() => {
      if (this.aboutContent.image_path) {
        // Set the initial image preview to the current image URL
        this.imagePreview = `${window.APP_URL}/storage/${this.aboutContent.image_path}`;
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
.form-input,
.form-textarea,
.form-file {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  transition: border-color 0.3s;
}
.form-input:focus,
.form-textarea:focus {
  border-color: #007bff;
  outline: none;
}
.form-textarea {
  min-height: 100px;
  resize: vertical;
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
