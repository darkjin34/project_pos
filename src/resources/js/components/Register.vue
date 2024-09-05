<template>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="alert alert-danger alert dismissable fade show" v-if="error !== null">
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ error }}</strong>
          </div>
          <div class="card mt-5">
            <div class="card-header">
              <h3 class="text-center">Register</h3>
            </div>
            <div class="card-body">
              <form @submit.prevent="register">
                <div class="form-group mb-3">
                  <label for="name">Name</label>
                  <input v-model="name" type="text" id="name" class="form-control" placeholder="Enter your name" required />
                </div>
                <div class="form-group mb-3">
                  <label for="email">Email</label>
                  <input v-model="email" type="email" id="email" class="form-control" placeholder="Enter your email" required />
                </div>
                <div class="form-group mb-3">
                  <label for="password">Password</label>
                  <input v-model="password" type="password" id="password" class="form-control" placeholder="Enter your password" required />
                </div>
                <div class="form-group mb-3">
                  <label for="password_confirmation">Confirm Password</label>
                  <input v-model="password_confirmation" type="password" id="password_confirmation" class="form-control" placeholder="Confirm your password" required />
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
              </form>
            </div>
          </div>
        </div>
      </div>
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
        error: null
      };
  },
  methods: {
      async register() {
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