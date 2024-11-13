<template>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Confirm Appointment</h2>

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

      <!-- Payment Methods -->
      <h4 class="mt-4">Choose Payment Method</h4>
      <div class="payment-methods">
        <div class="form-check">
          <input
            type="radio"
            id="cod"
            class="form-check-input"
            v-model="selectedPaymentMethod"
            value="cod"
          />
          <label class="form-check-label" for="cod">Cash on Delivery</label>
        </div>
        <div class="form-check">
          <input
            type="radio"
            id="paypal"
            class="form-check-input"
            v-model="selectedPaymentMethod"
            value="paypal"
          />
          <label class="form-check-label" for="paypal">PayPal</label>
        </div>
        <div class="form-check">
          <input
            type="radio"
            id="stripe"
            class="form-check-input"
            v-model="selectedPaymentMethod"
            value="stripe"
          />
          <label class="form-check-label" for="stripe">Stripe</label>
        </div>
      </div>

      <!-- PayPal Button Container -->
      <div v-if="selectedPaymentMethod === 'paypal'" id="paypal-button-container" class="mt-4"></div>

      <!-- Stripe Card Element -->
      <div v-if="selectedPaymentMethod === 'stripe'" class="mt-4">
        <h5>Enter Card Details</h5>
        <div id="card-element"></div>
        <p v-if="stripeError" class="text-danger">{{ stripeError }}</p>
      </div>

      <!-- Confirm Button -->
      <button 
        v-if="selectedPaymentMethod !== 'paypal'" 
        @click="confirmBooking" 
        class="btn btn-primary btn-block mt-4">
        Confirm and Pay
      </button>
    </div>

    <div v-else>
      <p v-if="loading">Loading appointment details...</p>
      <p v-else>No appointment found.</p>
    </div>
  </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';

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
      selectedPaymentMethod: null,
      stripe: null,
      cardElement: null,
      stripeError: null,
      paypalScriptLoaded: false,
    };
  },

  async mounted() {
    await this.fetchAppointment();
    if (this.selectedPaymentMethod === 'stripe') {
      this.initializeStripe();
    }
    if (this.selectedPaymentMethod === 'paypal') {
      this.loadPaypalScript();
    }
  },

  watch: {
    selectedPaymentMethod(value) {
      if (value === 'stripe') {
        this.initializeStripe();
      }
      if (value === 'paypal') {
        if (!this.paypalScriptLoaded) {
          this.loadPaypalScript();
        } else {
          setTimeout(() => {
            this.reRenderPaypalButton();
          }, 100); // Small delay to ensure container is available
        }
      }
    },
  },

  methods: {
    async fetchAppointment() {
      try {
        this.appointment = await this.$store.dispatch('appointments/getAppointmentById', this.id);
        this.loading = false;
      } catch (error) {
        console.error('Error fetching appointment:', error);
        this.loading = false;
      }
    },

    // Initialize Stripe
    async initializeStripe() {
      // If a Stripe element already exists, destroy it before reinitializing
      if (this.cardElement) {
        this.cardElement.unmount();
        this.cardElement = null;
      }

      this.stripe = await loadStripe('client_id_stripe');
      const elements = this.stripe.elements();
      this.cardElement = elements.create('card');
      this.cardElement.mount('#card-element');
    },

    // Load the PayPal script dynamically
    loadPaypalScript() {
      if (this.paypalScriptLoaded) {
        this.reRenderPaypalButton(); // Re-render if script is already loaded
        return;
      }

      const script = document.createElement('script');
      script.src = "https://www.paypal.com/sdk/js?client-id=client_id_paypal&currency=USD";
      script.onload = () => {
        this.paypalScriptLoaded = true;
        this.reRenderPaypalButton(); // Render PayPal button once the script is loaded
      };
      script.onerror = (error) => {
        console.error("Error loading PayPal SDK:", error);
      };
      document.body.appendChild(script);
    },

    // Destroy the PayPal button container and re-render the button
reRenderPaypalButton() {
  const paypalContainer = document.getElementById('paypal-button-container');
  if (paypalContainer) {
    paypalContainer.innerHTML = ''; // Clear existing button

    if (window.paypal && window.paypal.Buttons) {
      window.paypal.Buttons({
        createOrder: (data, actions) => {
          const cost = parseFloat(this.appointment.service.cost);
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: isNaN(cost) ? '0.00' : cost.toFixed(2), // Safe check for valid cost
              },
            }],
          });
        },
        onApprove: (data, actions) => {
          return actions.order.capture().then((details) => {
            // Instead of alert, just call the backend function to confirm payment
            console.log('Payment successful for ' + details.payer.name.given_name);  // Optionally log or handle this silently
            // Send order ID to backend to confirm payment
            this.confirmPaypalPayment(data.orderID);
          });
        },
      }).render('#paypal-button-container');
    } else {
      console.error('PayPal Buttons not available!');
    }
  } else {
    console.error('#paypal-button-container not found');
  }
},

confirmPaypalPayment(orderID) {
  // Call the backend to confirm PayPal payment
  this.$store.dispatch('appointments/confirmPaypalPayment', {
    id: this.id,
    orderID: orderID
  }).then(response => {
    if (response.success) {
      this.$router.push({ name: 'AppointmentSummary', params: { id: this.id } });
    } else {
      alert('Payment confirmation failed');
    }
  }).catch(error => {
    console.error('Error confirming PayPal payment:', error);
  });
},


    // Confirm booking method
    async confirmBooking() {
      if (!this.selectedPaymentMethod) {
        alert('Please select a payment method');
        return;
      }

      try {
        if (this.selectedPaymentMethod === 'stripe') {
          const { paymentMethod, error } = await this.stripe.createPaymentMethod({
            type: 'card',
            card: this.cardElement,
          });

          if (error) {
            this.stripeError = error.message;
            return;
          }

          // Call backend to create PaymentIntent and return client secret
          const response = await this.$store.dispatch('appointments/confirmBooking', {
            id: this.id,
            payment_method: 'stripe',
            stripePaymentMethodId: paymentMethod.id,
          });

          if (response.error) {
            alert('Error: ' + response.error.message);
            return;
          }

          // Confirm the Stripe payment on the frontend
          const { paymentIntent, error: confirmError } = await this.stripe.confirmCardPayment(
            response.clientSecret,
            { payment_method: paymentMethod.id }
          );

          if (confirmError) {
            alert('Payment failed: ' + confirmError.message);
            return;
          }

          // After confirmation, we send the success status to the backend
          if (paymentIntent.status === 'succeeded') {
            // Inform backend that payment was successful
            const successResponse = await this.$store.dispatch('appointments/updateAppointmentStatus', {
              id: this.id,
              payment_status: 'paid',
              payment_method: 'stripe',
            });

            if (successResponse.success) {
              alert('Appointment confirmed and paid successfully!');
              this.$router.push({ name: 'AppointmentSummary', params: { id: this.id } }); // Passing the id of the appointment
            } else {
              alert('Error updating appointment status');
            }
          } else {
            alert('Payment was not successful');
          }
        } else {
          await this.$store.dispatch('appointments/confirmBooking', {
            id: this.id,
            payment_method: this.selectedPaymentMethod,
          });
          alert('Appointment confirmed successfully!');
          this.$router.push({ name: 'AppointmentSummary', params: { id: this.id } });
        }
      } catch (error) {
        console.error('Error confirming booking:', error);
        alert('Error confirming the appointment');
      }
    },
  },
};
</script>


<style scoped>
#card-element {
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 4px;
}
</style>
