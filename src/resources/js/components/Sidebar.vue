<template>
    <v-navigation-drawer v-model="drawer">
        <v-list nav>
            <v-list-item>
                <v-list-item-title>
                    <img :src="logo" alt="Logo" class="logo" />
                </v-list-item-title>
            </v-list-item>
            <!-- Loop through the menu items -->
            <v-list-item
                v-for="(item, index) in menuItems"
                :key="index"
                :to="item.route"
                :exact="true"
                active-class="active-sidebar-item"
            >
                
                <!-- Title of the item -->
                <v-list-item-title>
                    <v-icon>{{ item.icon }}</v-icon>
                    {{ item.title }}
                </v-list-item-title>
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
            logo,
            // Array of menu items
            menuItems: [
                { title: 'Dashboard', icon: 'mdi-view-dashboard', route: '/dashboard' },
                { title: 'User Management', icon: 'mdi-account', route: '/dashboard/users' },
                { title: 'Settings', icon: 'mdi-cog', route: '/dashboard/settings' },
            ],
        };
    }
  };
  </script>
  
<style scoped>
    .logo {
        max-width: 205px;
        padding: 1%;
    }
</style>