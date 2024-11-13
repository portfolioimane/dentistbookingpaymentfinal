<template>
  <div class="container mt-5">
    <h1 class="text-center">Register</h1>
    <form @submit.prevent="handleRegister">
      <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" id="name" v-model="name" class="form-control" required />
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" id="email" v-model="email" class="form-control" required />
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" id="password" v-model="password" class="form-control" required />
      </div>
      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password:</label>
        <input type="password" id="password_confirmation" v-model="password_confirmation" class="form-control" required />
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <div v-if="error" class="mt-3 alert alert-danger">{{ error }}</div>
  </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      error: null,
    };
  },
  methods: {
    ...mapActions('auth', ['register']),
    
    async handleRegister() {
      try {
        const userData = {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        };

        await this.register(userData); // Call the registration action
        
        // Redirect to home or profile after successful registration
        this.$router.push('/'); // Adjust the redirect path as needed
      } catch (err) {
        console.error(err);
        this.error = err.response?.data?.message || 'Registration failed. Please check your details.';
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
