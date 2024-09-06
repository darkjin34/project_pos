<template>
    <div class="d-flex align-center justify-center" style="height: 100vh; padding-top: 10%">
        <v-sheet width="400" class="mx-auto">  
            <!-- Card for Register -->
            <v-card class="mt-5">
                <v-card-title class="text-center">
                    <h3>Register</h3>
                </v-card-title>
                <v-card-text>
                    <v-form v-model="valid" @submit.prevent="register" ref="form">
        
                        <!-- Name Input -->
                        <v-text-field
                            v-model="name"
                            label="Name"
                            type="text"
                            placeholder="Enter your name"
                            :rules="[nameRule]"
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
                            :rules="emailRules"
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
                            :rules="[passwordRule]"
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
                            :rules="[passwordMatchRule]"
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
                            :disabled="!valid || isSubmitting" 
                        >
                            {{ buttonText }}
                        </v-btn>

                        <!-- Alert for errors -->
                        <v-alert v-if="error !== null" type="error" dismissible>
                            <strong>{{ error }}</strong>
                        </v-alert>
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
        valid: false, // To track form validation status
        buttonText: 'Register',
        emailRules: [
            v => !!v || 'Email is required', // Checks if value exists
            v => /.+@.+\..+/.test(v) || 'Email must be valid' // Checks for a valid email format
        ],
      };
    },
    computed: {
        nameRule() {
            return value => !!value || 'Name is required';
        },
        passwordRule() {
            return value => !!value || 'Password is required';
        },
        passwordMatchRule() {
            return value => value === this.password || 'Passwords must match';
        },
    },
    methods: {
      async register() {
            // Check if form is valid
            const isValid = this.$refs.form.validate();
            if (!isValid) {
                return;
            }
    
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
                this.$router.push('/login'); // Redirect to login after successful registration
            } catch (error) {
                this.error = error.response?.data.error || 'Registration failed';
                console.error('Error during registration:', error.response.data);
            } finally {
                this.isSubmitting = false;
                this.buttonText = 'Register'; // Reset button text
            }
        },
    },
  };
</script>
  
<style scoped>
/* Add styles specific to the registration form */
</style>