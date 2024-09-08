<template>
  <div>
    <h1>Not Authorized</h1>
    <p>You do not have permission to access this page.</p>
    <v-btn @click="goToDashboard">Go Back to Dashboard</v-btn>
  </div>
</template>

<script>
export default {
  methods: {
    goToDashboard() {
      if (this.$store.getters.isAuthenticated) {
        if (this.$store.getters.getRoles.includes('admin')) {
            this.$router.push('/admin-dashboard');
        } else {
            this.$router.push('/dashboard');
        }
      } else {
        this.$router.push('/login');
      }
    }
  }
};
</script>