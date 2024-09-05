<template>
    <div class="row">
        Welcome to Home
    </div>
</template>

<script>
    export default {
        name: "Home",
        data() {
            return {
                name: ""
            }
        },
        mounted() {
        if (window.Laravel.isLoggedIn) {
            this.$router.push('/dashboard');
        }
        }
    }
</script>