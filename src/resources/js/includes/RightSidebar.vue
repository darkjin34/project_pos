<template>
  <v-navigation-drawer
    v-model="rightDrawer"
    location="right"
    app
    width="300"
  >
    <v-row class="pa-2 mt-4 mr-2">
      <h1>Cart</h1>
    </v-row>
    <!-- Order Type Buttons -->
    <v-row class="pa-2 mt-4 mr-2">
      <v-btn-toggle v-model="orderType" mandatory>
        <v-btn value="delivery" color="primary">Delivery</v-btn>
        <v-btn value="dine-in">Dine in</v-btn>
        <v-btn value="take-away">Take away</v-btn>
      </v-btn-toggle>
    </v-row>

    <!-- Cart Items -->
    <v-sheet class="pa-4 mr-2" elevation="2">
      <v-list dense>
        <v-list-item v-for="order in $store.state.orders" :key="order.name" class="d-flex">
          <!-- Product Image -->
          <v-img :src="`/storage/${order.image}`" max-width="70" max-height="70" class="mr-3"></v-img>
          <!-- Product Details -->
          <v-list-item-content>
            <v-list-item-title>
              {{ order.name }} <span v-if="order.temperature">({{ order.temperature }})</span>
            </v-list-item-title>
            <v-list-item-subtitle>{{ order.size }}</v-list-item-subtitle>
          </v-list-item-content>

          <!-- Price and Quantity Controls -->
          <v-list-item-content>
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
          </v-list-item-content>
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
      <v-btn class="mt-4" color="orange" @click="placeOrder">
        Place an order
      </v-btn>
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
    placeOrder() {
      // Handle order placement logic
      console.log("Order placed!");
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