// src/router/index.js
import { createRouter, createWebHashHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import Home from '../components/Home.vue';
import Dashboard from '../components/Dashboard.vue';

const routes = [
  { name: 'home', path: '/', component: Home },
  { name: 'login', path: '/login', component: Login },
  { name: 'register', path: '/register', component: Register },
  { name: 'dashboard', path: '/dashboard', component: Dashboard },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;