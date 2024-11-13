<template>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Appointment Summary</h2>

    <div v-if="appointment" class="shadow p-4 rounded bg-light">
      <!-- Appointment Details -->
      <div class="appointment-details">
        <h4>Appointment Details</h4>
        <p><strong>Name:</strong> {{ appointment.name }}</p>
        <p><strong>Email:</strong> {{ appointment.email }}</p>
        <p><strong>Phone:</strong> {{ appointment.phone }}</p>
        <p><strong>Service:</strong> {{ appointment.service.name }}</p>
        <p><strong>Date:</strong> {{ appointment.date }}</p>
        <p><strong>Time:</strong> {{ appointment.start_time }} - {{ appointment.end_time }}</p>
      </div>

      <div class="payment-summary mt-4">
        <h4>Payment Summary</h4>
        <p><strong>Payment Method:</strong> {{ paymentMethod }}</p>
        <p v-if="paymentMethod === 'paypal'">PayPal payment is in process. You will receive a confirmation email soon.</p>
        <p v-if="paymentMethod === 'stripe'">Stripe payment is successful. You will receive a confirmation email soon.</p>
        <p v-if="paymentMethod === 'cod'">You selected Cash on Delivery. Please prepare the payment on the day of your appointment.</p>
      </div>

      <div class="actions mt-4">
        <button class="btn btn-primary" @click="goHome">Go to Home</button>
      </div>
    </div>

    <div v-else>
      <p v-if="loading">Loading appointment details...</p>
      <p v-else>No appointment details found.</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      appointment: null,
      loading: true,
      paymentMethod: null,
    };
  },

  async mounted() {
    await this.fetchAppointment();
  },

  methods: {
    async fetchAppointment() {
      try {
        this.appointment = await this.$store.dispatch('appointments/getAppointmentById', this.id);
        this.paymentMethod = this.appointment.payment_method; // assuming payment_method is part of the appointment object
        this.loading = false;
      } catch (error) {
        console.error('Error fetching appointment:', error);
        this.loading = false;
      }
    },

    goHome() {
      this.$router.push({ name: 'Home' });
    },
  },
};
</script>

<style scoped>
.appointment-details,
.payment-summary {
  margin-bottom: 20px;
}

.appointment-details h4,
.payment-summary h4 {
  font-size: 1.25rem;
  margin-bottom: 10px;
}

.actions button {
  margin-top: 20px;
}
</style>
