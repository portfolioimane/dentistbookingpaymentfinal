<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
      <LogoComponent />
    </a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <router-link to="/" class="nav-link">Home</router-link>
        </li>
        <li class="nav-item">
          <a href="#services" class="nav-link">Services</a>
        </li>
        <li class="nav-item">
          <a href="#about" class="nav-link">About</a>
        </li>
        <li class="nav-item">
          <a href="#testimonials" class="nav-link">Testimonials</a>
        </li>
        <li class="nav-item">
          <button @click="goToAppointment" class="btn btn-primary">Get Appointment</button>
        </li>
        
        <!-- Login/Register Dropdown -->
        <li class="nav-item dropdown" v-if="!isAuthenticated">
          <a class="nav-link dropdown-toggle" href="#" id="authDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="material-icons">person</span> Account
          </a>
          <ul class="dropdown-menu" aria-labelledby="authDropdown">
            <li><router-link to="/login" class="dropdown-item">Login</router-link></li>
            <li><router-link to="/register" class="dropdown-item">Register</router-link></li>
          </ul>
        </li>

        <!-- Profile Dropdown (for authenticated users) -->
        <li class="nav-item dropdown" v-if="isAuthenticated && user">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="material-icons">account_circle</span> {{ user.name }}
          </a>
          <ul class="dropdown-menu" aria-labelledby="userDropdown">
            <li><router-link to="/profile" class="dropdown-item">Profile</router-link></li>
            <li><router-link to="/patientdashboard" class="dropdown-item">PatientDashboard</router-link></li>
            <li><a @click="logout" class="dropdown-item">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex';
import LogoComponent from './LogoSection.vue'; // Import the logo component

export default {
  name: 'Navbar',
  components: {
    LogoComponent, // Register the logo component
  },
  computed: {
    ...mapGetters('auth', ['isAuthenticated', 'user']),
  },
  mounted() {
    this.$store.dispatch('auth/checkAuth');
    console.log('Is authenticated Navbar:', this.isAuthenticated);
  },
  methods: {
    async logout() {
      console.log('Logout method triggered');
      try {
        await this.$store.dispatch('auth/logout');
        this.$forceUpdate();
        console.log('Logout action dispatched. Is authenticated:', this.isAuthenticated);
        this.$router.push('/');
      } catch (error) {
        console.error('Logout failed:', error);
      }
    },
    goToAppointment() {
      // Redirect to the appointment booking page
      this.$router.push('/appointment');
    },
  },
};
</script>

<style>
/* Add navbar styles here */
.btn-primary {
  background-color: #007BFF; /* Custom button color */
  border: none; /* Remove border for a cleaner look */
  color: white; /* Set text color to white */
}

/* Optional: Style for the navbar links */
.nav-link {
  padding: 10px 15px; /* Increase padding for better click area */
}

/* Optional: Style for Logout button */
.btn-link {
  color: #dc3545; /* Change color for Logout to red */
}
</style>
