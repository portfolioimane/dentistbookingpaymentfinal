<template>
  <div class="container mt-5">
    <h1 class="text-center">Login</h1>
    <form @submit.prevent="loginUser">
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" id="email" v-model="email" class="form-control" required />
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" id="password" v-model="password" class="form-control" required />
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <div v-if="error" class="mt-3 alert alert-danger">{{ error }}</div>
    <p class="mt-3 text-center">
      Don't have an account? <router-link to="/register">Register here</router-link>
    </p>
  </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  data() {
    return {
      email: '',
      password: '',
      error: null,
    };
  },
  methods: {
    ...mapActions('auth', ['login']),
    
    async loginUser() {
      try {
        await this.login({ email: this.email, password: this.password });
        this.$router.push('/'); // Redirect to home after successful login
      } catch (err) {
        this.error = err.response?.data?.message || 'Login failed. Please check your credentials.';
      }
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 500px; /* Limit the width of the form */
}
</style>
