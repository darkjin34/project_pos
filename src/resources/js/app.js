import 'bootstrap/dist/css/bootstrap.min.css'; // Keep Bootstrap if needed
import '@mdi/font/css/materialdesignicons.css';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';
import store from './store'; 

// Import Vuetify
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

import { toast } from 'vue3-toastify';
import "vue3-toastify/dist/index.css"

const vuetify = createVuetify({
  components,
  directives,
});

const app = createApp(App);
app.config.globalProperties.$axios = axios;

app.use(router);
app.use(vuetify);
app.use(store);
app.config.globalProperties.$toast = toast;

app.mount('#app');