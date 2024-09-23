<template>
    <v-container fluid>
        <h2>Coffee Menu</h2>
    
        <!-- Category Tabs -->
        <v-tabs v-model="selectedCategory" background-color="primary" dark>
            <v-tab v-for="category in categories" :key="category" :value="category" rounded="lg">
            {{ category }}
            </v-tab>
        </v-tabs>
      
        <v-row class="mx-2" v-for="category in categories" :key="category" :value="category">
            <v-col cols="4" v-for="(item, index) in filteredProducts" :key="item.id">
                <div v-if="item.category === category">
                    <v-card class="pa-4" outlined>
                        <!-- Product Image -->
                        <v-img :src="`/storage/${item.image_at}`" height="150px" contain></v-img>
            
                        <!-- Product Details -->
                        <v-card-title class="d-flex justify-space-between">
                        {{ item.name }}
                        <!-- Show price based on selected size -->
                        <span class="price">${{ getPriceBySize(item.sizes, selectedSize[index], selectedTemperature[index]).price }}</span>
                        </v-card-title>
            
                        <v-card-subtitle>{{ item.description }}</v-card-subtitle>
            
                        <!-- Size Options -->
                        <v-row class="mx-3">
                            <v-col cols="3">Size</v-col>
                            <v-col cols="9">
                                <v-btn-toggle v-model="selectedSize[index]" class="size-options" mandatory>
                                <v-btn
                                    v-for="size in uniqueSizes(item.sizes)"
                                    :key="size"
                                    :value="size"
                                    class="mx-1"
                                    size="small"
                                    rounded="lg"
                                >
                                    {{ size}}
                                </v-btn>
                                </v-btn-toggle>
                            </v-col>
                        </v-row>
            
                        <!-- Temperature Options (Optional) -->
                        <v-row class="mx-3" v-if="selectedCategory === 'coffee'">
                            <v-col cols="4">Temperature</v-col>
                            <v-col cols="5">
                                <v-btn-toggle v-model="selectedTemperature[index]" class="temperature-options" mandatory>
                                <v-btn value="hot" class="mx-1" size="small" rounded="sm">Hot</v-btn>
                                <v-btn value="cold" class="mx-1" size="small" rounded="sm">Cold</v-btn>
                                </v-btn-toggle>
                            </v-col>
                        </v-row>
            
                        <!-- Quantities Selector -->
                        <v-row class="mx-3">
                            <v-col cols="12" class="d-flex align-center justify-space-between">
                                <v-btn icon @click="decrement(index)" size="x-small">
                                <v-icon>mdi-minus</v-icon>
                                </v-btn>
                                <span class="mx-2">{{ quantities[index] || 1 }}</span>
                                <v-btn icon @click="increment(index)" size="x-small">
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
                            @click="addToCart(item.name, getPriceBySize(item.sizes, selectedSize[index], selectedTemperature[index]), quantities[index], selectedSize[index], selectedTemperature[index], index, item.image_at)"
                        >
                        {{ addedToCart[index] ? 'Added to cart' : 'Add to cart' }}
                        </v-btn>
                    </v-card>
                </div>
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
        products: [],
        selectedCategory: 'coffee',
        categories: ['coffee', 'dish', 'others'],
        selectedTemperature: [],
      };
    },
    watch: {
      products: {
        handler(newProducts) {
          newProducts.forEach((product, index) => {
            if (!this.quantities[index]) {
              this.quantities[index] = 1;
            }
            if (!this.selectedSize[index]) {
              this.selectedSize[index] = 'small';
            }
            if (!this.selectedTemperature[index]) {
              this.selectedTemperature[index] = 'hot';
            }
            if (!this.addedToCart[index]) {
              this.addedToCart[index] = false;
            }
          });
        },
        immediate: true,
        deep: true,
      },
    },
    computed: {
        filteredProducts() {
            if (!this.selectedCategory) return [];
            return this.products.filter(product => product.category === this.selectedCategory);
        },
    },
    methods: {
        fetchProducts() {
            this.$axios.get('/api/products').then(response => {
                this.products = response.data;
            });
        },
        getPriceBySize(sizes, selectedSize, selectedTemperature) {
            const size = (this.selectedCategory == 'coffee') ? sizes.find(s => s.size === selectedSize && s.temperature === selectedTemperature): sizes.find(s => s.size === selectedSize);
            return size ? size : { price: 0, id: null };
        },
        uniqueSizes(sizes) {
            // Extract unique sizes from the sizes array
            const sizeSet = new Set(sizes.map(s => s.size));
            return Array.from(sizeSet);
        },
        increment(index) {
            this.quantities[index] += 1;
        },
        decrement(index) {
            if (this.quantities[index] > 1) {
                this.quantities[index] -= 1;
            }
        },
        addToCart(name, sizeDetails, quantities, size, temperature, index, image) {
        const product = {
            name,
            price: sizeDetails.price,
            quantities,
            size,
            temperature: (this.selectedCategory == 'coffee') ? temperature : 'N/A',
            product_size_id: sizeDetails.id,
            image
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
    },
};
    </script>
  
  <style scoped>
  .price {
    font-weight: bold;
    color: #f56c42;
  }
  .size-options,
  .temperature-options {
    display: flex;
  }
  </style>