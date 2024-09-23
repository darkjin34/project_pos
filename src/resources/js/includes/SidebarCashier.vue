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
                color="primary"
                variant="plain"
            >
                
                <!-- Title of the item -->
                <v-list-item-title>
                    <v-icon>{{ item.icon }}</v-icon>
                    {{ item.title }}
                </v-list-item-title>
            </v-list-item>
        </v-list>
        <template v-slot:append>
          <div class="pa-2">
            <v-btn block @click="logout" v-if="isAuthenticated">
              Logout
            </v-btn>
          </div>
        </template>
    </v-navigation-drawer>
</template>
  
  <script>
  import logo from '../../images/logo.png';
  import { mapGetters } from 'vuex';
  
  export default {
    data() {
        return {
            drawer: true, // Controls sidebar visibility
            logo,
            // Array of menu items
            menuItems: [
                { title: 'New Order', icon: 'mdi-view-dashboard', route: '/dashboard' },
                { title: 'My Orders', icon: 'mdi-account', route: '/users' },
                { title: 'History', icon: 'mdi-cog', route: '/settings' },
            ],
        };
    },
    computed: {
      ...mapGetters(['isAuthenticated', 'getUser', 'getRoles']),
    },
    methods: {
      logout(e) {
        e.preventDefault();
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
          this.$axios.post('api/logout')
            .then(response => {
              if(response.data.success) {
                 // After successful login, set the login state
                 this.$store.dispatch('logout');
                 location.reload()
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
    .logo {
        max-width: 205px;
        padding: 1%;
    }
</style>