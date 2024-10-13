<template>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Campaigns for {{ user.name }}</h1>

        <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ errorMessage }}
            <button type="button" class="btn-close" @click="clearError" aria-label="Close"></button>
        </div>

        <button class="btn btn-primary mb-3" @click="showModal = true">Create campaign</button>
        <router-link :to="`/users`" class="btn btn-secondary mb-3 ml-10px">Back</router-link>

        <h2 class="mb-4">List of campaigns</h2>
        <ul class="list-group">
            <li v-for="campaign in campaigns.data" :key="campaign.id" class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    {{ campaign.title }} (Status: {{ campaign.status }})
                </div>
                <div>
                    <router-link :to="`/campaigns/${campaign.id}/ads`" class="btn btn-info btn-sm">View Ads</router-link>
                    <button @click="deleteCampaign(campaign.id)" class="btn btn-danger btn-sm ms-2">Delete</button>
                </div>
            </li>
        </ul>

        <nav class="mt-3">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: !campaigns.prev_page_url }">
                    <a class="page-link" href="#" @click.prevent="fetchCampaigns(campaigns.current_page - 1)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === campaigns.current_page }">
                    <a class="page-link" href="#" @click.prevent="fetchCampaigns(page)">{{ page }}</a>
                </li>

                <li class="page-item" :class="{ disabled: !campaigns.next_page_url }">
                    <a class="page-link" href="#" @click.prevent="fetchCampaigns(campaigns.current_page + 1)" aria-label="Next">
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
                        <form @submit.prevent="createCampaign" class="mb-5">
                            <div class="mb-3">
                                <label for="name" class="form-label">Campaign Title:</label>
                                <input v-model="newCampaign.title" type="text" id="title" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select v-model="newCampaign.status" id="status" class="form-control" required>
                                    <option value="active">Active</option>
                                    <option value="pending">Pending</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Campaign</button>
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
            campaigns: {
                data: [],
                current_page: 1,
                last_page: 1,
                total: 0,
                prev_page_url: null,
                next_page_url: null,
            },
            user: {},
            newCampaign: {
                title: '',
                status: 'active'
            },
            errorMessage: null,
            showModal: false,
        };
    },
    mounted() {
        this.fetchUser();
        this.fetchCampaigns();
    },
    computed: {
        totalPages() {
            return Array.from({ length: this.campaigns.last_page }, (_, i) => i + 1);
        }
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get(`/api/users/${this.$route.params.userId}`);
                this.user = response.data;
            } catch (error) {
                this.errorMessage = 'Error getting user data.';
                console.error('Error getting user data:', error);
            }
        },
        async fetchCampaigns(page = 1) {
            try {
                const response = await axios.get(`/api/users/${this.$route.params.userId}/campaigns?per_page=10&page=${page}`);
                this.campaigns = response.data;
            } catch (error) {
                this.errorMessage = 'Error getting campaigns.';
                console.error('Error getting campaigns:', error);
            }
        },
        async createCampaign() {
            try {
                await axios.post(`/api/users/${this.$route.params.userId}/campaigns`, this.newCampaign);
                this.newCampaign = { title: '', status: 'active' };
                this.fetchCampaigns();
                this.clearError();
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'Error creating campaign.';
                console.error('Error creating campaign:', error);
            } finally {
                this.closeModal()
            }
        },
        async deleteCampaign(campaignId) {
            try {
                await axios.delete(`/api/campaigns/${campaignId}`);
                this.fetchCampaigns();
                this.clearError();
            } catch (error) {
                this.errorMessage = 'Error deleting campaign.';
                console.error('Error deleting campaign:', error);
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
