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
            <h3 class="text-center">Login</h3>
          </div>
          <div class="card-body">
            <form @submit.prevent="login">
              <div class="form-group mb-3">
                <label for="email">Email</label>
                <input v-model="email" type="email" id="email" class="form-control" placeholder="Enter your email" required />
              </div>
              <div class="form-group mb-3">
                <label for="password">Password</label>
                <input v-model="password" type="password" id="password" class="form-control" placeholder="Enter your password" required />
              </div>
              <button type="submit" class="btn btn-primary w-100" :disabled="isSubmitting">{{ buttonText }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
  
  export default {
    name: "Login",
    data() {
      return {
        email: '',
        password: '',
        error: null,
        isSubmitting: false,
        buttonText: 'Login'
      };
    },
    methods: {
      async login() {
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
      },
    },
    mounted() {
      if (window.Laravel.isLoggedIn) {
        this.$router.push('/dashboard');
      }
    }
  };
  </script>