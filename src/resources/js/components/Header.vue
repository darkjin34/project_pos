<template>
    <v-app-bar app>
      <v-toolbar-title>My App</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn @click="logout" v-if="isAuthenticated">Logout</v-btn>
    </v-app-bar>
  </template>
  
  <script>
  export default {
    computed: {
      isAuthenticated() {
        return !!window.Laravel.isLoggedIn;
      },
    },
    methods: {
      logout(e) {
        e.preventDefault();
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
          this.$axios.post('api/logout')
            .then(response => {
              if(response.data.success) {
                 // After successful login, set the login state
                window.Laravel.isLoggedIn = false;
                window.location.href="/"
              }else{
                console.log(response)
              }
            })
        }).catch(function (error) {
          console.error(error)
        })
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any styles for the header */
  </style>