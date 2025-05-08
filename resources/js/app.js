/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import EventSearch from './components/event/EventSearch.vue';
import EventCarousel from './Components/EventCarousel.vue';

/**
 * Configure axios
 */
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Mapbox token
const mapboxToken = import.meta.env.VITE_MAPBOX_TOKEN;
window.mapboxToken = mapboxToken;

/**
 * Create Vue application instances
 */

// Main app
const app = createApp({});
app.component('event-carousel', EventCarousel);

// Event search app
const eventSearchApp = createApp({});
eventSearchApp.component('event-search', EventSearch);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Mount applications to HTML elements
 */

// Main app
if (document.getElementById('app')) {
    app.mount('#app');
}

// Event search app
if (document.getElementById('event-search-app')) {
    eventSearchApp.mount('#event-search-app');
}
