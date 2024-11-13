<template>
  <div v-if="authChecked" class="container mt-5">
    <h2 class="text-center mb-4">Book an Appointment</h2>
    <form @submit.prevent="submitAppointment" class="shadow p-4 rounded bg-light">
      <div class="form-group">
        <label for="name">Name</label>
        <input 
          type="text" 
          v-model="appointment.name" 
          class="form-control" 
          required 
          placeholder="Enter your name" 
        />
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input 
          type="email" 
          v-model="appointment.email" 
          class="form-control" 
          required 
          placeholder="Enter your email" 
        />
      </div>

      <div class="form-group">
        <label for="phone">Phone</label>
        <input 
          type="tel" 
          v-model="appointment.phone" 
          class="form-control" 
          required 
          placeholder="Enter your phone number" 
        />
      </div>

      <div class="form-group">
        <label for="service">Service</label>
        <select 
          v-model="appointment.service_id" 
          class="form-control" 
          @change="fetchAvailableSlots" 
          required
        >
          <option value="" disabled>Select a service</option>
          <option v-for="service in allServices" :key="service.id" :value="service.id">
            {{ service.name }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="date">Date</label>
        <input 
          type="date" 
          v-model="appointment.date" 
          class="form-control" 
          @change="fetchAvailableSlots" 
          required 
        />
      </div>

      <div class="form-group">
        <label for="time_slot">Available Time Slots</label>
        <select 
          v-model="selectedSlot" 
          class="form-control" 
          required
        >
          <option value="" disabled>Select a time slot</option>
          <option v-for="slot in availableSlots" :key="slot.start_time" :value="slot.start_time">
            {{ slot.start_time }} - {{ slot.end_time }}
          </option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Book Appointment</button>
    </form>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      appointment: {
        name: '', 
        email: '', 
        phone: '', 
        service_id: '',
        date: '',
        start_time: '', 
        end_time: '',
      },
      selectedSlot: '', 
    };
  },
  computed: {
    ...mapGetters('services', ['allServices']),
    ...mapGetters('appointments', ['availableSlots']),
    ...mapGetters('auth', ['isAuthenticated', 'user', 'authChecked']),
  },
  methods: {
    ...mapActions('appointments', ['bookAppointment', 'fetchAvailableSlots']),
    ...mapActions('services', ['fetchServices']),

    async submitAppointment() {
      const selectedTime = this.availableSlots.find(slot => slot.start_time === this.selectedSlot);
      if (selectedTime) {
        this.appointment.start_time = selectedTime.start_time;
        this.appointment.end_time = selectedTime.end_time;
      }

      try {
        const response = await this.bookAppointment(this.appointment);

        if (response && response.appointment && response.appointment.id) {
          this.appointment.id = response.appointment.id;  // Set the appointment id

          // SweetAlert2 success notification
          Swal.fire({
            icon: 'success',
            title: 'Appointment Booked!',
            text: 'Your appointment has been booked successfully.',
            confirmButtonText: 'OK'
          }).then(() => {
            // Redirect to confirmation page with appointment ID
            this.$router.push({ name: 'ConfirmBooking', params: { id: this.appointment.id } });

            if (!this.isAuthenticated) {
              this.resetForm(); // Reset form if the user is logged out
            }
          });
        } else {
          throw new Error('Appointment ID not received');
        }
      } catch (error) {
        console.error('Error booking appointment:', error);

        // SweetAlert2 error notification
        Swal.fire({
          icon: 'error',
          title: 'Booking Failed',
          text: 'Failed to book appointment. Please try again.',
          confirmButtonText: 'OK'
        });
      }
    },

    resetForm() {
      this.appointment = { name: '', email: '', phone: '', service_id: '', date: '', start_time: '', end_time: '' };
      this.selectedSlot = ''; 
    },

    fetchAvailableSlots() {
      this.$store.dispatch('appointments/fetchAvailableSlots', {
        date: this.appointment.date,
        service_id: this.appointment.service_id,
      });
    },
  },
  watch: {
    authChecked(value) {
      if (value && this.user) {
        this.appointment.name = this.user.name;
        this.appointment.email = this.user.email;
      } else {
        this.resetForm();
      }
    },
    user(newUser) {
      if (!newUser) {
        this.resetForm();
      }
    },
  },
  mounted() {
    this.$store.dispatch('auth/checkAuth');
    if (!this.allServices.length) {
      this.fetchServices();
    }
  },
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: auto;
}

.shadow {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.bg-light {
  background-color: #f8f9fa !important;
}
</style>
