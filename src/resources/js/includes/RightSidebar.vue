<template>
    <v-navigation-drawer
        v-model="rightDrawer"
        right
        app
        permanent
        >
        <v-sheet class="pa-4" elevation="2">
            <v-list dense>
            <v-list-item v-for="order in orders" :key="order.name">
                <v-list-item-title>{{ order.name }}</v-list-item-title>
                <v-list-item-subtitle>Price: ${{ order.price }}</v-list-item-subtitle>
            </v-list-item>
            </v-list>

            <!-- Total and Change -->
            <v-divider></v-divider>
            <v-row>
            <v-col>Total:</v-col>
            <v-col class="text-right">${{ total }}</v-col>
            </v-row>
            <v-row>
            <v-col>Change:</v-col>
            <v-col class="text-right">${{ change }}</v-col>
            </v-row>

            <!-- Place Order Button -->
            <v-btn class="mt-4" color="primary" @click="placeOrder">
            Place Order
            </v-btn>
        </v-sheet>
    </v-navigation-drawer>
</template>

<script>
export default {
  data() {
    return {
      // Example data
      orders: [
        { name: "Order 1", price: 10 },
        { name: "Order 2", price: 15 },
      ],
      total: 25,
      change: 5,
      rightDrawer: true
    };
  },
  methods: {
    placeOrder() {
      // Handle order placement logic
      console.log("Order placed!");
    },
  },
};
</script>

<style scoped>
/* Add any custom styling if needed */
</style>