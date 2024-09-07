// src/router/index.js
import { createRouter, createWebHashHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import Dashboard from '../components/Dashboard.vue';
import DefaultLayout from '../layouts/DefaultLayout.vue';
import AuthLayout from '../layouts/AuthLayout.vue'
import UserManagement from '../components/UserManagement.vue';
import Settings from '../components/Settings.vue';

// Dummy function to check if user is authenticated
function isAuthenticated() {
    return window.Laravel.isLoggedIn; // Use your actual session/auth check logic
}

const routes = [
    {
        path: '/login',
        component: AuthLayout,
        children: [
            {
                path: '',
                name: 'Login',
                component: Login,
            },
        ],
        beforeEnter: (to, from, next) => {
            if (isAuthenticated()) {
            next('/dashboard'); // Redirect to dashboard if already logged in
            } else {
            next(); // Proceed to login
            }
        },
    },
    {
        path: '/register',
        component: AuthLayout,
        children: [
            {
                path: '',
                name: 'Register',
                component: Register,
            },
        ],
        beforeEnter: (to, from, next) => {
            if (isAuthenticated()) {
            next('/dashboard'); // Redirect to dashboard if already registered
            } else {
            next(); // Proceed to register
            }
        },
    },
    {
        path: '/dashboard',
        component: DefaultLayout,
        children: [
            {
                path: '',
                name: 'Dashboard',
                component: Dashboard,
            },
        ],
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
            next('/login'); // Redirect to login if not authenticated
            } else {
            next(); // Proceed to dashboard
            }
        },
    },
    {
        path: '/dashboard/users',
        component: DefaultLayout,
        children: [
            {
                path: '',
                name: 'UserManagement',
                component: UserManagement,
            },
        ],
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
            next('/login'); // Redirect to login if not authenticated
            } else {
            next(); // Proceed to dashboard Users
            }
        },
    },
    {
        path: '/dashboard/settings',
        component: DefaultLayout,
        children: [
            {
                path: '',
                name: 'Settings',
                component: Settings,
            },
        ],
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
            next('/login'); // Redirect to login if not authenticated
            } else {
            next(); // Proceed to dashboard Users
            }
        },
    },
    {
        path: '/',
        redirect: '/login', // Default to login if no path is provided
    },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;