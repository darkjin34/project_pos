<template>
    <v-container fluid>
        <h2>Coffee Menu</h2>
        <v-row>
          <v-col cols="3" v-for="(item, index) in products" :key="index">
            <v-card class="pa-4" outlined>
                <!-- Product Image -->
                <v-img :src="`/storage/${item.image_at}`" height="150px" contain></v-img>

                <!-- Product Details -->
                <v-card-title class="d-flex justify-space-between">
                  {{ item.name }}
                  <!-- Show price based on selected size -->
                  <span class="price">${{ getPriceBySize(item.sizes, selectedSize[index]) }}</span>
                </v-card-title>

                <v-card-subtitle>
                  {{ item.description }}
                </v-card-subtitle>

                <!-- Size Options -->
                <v-row class="mt-3">
                  <v-col cols="3">Size</v-col>
                  <v-col cols="9">
                    <v-btn-toggle v-model="selectedSize[index]" class="size-options" mandatory>
                      <!-- Dynamically generate size buttons based on product sizes -->
                      <v-btn 
                        v-for="size in item.sizes" 
                        :key="size.size" 
                        :value="size.size" 
                        class="mx-1" 
                        depressed 
                        outlined
                      >
                        {{ size.size }}
                      </v-btn>
                    </v-btn-toggle>
                  </v-col>
                </v-row>

                <!-- Quantities Selector -->
                <v-row class="mt-3">
                  <v-col cols="12" class="d-flex align-center justify-space-between">
                    <v-btn icon @click="decrement(index)">
                      <v-icon>mdi-minus</v-icon>
                    </v-btn>
                    <span class="mr-1 ml-1">{{ quantities[index] || 1 }}</span>
                    <v-btn icon @click="increment(index)">
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
                  @click="addToCart(item.name, getPriceBySize(item.sizes, selectedSize[index]), quantities[index], selectedSize[index], index)"
                >
                  {{ addedToCart[index] ? 'Added to cart' : 'Add to cart' }}
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
        selectedSize: [],
        quantities: [],
        addedToCart: [],
        products: []
      };
    },
    watch: {
      // Watch products for changes and initialize the data arrays when products are available
      products: {
        handler(newProducts) {
          console.log(newProducts)
          // Initialize quantities, sizes, and cart status for each product
          newProducts.forEach((product, index) => {
            if (this.quantities[index] === undefined) {
              this.quantities[index] = 1; // Default quantities to 1
            }
            if (this.selectedSize[index] === undefined) {
              this.selectedSize[index] = 'small'; // Default size to 'small'
            }
            if (this.addedToCart[index] === undefined) {
              this.addedToCart[index] = false; // Default not added to cart
            }
          });
        },
        immediate: true, // Initialize immediately if products already exist
        deep: true, // Watch for deep changes in the products array
      },
    },
    methods: {
      fetchProducts() {
          this.$axios.get('/api/products')
              .then(response => {
                  this.products = response.data;
              });
      },
      getPriceBySize(sizes, selectedSize) {
        const size = sizes.find(s => s.size === selectedSize);
        return size ? size.price : 0;
      },
      increment(index) {
        this.quantities[index] += 1;
      },
      decrement(index) {
        if (this.quantities[index] > 1) {
          this.quantities[index] -= 1;
        }
      },
      addToCart(name, price, quantities, size, index) {
        const product = {
          name: name,
          price: price,
          quantities: quantities,
          size: size,
        };

        // Dispatch the Vuex action to add the order
        this.$store.dispatch('addOrder', product);

        // Update addedToCart state for this product
        this.addedToCart[index] = true;
      },
    },
    mounted() {
      this.fetchProducts();
      this.$store.dispatch('resetOrder');
    }
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