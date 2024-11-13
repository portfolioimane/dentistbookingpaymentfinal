<template>
  <div id="app">
    <!-- Show Navbar only for frontend routes -->
    <Navbar v-if="isFrontend" />
    <router-view />
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue';

export default {
  components: {
    Navbar,
  },
  
  computed: {
    isFrontend() {
      // Determine if the current route is a frontend route
      return !this.$route.path.startsWith('/admin');
    },
  },
};
</script>

<style>
/* Add global styles here */
</style>
