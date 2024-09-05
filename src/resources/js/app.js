import 'bootstrap/dist/css/bootstrap.min.css'; // Keep Bootstrap if needed
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';

// Import Vuetify
import vuetify from './plugins/vuetify';

const app = createApp(App);
app.config.globalProperties.$axios = axios;

app.use(router);
app.use(vuetify); // Use Vuetify in your app

app.mount('#app');