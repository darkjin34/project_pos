<template>
  <v-navigation-drawer
    v-model="rightDrawer"
    location="right"
    app
    width="300"
  >
    <v-row class="pa-2 mx-2 mt-2">
      <h1>Cart</h1>
    </v-row>
    <!-- Order Type Buttons -->
    <v-row class="pa-2 mx-2">
      <v-btn-toggle v-model="orderType" mandatory>
        <v-btn value="delivery" color="primary" size="small">Delivery</v-btn>
        <v-btn value="dine-in" size="small">Dine in</v-btn>
        <v-btn value="take-away" size="small">Take away</v-btn>
      </v-btn-toggle>
    </v-row>

    <!-- Cart Items -->
    <v-sheet class="pa-4 mx-2" elevation="2">
      <v-list dense>
        <v-list-item v-for="order in $store.state.orders" :key="order.name" class="d-flex mx-1">
          <!-- Product Image -->
          <v-img :src="`/storage/${order.image}`" max-width="70" max-height="70" class="mr-3"></v-img>
          <!-- Product Details -->
            <v-list-item-title>
              {{ order.name }} <span v-if="order.temperature">({{ order.temperature }})</span>
            </v-list-item-title>
            <v-list-item-subtitle>{{ order.size }}</v-list-item-subtitle>

          <!-- Price and Quantity Controls -->
            <v-row align="center">
              <v-col>
                <span>${{ order.price }}</span>
              </v-col>
              <v-col class="text-right d-flex align-center">
                <v-icon @click="decrement(order)">mdi-minus</v-icon>
                <span class="mx-2">{{ order.quantities }}</span>
                <v-icon @click="increment(order)">mdi-plus</v-icon>
              </v-col>
            </v-row>
        </v-list-item>
      </v-list>

      <!-- Divider -->
      <v-divider></v-divider>

      <!-- Items and Discounts -->
      <v-row class="mr-2">
        <v-col>Items</v-col>
        <v-col class="text-right">${{ totalItemsPrice }}</v-col>
      </v-row>
      <v-row>
        <v-col>Discounts</v-col>
        <v-col class="text-right text-success">-${{ discount }}</v-col>
      </v-row>

      <!-- Total -->
      <v-row>
        <v-col>Total</v-col>
        <v-col class="text-right text-h6 text-primary">${{ totalPrice }}</v-col>
      </v-row>

      <!-- Place Order Button -->
      <v-btn class="mt-4" block color="orange" @click="placeOrder">
        <template v-slot:default>
          <v-progress-circular
            v-if="loading"
            indeterminate
            color="white"
            size="20"
          ></v-progress-circular>
          <span v-else>Place Order</span>
        </template>
      </v-btn>

      <!-- Snackbar for success notification -->
      <v-snackbar v-model="snackbarVisible" timeout="3000">
        {{ snackbarMessage }}
      </v-snackbar>
      <v-overlay :value="loading" absolute>
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
    </v-sheet>
  </v-navigation-drawer>
</template>

<script>
export default {
  data() {
    return {
      rightDrawer: true,
      orderType: "delivery", // To handle the order type
      discount: 0, // Example discount
      snackbarVisible: false,
      snackbarMessage: '',
      loading: false
    };
  },
  computed: {
    totalItemsPrice() {
      return this.$store.state.orders.reduce((total, product) => {
        const quantity = product.quantities || 1; // Default to 1 if not set
        return total + product.price * quantity;
      }, 0);
    },
    totalPrice() {
      return this.totalItemsPrice - this.discount;
    },
  },
  methods: {
    increment(order) {
      order.quantities += 1;
    },
    decrement(order) {
      if (order.quantities > 1) order.quantities -= 1;
    },
    async placeOrder() {
      this.loading = true;
      try {
        const response = await this.$axios.post('/api/orders', {
          customer_name: 'Walk-In Customer',
          total_price: this.totalItemsPrice,
          order_items: this.$store.state.orders,
        });

        console.log(response.data.message); // Order placed successfully
        this.snackbarMessage = response.data.message;
        this.snackbarVisible = true;
        this.$store.dispatch('resetOrder');
      } catch (error) {
        console.error('Error placing order:', error);
      } finally {
        this.loading = false; // Stop the loading spinner
      }
    },
  },
};
</script>

<style scoped>
.text-right {
  text-align: right;
}

.text-primary {
  color: #ff6d00; /* Match the orange for total */
}

.text-success {
  color: #00c853; /* Green for discounts */
}

.mx-2 {
  margin-left: 8px;
  margin-right: 8px;
}
</style>