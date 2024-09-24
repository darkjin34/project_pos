<template>
    <v-container>
        <v-row>
            <v-col>
                <v-card>
                    <v-card-title>
                        Orders
                    </v-card-title>

                    <v-data-table :headers="headers" :items="orders" class="elevation-1">
                        <template v-slot:item.actions="{ item }">
                            <v-btn color="info" @click="completeOrder(item.id)" class="ml-2">Complete</v-btn>
                            <v-btn color="error" @click="cancelOrder(item.id)">Cancel</v-btn>
                        </template>
                    </v-data-table>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>

export default {
    data() {
        return {
            orders: [],
            headers: [
                { text: 'Order Number', value: 'order_number ' },
                { text: 'Customer Name', value: 'customer_name' },
                { text: 'Status', value: 'status' }, // Added category column
                { text: 'Total', value: 'total_price' },
                { text: 'Actions', value: 'actions', sortable: false }
            ],
            selectedUserId: null
        };
    },
    methods: {
        fetchOrders() {
            this.$axios.get('/api/orders')
                .then(response => {
                    this.orders = response.data;
                });
        },
        async completeOrder(orderId) {
            try {
                const response = await this.$axios.put(`/api/orders/${orderId}/order-status`, {
                    status: 'completed'
                });

                this.$toast('Order Completed!', {
                    type: 'success',
                    position: 'top-right',
                    timeout: 5000,
                });

            } catch (error) {
                this.$toast('Failed', {
                    type: 'danger',
                    position: 'top-right',
                    timeout: 5000,
                });
            }
        },
        async cancelOrder(orderId) {
            if (confirm('Are you sure you want to cancel this order?')) {
                try {
                    const response = await this.$axios.put(`/api/orders/${orderId}/order-status`, {
                        status: 'canceled'
                    });

                    this.$toast('Order canceled!', {
                        type: 'warning',
                        position: 'top-right',
                        timeout: 5000,
                    });

                } catch (error) {
                    this.$toast('Failed', {
                        type: 'danger',
                        position: 'top-right',
                        timeout: 5000,
                    });
                }
            }

        }
    },
    mounted() {
        this.fetchOrders();
    }
};
</script>