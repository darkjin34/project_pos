<template>
    <div class="row">
        Welcome to Dashboard
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        data() {
            return {
                name: ""
            }
        },
        mounted() {
        if (!window.Laravel.isLoggedIn) {
            this.$router.push('/login');
        }
        }
    }
</script>