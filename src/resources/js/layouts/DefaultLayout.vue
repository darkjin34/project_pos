<template>
    <v-app>
      <Header />
      
      <v-main>
        <router-view />
      </v-main>
      
      <Footer />
    </v-app>
  </template>
  
  <script>
  import Header from '@/components/Header.vue';
  import Footer from '@/components/Footer.vue';
  
  export default {
    name: 'DefaultLayout',
    components: {
      Header,
      Footer,
    },
  };
  </script>
  
  <style scoped>
  /* Add styles specific to the layout */
  </style>