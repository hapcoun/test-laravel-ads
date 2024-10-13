<template>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">User Management</h1>

        <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ errorMessage }}
            <button type="button" class="btn-close" @click="clearError" aria-label="Close"></button>
        </div>

        <button class="btn btn-primary mb-3" @click="showModal = true">Create user</button>
        <router-link :to="`/`" class="btn btn-secondary mb-3 ml-10px">Home</router-link>

        <h2 class="mb-4">List of users</h2>
        <ul class="list-group">
            <li v-for="user in users.data" :key="user.id" class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    {{ user.name }} ({{ user.email }})
                </div>
                <div>
                    <router-link :to="`/users/${user.id}/campaigns`" class="btn btn-info btn-sm">View Campaigns</router-link>
                    <button @click="deleteUser(user.id)" class="btn btn-danger btn-sm ms-2">Delete</button>
                </div>
            </li>
        </ul>

        <nav class="mt-3">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: !users.prev_page_url }">
                    <a class="page-link" href="#" @click.prevent="fetchUsers(users.current_page - 1)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === users.current_page }">
                    <a class="page-link" href="#" @click.prevent="fetchUsers(page)">{{ page }}</a>
                </li>

                <li class="page-item" :class="{ disabled: !users.next_page_url }">
                    <a class="page-link" href="#" @click.prevent="fetchUsers(users.current_page + 1)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div v-if="showModal" class="modal fade show" tabindex="-1" style="display: block;" aria-modal="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Campaign</h5>
                        <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="createUser" class="mb-5">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input v-model="newUser.name" type="text" id="name" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input v-model="newUser.email" type="email" id="email" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input v-model="newUser.password" type="password" id="password" class="form-control" required />
                            </div>
                            <button type="submit" class="btn btn-primary">Save user</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            users: {
                data: [],
                current_page: 1,
                last_page: 1,
                total: 0,
                prev_page_url: null,
                next_page_url: null,
            },
            newUser: {
                name: '',
                email: '',
                password: ''
            },
            errorMessage: null,
            showModal: false,
        };
    },
    mounted() {
        this.fetchUsers();
    },
    computed: {
        totalPages() {
            return Array.from({ length: this.users.last_page }, (_, i) => i + 1);
        }
    },
    methods: {
        async fetchUsers(page = 1) {
            try {
                const response = await axios.get(`/api/users?per_page=10&page=${page}`);
                this.users = response.data;
            } catch (error) {
                this.errorMessage = 'Error getting users.';
                console.error('Error getting users:', error);
            }
        },
        async createUser() {
            try {
                await axios.post('/api/users', this.newUser);
                this.newUser = { name: '', email: '', password: '' };
                this.fetchUsers();
                this.clearError();
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'Error creating user.';
                console.error('Error creating user:', error);
            } finally {
                this.closeModal()
            }
        },
        async deleteUser(userId) {
            try {
                await axios.delete(`/api/users/${userId}`);
                this.fetchUsers();
                this.clearError();
            } catch (error) {
                this.errorMessage = 'Error deleting user.';
                console.error('Error deleting user:', error);
            }
        },
        clearError() {
            this.errorMessage = null;
        },
        closeModal() {
            this.showModal = false;
        }
    }
};
</script>

<style scoped>
.container {
    max-width: 800px;
    margin: auto;
}
.modal-backdrop {
    z-index: 1040;
}
.modal {
    z-index: 1050;
}
.ml-10px {
    margin-left: 10px;
}
</style>
