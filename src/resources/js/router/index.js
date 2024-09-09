// src/router/index.js
import { createRouter, createWebHashHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import Dashboard from '../components/Dashboard.vue';
import AdminDashboard from '../components/AdminDashboard.vue';
import Products from '../components/admin/Products.vue';

import DefaultLayout from '../layouts/DefaultLayout.vue';
import AuthLayout from '../layouts/AuthLayout.vue'
import CashierLayout from '../layouts/CashierLayout.vue'

import UserManagement from '../components/UserManagement.vue';
import Settings from '../components/Settings.vue';
import store from '../store';

function isAuthenticated() {
    return store.getters.isAuthenticated; // This should use Vuex store getter
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
                if (store.getters.getRoles.includes('admin')) {
                    next('/admin-dashboard');
                } else {
                    next('/dashboard');
                }
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
                if (store.getters.getRoles.includes('admin')) {
                    next('/admin-dashboard');
                } else {
                    next('/dashboard');
                }
            } else {
            next(); // Proceed to register
            }
        },
    },
    {
        path: '/dashboard',
        component: CashierLayout,
        children: [
            {
                path: '',
                name: 'Dashboard',
                component: Dashboard,
            },
        ],
        meta: { requiresAuth: true, role: 'cashier' }
    },
    {
        path: '/users',
        component: DefaultLayout,
        children: [
            {
                path: '',
                name: 'UserManagement',
                component: UserManagement,
            },
        ],
        meta: { requiresAuth: true, role: 'admin' }
    },
    {
        path: '/settings',
        component: DefaultLayout,
        children: [
            {
                path: '',
                name: 'Settings',
                component: Settings,
            },
        ],
        meta: { requiresAuth: true, role: 'admin' }
    },
    {
        path: '/admin-dashboard',
        component: DefaultLayout,
        children: [
            {
                path: '',
                name: 'AdminDashboard',
                component: AdminDashboard,
            },
        ],
        meta: { requiresAuth: true, role: 'admin' }
    },
    {
        path: '/products',
        component: DefaultLayout,
        children: [
            {
                path: '',
                name: 'Products',
                component: Products,
            },
        ],
        meta: { requiresAuth: true, role: 'admin' }
    },
    {
        path: '/',
        redirect: '/login', // Default to login if no path is provided
    },
    {
        path: '/not-authorized',
        component: () => import('../components/NotAuthorized.vue'), // Add this if necessary
        name: 'NotAuthorized',
    },
    {
        path: '/:catchAll(.*)',
        component: () => import('../components/NotFound.vue'), // 404 component
        name: 'NotFound',
    }
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

// Global navigation guard for role-based protection
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.isAuthenticated) {
            next('/login');
        } else if (to.meta.role && !store.getters.getRoles.includes(to.meta.role)) {
            next('/not-authorized');
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;