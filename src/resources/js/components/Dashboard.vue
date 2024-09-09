<template>
    <v-container fluid>
        <h2>Coffee Menu</h2>
        <v-row>
          <v-col cols="3" v-for="(item, index) in coffeeMenu" :key="index">
            <v-card class="pa-4" outlined>
                <!-- Product Image -->
                <v-img :src="item.image" height="150px" contain></v-img>

                <!-- Product Details -->
                <v-card-title class="d-flex justify-space-between">
                  {{ item.name }}
                  <span class="price">${{ item.price }}</span>
                </v-card-title>

                <v-card-subtitle>
                  {{ item.description }}
                </v-card-subtitle>

                <!-- Size Options -->
                <v-row class="mt-3">
                  <v-col cols="3">Size</v-col>
                  <v-col cols="9">
                    <v-btn-toggle v-model="selectedSize" class="size-options" mandatory>
                      <v-btn value="small" class="mx-1" depressed outlined>Small</v-btn>
                      <v-btn value="large" class="mx-1" depressed outlined>Large</v-btn>
                    </v-btn-toggle>
                  </v-col>
                </v-row>

                <!-- Quantity Selector -->
                <v-row class="mt-3">
                  <v-col cols="12" class="d-flex align-center justify-space-between">
                    <v-btn icon @click="decrement">
                      <v-icon>mdi-minus</v-icon>
                    </v-btn>
                    <span class="mr-1 ml-1">{{ quantity }}</span>
                    <v-btn icon @click="increment">
                      <v-icon>mdi-plus</v-icon>
                    </v-btn>
                  </v-col>
                </v-row>

                <!-- Add to Cart Button -->
                <v-btn
                  class="mt-4 orange lighten-2"
                  color="orange"
                  block
                  depressed
                  @click="addToCart"
                >
                  {{ addedToCart ? 'Added to cart' : 'Add to cart' }}
                </v-btn>
              </v-card>
          </v-col>
        </v-row>
      </v-container>
</template>
  
  <script>
  export default {
    name: 'Dashboard',
    data() {
      return {
        menuItems: [
          { title: 'Home page', icon: 'mdi-home' },
          { title: 'Menu', icon: 'mdi-coffee' },
          { title: 'My orders', icon: 'mdi-history' },
          { title: 'Settings', icon: 'mdi-cog' },
          { title: 'Donate to shelter', icon: 'mdi-heart' },
        ],
        coffeeMenu: [
          { name: 'Cappuccino', price: 4.98, description: 'Delicious cappuccino', image: 'path-to-cappuccino-img' },
          { name: 'Coffee Latte', price: 5.98, description: 'Smooth latte', image: 'path-to-latte-img' },
          { name: 'Americano', price: 5.98, description: 'Classic americano', image: 'path-to-americano-img' },
        ],
        cartItems: [
          { name: 'Cappuccino', price: 4.98 },
          { name: 'Coffee Latte', price: 5.98 },
        ],
        total: 10.96,
        selectedSize: 'small',
        quantity: 1,
        addedToCart: false,
      };
    },
    methods: {
      increment() {
        this.quantity += 1;
      },
      decrement() {
        if (this.quantity > 1) this.quantity -= 1;
      },
      addToCart() {
        this.addedToCart = true;
        // Logic to add the product to the cart
      },
    },
  };
  </script>
  
<style scoped>
  .price {
    font-weight: bold;
    color: #f56c42;
  }
  .size-options {
    display: flex;
  }
</style>