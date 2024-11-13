<template>
  <div class="mt-5">
    <h2 class="mb-5 text-center font-weight-bold">Our Professional Services</h2>
    <div class="row">
      <div class="col-md-4" v-for="service in allServices" :key="service.id">
        <div class="card mb-4 shadow-lg rounded">
          <!-- Service Image -->
          <img v-if="service.image" :src="'/storage/' + service.image" class="card-img-top rounded-top" alt="Service Image" />
          <div class="card-body">
            <h5 class="card-title text-center">{{ service.name }}</h5>
            <p class="card-text text-muted">{{ service.description }}</p>
            <div class="d-flex justify-content-between">
              <p class="card-text"><strong>Cost:</strong> {{ formattedCost(service.cost) }} MAD</p>
              <p class="card-text"><strong>Duration:</strong> {{ service.duration }} minutes</p>
            </div>
         
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  computed: {
    ...mapGetters('services', ['allServices']),
  },
  created() {
    this.fetchServices();
  },
  methods: {
    ...mapActions('services', ['fetchServices']),
    formattedCost(cost) {
      return parseFloat(cost).toFixed(2);
    },
  },
};
</script>

<style scoped>
/* Container for the Service List */
.card {
  border: none;
  border-radius: 15px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-10px);
  box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
}

/* Service Image */
.card-img-top {
  object-position: center !important;
  border-radius: 15px 15px 0 0;
  height:150px;
}

/* Card Body */
.card-body {
  background-color: #f7f7f7;
  padding: 20px;
  text-align: center;
}

.card-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 15px;
}

.card-text {
  font-size: 14px;
  color: #777;
  line-height: 1.5;
}

/* Button Styling */
.btn-primary {
  background-color: #2196F3;
  border: none;
  padding: 10px 20px;
  border-radius: 25px;
  color: white;
  text-decoration: none;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-primary:hover {
  background-color: #1976D2;
  transform: scale(1.05);
}

/* Responsiveness */
@media (max-width: 767px) {
  .card-img-top {
    height: 180px;
  }

  .card-body {
    padding: 15px;
  }

  .btn-primary {
    padding: 8px 15px;
  }
}
</style>
