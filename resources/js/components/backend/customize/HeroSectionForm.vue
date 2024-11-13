<template>
  <div class="form-container">
    <h2 class="form-title">Update Hero Section</h2>
    <form @submit.prevent="updateContent">
      <div class="form-group">
        <label for="heroTitle">Title</label>
        <input type="text" id="heroTitle" v-model="heroContent.title" required class="form-input" />
      </div>
      <div class="form-group">
        <label for="heroText">Text</label>
        <textarea id="heroText" v-model="heroContent.text" required class="form-textarea"></textarea>
      </div>
      <div class="form-group">
        <label for="heroButtonText">Button Text</label>
        <input type="text" id="heroButtonText" v-model="heroContent.button_text" class="form-input" />
      </div>
      <div class="form-group">
        <label for="heroImage">Image</label>
        <input type="file" id="heroImage" @change="handleImageUpload" class="form-file" />
        <div v-if="imagePreview" class="image-preview">
          <img :src="imagePreview" alt="Image Preview" class="preview-img" />
        </div>
      </div>
      <button type="submit" class="submit-button">Update Hero Section</button>
    </form>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  data() {
    return {
      imagePreview: null,
      imageUploaded: false // Initialize to false
    };
  },
  computed: {
    ...mapGetters('backendContentBlock', ['heroContent']),
  },
  methods: {
    ...mapActions('backendContentBlock', ['updateHeroContent', 'fetchHeroContent']),
    
handleImageUpload(event) {
  const file = event.target.files[0];
  if (file) {
    this.heroContent.image_path = file; // This line is correct; it stores the file object for upload
    this.imagePreview = URL.createObjectURL(file); // Update the preview
    this.imageUploaded = true; // Mark that an image has been uploaded
  } else {
    this.imageUploaded = false; // Reset if no file is selected
  }
},

async updateContent() {
  const formData = new FormData();
  formData.append('title', this.heroContent.title);
  formData.append('text', this.heroContent.text);
  formData.append('button_text', this.heroContent.button_text);

  // Only append image if a new one has been uploaded
  if (this.imageUploaded) {
    formData.append('image_path', this.heroContent.image_path);
  }

  await this.updateHeroContent(formData);
},

  },
  
  created() {
    this.fetchHeroContent().then(() => {
      if (this.heroContent.image_path) {
        // Set the initial image preview to the current image URL
        this.imagePreview = `${window.APP_URL}/storage/${this.heroContent.image_path}`;
      }
    });
  }
};
</script>

<style scoped>
.form-container {
  padding: 30px;
  background: #ffffff;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  max-width: 600px;
  margin: 40px auto;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  font-family: Arial, sans-serif;
}

.form-title {
  text-align: center;
  color: #333;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
  color: #555;
}

.form-input,
.form-textarea,
.form-file {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  transition: border-color 0.3s;
}

.form-input:focus,
.form-textarea:focus,
.form-file:focus {
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
