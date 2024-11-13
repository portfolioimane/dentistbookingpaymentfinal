<template>
  <section class="hero-section" :style="heroBackgroundImage">
    <div class="content">
      <h1 class="hero-title">{{ heroContent?.title }}</h1>
      <p class="hero-text">{{ heroContent?.text }}</p>
      <button v-if="heroContent?.button_text" class="hero-button">
        {{ heroContent.button_text }}
      </button>
    </div>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  computed: {
    ...mapGetters('contentBlock', ['heroContent']),
    heroBackgroundImage() {
      const imagePath = this.heroContent?.image_path 
        ? `/storage/${this.heroContent.image_path}` 
        : '';
      return { backgroundImage: `url(${imagePath})` };
    },
  },
  methods: {
    ...mapActions('contentBlock', ['fetchHeroContent']),
  },
  created() {
    this.fetchHeroContent();
  },
};
</script>

<style scoped>
.hero-section {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh; /* Full height */
  background-size: cover; /* Cover the entire section */
  background-position: center; /* Center the background image */
  position: relative; /* Positioning for overlay */
  color: white; /* Text color */
  text-align: center; /* Center text */
  padding: 20px; /* Padding */
}

.hero-section::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5); /* Dark overlay for better text visibility */
  z-index: 1;
}

.content {
  position: relative; /* Position relative to overlay */
  z-index: 2; /* Ensure content is above overlay */
}

.hero-title {
  font-size: 3rem; /* Larger font size */
  margin-bottom: 20px; /* Space below title */
}

.hero-text {
  font-size: 1.25rem; /* Slightly larger text */
  margin-bottom: 30px; /* Space below text */
}

.hero-button {
  background-color: #2196F3; /* Button color */
  color: white; /* Text color */
  padding: 15px 30px; /* Button padding */
  font-size: 1rem; /* Button font size */
  border: none; /* No border */
  border-radius: 5px; /* Rounded corners */
  cursor: pointer; /* Pointer on hover */
  transition: background-color 0.3s ease; /* Smooth transition */
}

.hero-button:hover {
  background-color: #1976D2; /* Darker shade on hover */
}
</style>
