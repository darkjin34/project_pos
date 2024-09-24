<template>
    <v-app>
        
        <!-- Sidebar Component -->
        <Sidebar />

        <!-- Main Layout Wrapper -->
        <Header />


        <!-- Main Content Area -->
        <v-main>
        <v-container fluid class="fill-height d-flex flex-column">
            <router-view />
        </v-container>
        </v-main>

        <!-- Footer Component -->
        <Footer />
    </v-app>
  </template>
  
<script>
    import Header from '@/includes/Header.vue';
    import Footer from '@/includes/Footer.vue';
    import Sidebar from '@/includes/SidebarCashier.vue';

    export default {
        name: 'DefaultLayout',
        components: {
            Header,
            Footer,
            Sidebar
        }
    };
</script>
  
<style scoped>
    .fill-height {
    min-height: 100vh;
    }

    .v-main {
    padding-top: 64px; /* Adjust based on the height of your header */
    padding-bottom: 64px; /* Adjust based on the height of your footer */
    }
</style>