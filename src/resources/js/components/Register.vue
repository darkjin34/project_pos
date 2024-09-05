<template>
    <div class="d-flex align-center justify-center" style="height: 100vh">
        <v-sheet width="400" class="mx-auto">
            <!-- Alert for errors -->
            <v-alert v-if="error !== null" type="error" dismissible>
            <strong>{{ error }}</strong>
            </v-alert>

            <!-- Logo section
            <v-card-title class="text-center">
                <img src="@/assets/logo.png" alt="Logo" class="logo" />
            </v-card-title> -->

            <!-- Card for Register -->
            <v-card class="mt-5">
                <v-card-title class="text-center">
                    <h3>Register</h3>
                </v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="register">

                    <!-- Name Input -->
                    <v-text-field
                        v-model="name"
                        label="Name"
                        type="text"
                        placeholder="Enter your name"
                        required
                        outlined
                        :disabled="isSubmitting"
                    ></v-text-field>

                    <!-- Email Input -->
                    <v-text-field
                        v-model="email"
                        label="Email"
                        type="email"
                        placeholder="Enter your email"
                        required
                        outlined
                        :disabled="isSubmitting"
                    ></v-text-field>

                    <!-- Password Input -->
                    <v-text-field
                        v-model="password"
                        label="Password"
                        type="password"
                        placeholder="Enter your password"
                        required
                        outlined
                        :disabled="isSubmitting"
                    ></v-text-field>

                    <!-- Password Confirmation Input -->
                    <v-text-field
                        v-model="password_confirmation"
                        label="Password Confirmation"
                        type="password"
                        placeholder="Confirm your password"
                        required
                        outlined
                        :disabled="isSubmitting"
                    ></v-text-field>

                    <!-- Submit Button -->
                    <v-btn
                        :loading="isSubmitting"
                        block
                        color="primary"
                        type="submit"
                    >
                        {{ buttonText }}
                    </v-btn>
                    </v-form>
                    <div class="mt-2 align-center justify-center">
                        <p class="text-body-2">Already have an account? <router-link to="/login">Login</router-link></p>
                    </div>
                </v-card-text>
            </v-card>
        </v-sheet>
    </div>
  </template>
  
<script>
import axios from '../axios';

export default {
  name: "Register",
  data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        error: null,
        isSubmitting: false,
        buttonText: 'Register'
      };
  },
  methods: {
    async register() {
        this.isSubmitting = true;
        this.buttonText = 'Loading...';
        try {
            await axios.get('/sanctum/csrf-cookie'); // Get CSRF cookie
            const response = await axios.post('/api/register', {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
            });
            console.log('Registration successful:', response.data);
            this.$router.go('/login')
        } catch (error) {
            this.error =  error.response?.data.error || 'Registration failed';
            console.error('Error during registration:', error.response.data);
        }
    },
    },
    mounted() {
        if (window.Laravel.isLoggedIn) {
        this.$router.push('/dashboard');
        }
    },
};
</script>