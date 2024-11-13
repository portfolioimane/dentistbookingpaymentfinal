<template>
  <section class="logo-section">
    <div class="logo-container">
      <img v-if="logoContent?.image_path" :src="logoImagePath" alt="Logo" class="logo-image" />
    </div>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  computed: {
    ...mapGetters('contentBlock', ['logoContent']),
    logoImagePath() {
      const imagePath = this.logoContent?.image_path 
        ? `/storage/${this.logoContent.image_path}` 
        : '';
      return imagePath;
    },
  },
  methods: {
    ...mapActions('contentBlock', ['fetchLogoContent']),
  },
  created() {
    this.fetchLogoContent();
  },
};
</script>

<style scoped>
.logo-section {
  display: flex;
  justify-content: center;
  align-items: center;
  padding-left:20px;
}

.logo-container {
  display: flex;
  justify-content: center;
  align-items: center;
}

.logo-image {
  max-width: 50px; /* Adjust size as needed */
  max-height: 50px; /* Adjust size as needed */
  object-fit: contain; /* Preserve aspect ratio */
}
</style>
