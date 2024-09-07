<template>
    <div class="d-flex align-center justify-center" style="height: 100vh; padding-top: 10%">
        <v-sheet width="400" class="mx-auto">
            <!-- Card with logo and login form -->
            <v-card class="mt-5" elevation="3">
                <!-- Logo section -->
                <v-card-title class="text-center">
                    <img :src="logo" alt="Logo" class="logo" />
                </v-card-title>
                <!-- Login Form -->
                <v-card-text>
                    <v-form ref="form" v-model="valid" @submit.prevent="login">
                    <v-text-field
                        v-model="email"
                        label="Email"
                        :rules="emailRules"
                        type="email"
                        placeholder="Enter your email"
                        outlined
                        required
                    ></v-text-field>

                    <v-text-field
                        v-model="password"
                        label="Password"
                        type="password"
                        placeholder="Enter your password"
                        outlined
                        required
                    ></v-text-field>

                    <v-btn block color="primary" type="submit" :disabled="!valid || isSubmitting" :loading="isSubmitting">
                        {{ buttonText }}
                    </v-btn>

                    <v-alert v-if="error" type="error" class="mt-3">
                        {{ error }}
                    </v-alert>
                    </v-form>
                    <div class="mt-2 align-center justify-center">
                        <p class="text-body-2">You don't have an account? <router-link to="/register">Register</router-link></p>
                    </div>
                </v-card-text>
            </v-card>
        </v-sheet>
    </div>
</template>
  
  <script>
  import logo from '../../images/logo.png';

  export default {
    name: "Login",
    data() {
        return {
            email: '',
            password: '',
            error: null,
            isSubmitting: false,
            buttonText: 'Login',
            valid: false, // To track form validation status
            emailRules: [
                v => !!v || 'Email is required', // Checks if value exists
                v => /.+@.+\..+/.test(v) || 'Email must be valid' // Checks for a valid email format
            ],
            logo
        };
    },
    methods: {
      async login() {
        if (this.$refs.form.validate()) { 
            this.isSubmitting = true;
            this.buttonText = 'Loading...';
            try {
            // Retrieve the CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            await this.$axios.get('/sanctum/csrf-cookie'); // Get CSRF cookie
            const response = await this.$axios.post('/api/login', {
                email: this.email,
                password: this.password,
            }, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                // After successful login, set the login state
                window.Laravel.isLoggedIn = true;

                // Navigate to dashboard
                this.$router.go('/dashboard');
            } catch (error) {
                this.error =  error.response?.data.error || 'Login failed';
                console.error('Error during login:', error.response.data);
            } finally {
                this.isSubmitting = false;
                this.buttonText = 'Submit'; // Or update text based on success/failure
            }
        }
      },
    }
  };
  </script>

<style scoped>
.logo {
    max-width: 200px;
    margin-bottom: 20px;
    padding: 2%;
}
</style>