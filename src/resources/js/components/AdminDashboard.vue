<template>
    <v-container>
      <v-row>
        <v-col>
          <h1>Welcome to the ADMIN <p  v-if="$store.state.user">{{ $store.state.user.name }}</p></h1>
          <p>This is the main content area of the admin dashboard.</p>
          <!-- Add more dashboard content here -->
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script>
  export default {
    name: 'AdminDashboard',
  };
  </script>
  
  <style scoped>
  /* Add styles specific to the dashboard */
  </style>