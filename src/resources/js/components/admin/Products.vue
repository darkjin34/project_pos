<template>
    <v-container>
        <v-row>
            <v-col>
                <v-card>
                    <v-card-title>
                        Products
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="openCreateDialog">Create Product</v-btn>
                    </v-card-title>

                    <v-data-table :headers="headers" :items="products" class="elevation-1">
                        <template v-slot:item.actions="{ item }">
                            <v-btn color="info" @click="editProduct(item)">Edit</v-btn>
                            <v-btn color="error" @click="deleteProduct(item.id)">Delete</v-btn>
                        </template>
                    </v-data-table>
                </v-card>
            </v-col>
        </v-row>

        <!-- Create/Edit Product Dialog -->
        <v-dialog v-model="dialog" max-width="600px">
            <v-card>
                <v-card-title>{{ isEditMode ? 'Edit Product' : 'Create Product' }}</v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="isEditMode ? updateProduct() : createProduct()">
                        <v-text-field v-model="form.name" label="Name" required></v-text-field>
                        <v-text-field v-model="form.description" label="Description" required></v-text-field>
                        <v-select
                            v-model="form.category"
                            :items="categoryOptions"
                            label="Category"
                            required
                        ></v-select>
                        <v-file-input label="Upload Image" v-model="selectedFile" accept="image/*" @change="onFileChange"></v-file-input>
                        <v-divider></v-divider>

                        <!-- Sizes with Prices and Temperature -->
                        <v-row v-for="(size, index) in form.sizes" :key="index">
                            <v-col cols="4">
                                <v-select
                                    v-model="size.size"
                                    :items="sizeOptions"
                                    label="Size"
                                    required
                                ></v-select>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field v-model="size.price" label="Price" placeholder="e.g., 5.00" required></v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-select
                                    v-model="size.temperature"
                                    :items="temperatureOptions"
                                    label="Temperature"
                                ></v-select>
                            </v-col>
                        </v-row>
                        <v-btn color="primary" @click="addSizeField">Add Size</v-btn>
                        
                        <v-divider></v-divider>
                        <v-btn type="submit" color="primary">{{ isEditMode ? 'Update' : 'Create' }}</v-btn>
                    </v-form>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="secondary" @click="resetForm">Clear Form</v-btn>
                </v-card-actions>

                <div v-if="imageUrl">
                    <h4>Uploaded Image:</h4>
                    <v-img :src="imageUrl" alt="Product Image" max-width="200"></v-img>
                </div>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>

export default {
    data() {
        return {
            products: [],
            form: {
                name: '',
                description: '',
                category: '',
                sizes: [{ size: '', price: '', temperature: '' }]
            },
            selectedFile: null,
            imageUrl: '',
            dialog: false,
            isEditMode: false,
            sizeOptions: ['small', 'medium', 'large'],
            temperatureOptions: ['hot', 'cold'], // New temperature options
            categoryOptions: ['coffee', 'dish'], // Category options for coffee or dish
            headers: [
                { text: 'Name', value: 'name' },
                { text: 'Description', value: 'description' },
                { text: 'Category', value: 'category' }, // Added category column
                { text: 'Actions', value: 'actions', sortable: false }
            ],
            selectedUserId: null
        };
    },
    methods: {
        fetchProducts() {
            this.$axios.get('/api/products')
                .then(response => {
                    this.products = response.data;
                });
        },
        openCreateDialog() {
            this.resetForm();
            this.dialog = true;
            this.isEditMode = false;
        },
        onFileChange(event) {
            const files = event.target.files;
            if (files && files.length > 0) {
                this.selectedFile = files[0];
            } else {
                this.selectedFile = null;
            }
        },
        addSizeField() {
            this.form.sizes.push({ size: '', price: '', temperature: '' });
        },
        async createProduct() {
            if (!this.selectedFile || !this.selectedFile.type.match('image.*')) {
                alert('Please select a valid image file.');
                return;
            }

            let formData = new FormData();
            formData.append('name', this.form.name);
            formData.append('description', this.form.description);
            formData.append('category', this.form.category); // Include category
            this.form.sizes.forEach((size, index) => {
                formData.append(`sizes[${index}][size]`, size.size);
                formData.append(`sizes[${index}][price]`, size.price);
                formData.append(`sizes[${index}][temperature]`, size.temperature); // Include temperature
            });

            if (this.selectedFile) {
                formData.append('image', this.selectedFile);
            }

            try {
                const response = await this.$axios.post('/api/products', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                });
                this.imageUrl = `/storage/${response.data.image}`;
                this.fetchProducts();
                alert('Product created successfully!');
            } catch (error) {
                console.error('Error creating the product:', error);
            }
        },
        editProduct(product) {
            this.form = { ...product };
            this.dialog = true;
            this.isEditMode = true;
            this.selectedUserId = product.id;
            this.imageUrl = `/storage/${product.image_at}`;
        },
        updateProduct() {
            this.$axios.put(`/api/products/${this.selectedUserId}`, this.form)
                .then(() => {
                    this.fetchProducts();
                    this.dialog = false;
                })
                .catch(error => console.error(error));
        },
        deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                this.$axios.delete(`/api/products/${id}`)
                    .then(() => this.fetchProducts())
                    .catch(error => console.error(error));
            }
        },
        resetForm() {
            this.form = {
                name: '',
                description: '',
                category: '',
                sizes: [{ size: '', price: '', temperature: '' }]
            };
            this.selectedFile = null;
            this.imageUrl = '';
        }
    },
    mounted() {
        this.fetchProducts();
    }
};
</script>