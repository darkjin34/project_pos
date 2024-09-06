<template>
    <v-container>
        <v-row>
            <v-col>
                <v-card>
                    <v-card-title>
                        User Management
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="openCreateDialog">Create User</v-btn>
                    </v-card-title>

                    <v-data-table :headers="headers" :items="users" class="elevation-1">
                        <template v-slot:item.actions="{ item }">
                            <v-btn color="info" @click="editUser(item)">Edit</v-btn>
                            <v-btn color="error" @click="deleteUser(item.id)">Delete</v-btn>
                        </template>
                    </v-data-table>
                </v-card>
            </v-col>
        </v-row>

        <!-- Create/Edit User Dialog -->
        <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-title>{{ isEditMode ? 'Edit User' : 'Create User' }}</v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="isEditMode ? updateUser() : createUser()">
                        <v-text-field v-model="form.name" label="Name" required></v-text-field>
                        <v-text-field v-model="form.email" label="Email" required></v-text-field>
                        <v-text-field v-if="!isEditMode" v-model="form.password" label="Password" type="password" required></v-text-field>
                        <v-text-field v-if="!isEditMode" v-model="form.password_confirmation" label="Confirm Password" type="password" required></v-text-field>
                        <v-btn type="submit" color="primary">{{ isEditMode ? 'Update' : 'Create' }}</v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>

export default {
    data() {
        return {
            users: [],
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            dialog: false,
            isEditMode: false,
            headers: [
                { text: 'Name', value: 'name' },
                { text: 'Email', value: 'email' },
                { text: 'Actions', value: 'actions', sortable: false }
            ],
            selectedUserId: null
        };
    },
    methods: {
        fetchUsers() {
            this.$axios.get('/api/users')
                .then(response => {
                    this.users = response.data;
                });
        },
        openCreateDialog() {
            this.resetForm();
            this.dialog = true;
            this.isEditMode = false;
        },
        createUser() {
            this.$axios.post('/api/users', this.form)
                .then(() => {
                    this.fetchUsers();
                    this.dialog = false;
                })
                .catch(error => console.error(error));
        },
        editUser(user) {
            this.form = { ...user, password: '', password_confirmation: '' };
            this.dialog = true;
            this.isEditMode = true;
            this.selectedUserId = user.id;
        },
        updateUser() {
            this.$axios.put(`/api/users/${this.selectedUserId}`, this.form)
                .then(() => {
                    this.fetchUsers();
                    this.dialog = false;
                })
                .catch(error => console.error(error));
        },
        deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                this.$axios.delete(`/api/users/${id}`)
                    .then(() => this.fetchUsers())
                    .catch(error => console.error(error));
            }
        },
        resetForm() {
            this.form = {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            };
        }
    },
    mounted() {
        this.fetchUsers();
    }
};
</script>