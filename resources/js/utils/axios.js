import axios from 'axios';

// Create an Axios instance
const axiosInstance = axios.create({
  baseURL: process.env.MIX_API_URL || 'http://localhost', // Adjust baseURL as needed
  timeout: 20000, // Optional: Set a timeout for requests
});

// Add an interceptor to handle requests and responses if necessary
axiosInstance.interceptors.request.use(
  config => {
    // Add any headers or configurations here
    // For example, adding the Authorization token if logged in
    const token = localStorage.getItem('user-token'); // or get it from Vuex store
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    // Handle the error
    return Promise.reject(error);
  }
);

axiosInstance.interceptors.response.use(
  response => {
    return response;
  },
  error => {
    // Handle errors globally
    return Promise.reject(error);
  }
);

export default axiosInstance;
