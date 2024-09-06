<template>
    <v-navigation-drawer v-model="drawer" app dark
    permanent>
        <v-list>
            <v-list-item>
                <v-list-item-title>
                    <img :src="logo" alt="Logo" class="logo" />
                </v-list-item-title>
            </v-list-item>
            <v-list-item to="/dashboard">
            <v-list-item-title>Dashboard</v-list-item-title>
            </v-list-item>

            <v-list-item to="/dashboard/users">
            <v-list-item-title>User Management</v-list-item-title>
            </v-list-item>
        </v-list>
        </v-navigation-drawer>
  </template>
  
  <script>
  import logo from '../../images/logo.png';

  export default {
    data() {
        return {
            drawer: true, // Controls sidebar visibility
            logo
        };
    }
  };
  </script>
  
<style scoped>
    .logo {
        max-width: 200px;
        padding: 2%;
    }
</style>