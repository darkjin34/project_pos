  <template>
      <!-- App Bar (Header) -->
      <v-app-bar app>
        <v-toolbar-title>POS System</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn @click="logout" v-if="isAuthenticated">Logout</v-btn>
      </v-app-bar>
  </template>
  
  <script>
  import { mapGetters } from 'vuex';

  export default {
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
  /* Add any styles for the header */
  </style>