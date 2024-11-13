<template>
  <section class="about-section">
    <div class="about-content">
      <div class="about-text">
        <h2 class="about-title">{{ aboutContent?.title }}</h2>
        <p class="about-description">{{ aboutContent?.text }}</p>
      </div>
      <div class="about-image">
        <img 
          v-if="aboutContent?.image_path" 
          :src="`/storage/${aboutContent.image_path}`" 
          alt="About Us" 
          class="about-img" 
        />
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  computed: {
    ...mapGetters('contentBlock', ['aboutContent']),
  },
  methods: {
    ...mapActions('contentBlock', ['fetchAboutContent']),
  },
  created() {
    this.fetchAboutContent();
  },
};
</script>

<style scoped>
.about-section {
  padding: 80px 20px; /* Increased padding for spacious look */
  background-color: #f8f8f8; /* Soft background color */
}

.about-content {
  display: flex; /* Flex layout */
  flex-direction: row; /* Row layout */
  max-width: 1200px; /* Set maximum width */
  margin: auto; /* Center section */
  align-items: flex-start; /* Align items to the top */
}

.about-text {
  flex: 1; /* Occupy half of the width */
  padding-right: 30px; /* Space between text and image */
  text-align: left; /* Left-align text */
}

.about-title {
  font-size: 2.4rem; /* Large title font */
  font-weight: 700; /* Bold title */
  color: #333; /* Darker title color */
  margin-bottom: 20px; /* Space below title */
}

.about-description {
  font-size: 1.1rem; /* Slightly larger text */
  color: #666; /* Soft gray for readability */
  line-height: 1.8; /* Better line spacing */
  max-width: 600px; /* Limit width for readability */
}

.about-image {
  flex: 1; /* Image occupies half the width */
  text-align: center; /* Center image */
}

.about-img {
  width: 100%; /* Full width for responsiveness */
  height: auto; /* Maintain aspect ratio */
  border-radius: 8px; /* Subtle rounding */
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Softer shadow */
  max-height: 400px; /* Limit image height */
}
</style>
