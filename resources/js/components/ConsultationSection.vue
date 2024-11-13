<template>
  <section>
    <div 
      class="consultation-background" 
      :style="{
        backgroundImage: `url(${consultationContent?.image_path ? `/storage/${consultationContent.image_path}` : ''})`,
        backgroundSize: 'cover',
        backgroundPosition: 'center'
      }"
    >
      <div class="overlay"></div> <!-- Grey overlay -->
      <div class="consultation-content">
        <h2>{{ consultationContent?.title }}</h2>
        <p>{{ consultationContent?.text }}</p>
   
        <!-- Phone Number Button -->
        <button v-if="consultationContent?.phone_number" class="phone-button" @click="callPhoneNumber">
          <span class="material-icons">phone</span> <!-- Material Icons phone icon -->
          {{ formatPhoneNumber(consultationContent.phone_number) }}
        </button>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  computed: {
    ...mapGetters('contentBlock', ['consultationContent']),
  },
  methods: {
    ...mapActions('contentBlock', ['fetchConsultationContent']),
    
    callPhoneNumber() {
      const phoneNumber = this.consultationContent.phone_number;
      if (phoneNumber) {
        window.location.href = `tel:${phoneNumber}`; // Open dialer with phone number
      }
    },

    formatPhoneNumber(phoneNumber) {
      const cleanedNumber = phoneNumber.replace(/\D/g, ''); // Remove non-digit characters

      // Example format logic based on common length patterns
      if (cleanedNumber.length === 10) {
        // Format for local numbers (assumes 0XX-XXXXXXX)
        return `${cleanedNumber.slice(0, 3)} ${cleanedNumber.slice(3, 6)} ${cleanedNumber.slice(6)}`;
      } else if (cleanedNumber.length === 12 && cleanedNumber.startsWith('212')) {
        // Format for international numbers (assumes +212 12 XX XX XX)
        return `+${cleanedNumber.slice(0, 3)} ${cleanedNumber.slice(3, 5)} ${cleanedNumber.slice(5, 8)} ${cleanedNumber.slice(8)}`;
      }
      // Default return the cleaned number if no format applies
      return phoneNumber; 
    },
  },
  created() {
    this.fetchConsultationContent();
  },
};
</script>

<style scoped>
.consultation-section {
  padding: 60px 20px; /* Section padding */
}

.consultation-background {
  position: relative; /* Positioning for the overlay */
  width: 100%; /* Full width */
  height: 400px; /* Fixed height for the banner */
  color: white; /* Text color */
  display: flex; /* Flexbox layout for centering content */
  justify-content: center; /* Center content horizontally */
  align-items: center; /* Center content vertically */
  text-align: center; /* Center text */
  margin: 0; /* Reset margin */
}

.overlay {
  position: absolute; /* Overlay position */
  top: 0; /* Start from the top */
  left: 0; /* Start from the left */
  right: 0; /* End on the right */
  bottom: 0; /* End at the bottom */
  background-color: rgba(128, 128, 128, 0.6); /* Grey background with opacity */
  z-index: 1; /* Place overlay above the image */
}

.consultation-content {
  position: relative; /* Positioning for content above overlay */
  z-index: 2; /* Ensure content is above overlay */
  padding: 20px; /* Inner padding */
  display: flex; /* Flex for centering content */
  flex-direction: column; /* Stack elements vertically */
  align-items: center; /* Center items horizontally */
}

.cta-button {
  background-color: #36A0F4; /* Button color */
  color: white; /* Button text color */
  border: none; /* No border */
  padding: 10px 20px; /* Padding for button */
  border-radius: 5px; /* Rounded corners */
  font-size: 1.2rem; /* Font size for button */
  cursor: pointer; /* Pointer cursor */
  transition: background-color 0.3s; /* Smooth transition for hover effect */
}

.cta-button:hover {
  background-color: #007bb5; /* Darker blue on hover */
}

.phone-button {
  background-color: #2196F3; /* Green button color */
  color: white; /* Button text color */
  border: none; /* No border */
  padding: 10px 15px; /* Padding for button */
  border-radius: 5px; /* Rounded corners */
  font-size: 1.2rem; /* Font size for button */
  cursor: pointer; /* Pointer cursor */
  margin-top: 15px; /* Margin for spacing */
  display: flex; /* Flex for icon alignment */
  align-items: center; /* Center icon vertically */
  transition: background-color 0.3s; /* Smooth transition for hover effect */
}

.phone-button:hover {
  background-color: #0D6EFD; /* Darker green on hover */
}

.phone-button .material-icons {
  margin-right: 8px; /* Space between icon and text */
}
</style>
