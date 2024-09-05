<template>
    <div id="app">
      <div class="container">
        <nav
          class="navbar navbar-expand-sm navbar-light bg-light"
        >
          <a class="navbar-brand" href="#">Laravel Vue 3</a>
          <button
            class="navbar-toggler d-lg-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsibleNavId"
            aria-controls="collapsibleNavId"
            aria-expanded="false"
            aria-label="Toggle navigation"
          ></button>
          <div class="navbar-nav" v-if="isLoggedIn">
            <router-link to="/dashboard">Dashboard</router-link>
            <button type="button"class="btn nav-item nav-link" @click="handleLogout">Logout</button>
          </div>
          <div class="navbar-nav" v-else>
            <router-link to="/">Home</router-link>
            <router-link to="/login">Login</router-link>
            <router-link to="/register">Register</router-link>
          </div>
        </nav>
        
      </div>
      <router-view></router-view>
    </div>
  </template>
  
  <script>
  import axios from './axios';

  export default {
    name: "App",
    data() {
      return {
        isLoggedIn: false, // Manage the login state
      };
    },
    created(){
      if(window.Laravel.isLoggedIn){
        this.isLoggedIn = true
      }
    },
    methods: {
      handleLogout(e) {
        e.preventDefault();
        axios.get('/sanctum/csrf-cookie').then(response => {
          axios.post('api/logout')
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
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add any styles you want here */
  </style>