<template>
  <div class="admin-dashboard">
    <aside class="sidebar">
      <h2>Admin Menu</h2>
      <ul>
        <li>
          <div @click="toggleDropdown" class="dropdown-header">
            <i class="material-icons sidebar-icon">local_hospital</i> <!-- Icon for Manage Services -->
            Manage Services
            <i class="material-icons dropdown-arrow">{{ isDropdownOpen ? 'arrow_drop_up' : 'arrow_drop_down' }}</i>
          </div>
          <ul v-if="isDropdownOpen" class="dropdown-list">
            <li>
              <router-link 
                to="/admin/services" 
                class="sidebar-link" 
                :class="{ active: isActive('/admin/services') }">View Services</router-link>
            </li>
            <li>
              <router-link 
                to="/admin/services/add" 
                class="sidebar-link" 
                :class="{ active: isActive('/admin/services/add') }">Add Service</router-link>
            </li>
          </ul>
        </li>
        


        <li>
          <router-link 
            to="/admin/patients" 
            class="sidebar-link" 
            :class="{ active: isActive('/admin/patients') }">
            <i class="material-icons sidebar-icon">person</i> <!-- Icon for View Patients -->
            Manage Patients
          </router-link>
        </li>
        <li>
          <router-link 
            to="/admin/appointments" 
            class="sidebar-link" 
            :class="{ active: isActive('/admin/appointments') }">
            <i class="material-icons sidebar-icon">event</i> <!-- Icon for View Appointments -->
            View Appointments
          </router-link>
        </li>


                <!-- New Customize Section -->
        <li>
          <div @click="toggleCustomizeDropdown" class="dropdown-header">
            <i class="material-icons sidebar-icon">tune</i> <!-- Icon for Customize -->
            Customize
            <i class="material-icons dropdown-arrow">{{ isCustomizeDropdownOpen ? 'arrow_drop_up' : 'arrow_drop_down' }}</i>
          </div>
          <ul v-if="isCustomizeDropdownOpen" class="dropdown-list">
            <li>
              <router-link 
                to="/admin/customize/hero" 
                class="sidebar-link" 
                :class="{ active: isActive('/admin/customize/hero') }">Hero Section</router-link>
            </li>
       
            <li>
              <router-link 
                to="/admin/customize/about" 
                class="sidebar-link" 
                :class="{ active: isActive('/admin/customize/about') }">About Section</router-link>
            </li>

                 <li>
              <router-link 
                to="/admin/customize/consultation" 
                class="sidebar-link" 
                :class="{ active: isActive('/admin/customize/consultation') }">Consultation Section</router-link>
            </li>

             <li>
              <router-link 
                to="/admin/customize/logo" 
                class="sidebar-link" 
                :class="{ active: isActive('/admin/customize/logo') }">Logo Section</router-link>
            </li>
          </ul>
        </li>
      </ul>
    </aside>
    <main class="content">
      <router-view /> <!-- Nested views will be rendered here -->
    </main>
  </div>
</template>

<script>
export default {
  name: 'AdminLayout',
  data() {
    return {
      isDropdownOpen: false,
      isCustomizeDropdownOpen: false, // State for Customize dropdown
    };
  },
  methods: {
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    toggleCustomizeDropdown() {
      this.isCustomizeDropdownOpen = !this.isCustomizeDropdownOpen; // Toggle Customize dropdown
    },
    isActive(route) {
      return this.$route.path === route;
    }
  }
};
</script>

<style scoped>
.admin-dashboard {
  display: flex;
  height: 100vh; /* Make the layout full height */
}

.sidebar {
  width: 250px; /* Adjust width for more space */
  background-color: #2196F3; /* Sidebar background color changed to blue */
  color: white; /* Text color */
  padding: 20px;
  display: flex;
  flex-direction: column;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

.sidebar h2 {
  margin: 0 0 20px; /* Spacing below the heading */
  font-size: 24px; /* Font size for heading */
}

.sidebar ul {
  list-style-type: none; /* Remove default list styling */
  padding: 0; /* Remove padding */
  margin: 0; /* Remove margin */
}

.sidebar li {
  margin-bottom: 15px; /* Spacing between items */
}

.dropdown-header {
  cursor: pointer; /* Pointer cursor for header */
  padding: 10px; /* Padding for clickable area */
  font-size: 18px; /* Font size for dropdown header */
  background-color: #2196F3; /* Match sidebar color */
  border-radius: 4px; /* Rounded corners */
  display: flex;
  justify-content: space-between; /* Space between text and arrow */
  align-items: center; /* Center items vertically */
}

.dropdown-list {
  padding-left: 30px !important;/* Indent the dropdown list */
  margin-top: 10px; /* Add space above dropdown items */
  padding-left: 20px; /* Add space to the left of dropdown items */
}

.sidebar-link {
  color: white; /* Link color */
  text-decoration: none; /* Remove underline */
  font-size: 18px; /* Font size for links */
  transition: background-color 0.3s, color 0.3s; /* Smooth transition for hover effect */
  padding: 10px; /* Padding for clickable area */
  border-radius: 4px; /* Rounded corners */
  display: flex; /* Use flex for icon and text alignment */
  align-items: center; /* Center items vertically */
}

.sidebar-link:hover {
  background-color: rgba(255, 255, 255, 0.1); /* Lighter background on hover */
}

.sidebar-link.active {
  background-color: #1976D2; /* Darker blue for active link */
  color: #e0e0e0; /* Light text for active link */
}

.sidebar-icon {
  margin-right: 10px; /* Space between icon and text */
}

.content {
  flex-grow: 1;
  padding: 20px;
  background-color: #f9f9f9; /* Light background for the content area */
  overflow-y: auto; /* Allow scrolling if content overflows */
}
</style>
