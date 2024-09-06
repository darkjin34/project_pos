import 'bootstrap/dist/css/bootstrap.min.css'; // Keep Bootstrap if needed
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';

// Import Vuetify
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
  components,
  directives,
});

const app = createApp(App);
app.config.globalProperties.$axios = axios;

app.use(router);
app.use(vuetify); // Use Vuetify in your app

app.mount('#app');