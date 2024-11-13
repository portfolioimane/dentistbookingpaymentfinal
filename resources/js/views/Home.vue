<template>
  <div class="text-center">

    <!-- Hero Section -->
    <HeroSection />

    <!-- About Section -->
    <AboutSection />

    <div id="services" class="my-5">
      <ServiceList />
    </div>

    <!-- Consultation Section -->
    <ConsultationSection />

    <!-- Testimonials Section -->
    <section id="testimonials" class="my-5">
      <h2 class="text-primary">Testimonials</h2>
      <div class="row">
        <div class="col-md-4 text-center">
          <div class="testimonial">
            <img src="https://via.placeholder.com/50" class="rounded-circle" alt="Reviewer" />
            <h5>⭐⭐⭐⭐⭐</h5>
            <p class="mb-0">"I had a fantastic experience! The staff was friendly, and Dr. [Dentist's Name] made me feel comfortable throughout the process."</p>
            <footer class="blockquote-footer">Satisfied Patient</footer>
          </div>
        </div>
        <div class="col-md-4 text-center">
          <div class="testimonial">
            <img src="https://via.placeholder.com/50" class="rounded-circle" alt="Reviewer" />
            <h5>⭐⭐⭐⭐⭐</h5>
            <p class="mb-0">"Highly recommend! Professional service and a welcoming environment. My smile has never looked better!"</p>
            <footer class="blockquote-footer">Happy Customer</footer>
          </div>
        </div>
        <div class="col-md-4 text-center">
          <div class="testimonial">
            <img src="https://via.placeholder.com/50" class="rounded-circle" alt="Reviewer" />
            <h5>⭐⭐⭐⭐⭐</h5>
            <p class="mb-0">"Excellent care and attention to detail. I will definitely return!"</p>
            <footer class="blockquote-footer">Regular Visitor</footer>
          </div>
        </div>
      </div>
    </section>

    <footer class="my-4">
      <p class="text-muted">
        &copy; 2024 Dentist Booking System | <a href="#">Privacy Policy</a>
      </p>
    </footer>
  </div>
</template>

<script>
import ServiceList from '../components/ServiceList.vue';
import HeroSection from '../components/HeroSection.vue';
import AboutSection from '../components/AboutSection.vue';
import ConsultationSection from '../components/ConsultationSection.vue';

import { useRouter } from 'vue-router';

export default {
  components: {
    ServiceList,
    HeroSection,
    AboutSection,
    ConsultationSection,
  },
  setup() {
    const router = useRouter();

    const navigateToServices = () => {
      router.push('/services');
    };

    return {
      navigateToServices,
    };
  },
};
</script>

<style>
/* Add home view styles here */


.lead {
  margin: 20px 0;
}

footer {
  margin-top: 50px;
  font-size: 0.9em;
}

.about-section {
  margin: 3rem 0;
}

.consultation-section {
  background-image: url('https://images.pexels.com/photos/3060720/pexels-photo-3060720.jpeg'); /* Background image for consultation section */
  background-size: cover;
  background-position: center;
  color: white;
  padding: 60px 20px; /* Padding for better spacing */
}

.consultation-content {
  max-width: 600px;
  margin: auto;
  text-align: center;
}

blockquote {
  margin: 20px 0;
  border-left: 4px solid #007bff; /* Stylish left border */
}

h2 {
  color: #007bff; /* Consistent color for headings */
}

img {
  max-width: 100%; /* Ensure images are responsive */
  height: auto; /* Maintain aspect ratio */
}

.my-5 {
  margin: 3rem 0; /* Consistent spacing */
}

.testimonial {
  border: 1px solid #007bff; /* Optional border for testimonials */
  padding: 15px;
  border-radius: 5px; /* Rounded corners */
  margin: 15px 0; /* Margin between testimonials */
}
</style>
