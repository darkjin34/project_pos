<template>
    <v-footer app>
      <v-row justify="center">
        <v-col cols="12" class="text-center">
          <p>&copy; {{ new Date().getFullYear() }} My App. All Rights Reserved.</p>
        </v-col>
      </v-row>
    </v-footer>
  </template>
  
  <script>
  export default {
    data() {
      return {};
    },
  };
  </script>
  
  <style scoped>
  /* Add any styles for the footer */
  </style>