import './bootstrap.js'; // Bootstrap dependencies (like axios, etc.)
import { createApp } from 'vue'; // Import createApp from Vue
import App from './App.vue'; // Import the root component
import router from './router/index.js'; // Import the router
import store from './store/index.js'; // Import the store

// Create the app instance
const app = createApp(App);

// Use the router and store
app.use(router);
app.use(store);

// Mount the app to the DOM
app.mount('#app');
