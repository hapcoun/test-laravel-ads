<template>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Ads for Campaign "{{ campaign.name }}"</h1>

        <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ errorMessage }}
            <button type="button" class="btn-close" @click="clearError" aria-label="Close"></button>
        </div>

        <button class="btn btn-primary mb-3" @click="showModal = true">Add Advertisement</button>
        <router-link :to="`/users/${campaign.user_id}/campaigns`" class="btn btn-secondary mb-3 ml-10px">Back</router-link>

        <h2 class="mb-4">List of Ads</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Title</th>
                <th>Text</th>
                <th>Status</th>
                <th>URL</th>
                <th>Views</th>
                <th>CPM</th>
                <th>Budget</th>
                <th>Button Text</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="ad in ads.data" :key="ad.id">
                <td>{{ ad.title }}</td>
                <td>{{ ad.text }}</td>
                <td>{{ ad.status }}</td>
                <td>{{ ad.url }}</td>
                <td>{{ ad.views }}</td>
                <td>{{ ad.cpm }}</td>
                <td>{{ ad.budget }}</td>
                <td>{{ ad.button_text }}</td>
                <td>
                    <button @click="deleteAd(ad.id)" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <nav class="mt-3">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: !ads.prev_page_url }">
                    <a class="page-link" href="#" @click.prevent="fetchAds(ads.current_page - 1)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === ads.current_page }">
                    <a class="page-link" href="#" @click.prevent="fetchAds(page)">{{ page }}</a>
                </li>

                <li class="page-item" :class="{ disabled: !ads.next_page_url }">
                    <a class="page-link" href="#" @click.prevent="fetchAds(ads.current_page + 1)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div v-if="showModal" class="modal fade show" tabindex="-1" style="display: block;" aria-modal="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Advertisement</h5>
                        <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="createAd">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input v-model="newAd.title" type="text" id="title" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Text:</label>
                                <textarea v-model="newAd.text" id="text" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select v-model="newAd.status" id="status" class="form-select" required>
                                    <option value="active">Active</option>
                                    <option value="pending">Pending</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="url" class="form-label">URL:</label>
                                <input v-model="newAd.url" type="url" id="url" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="cpm" class="form-label">CPM:</label>
                                <input v-model="newAd.cpm" type="number" id="cpm" class="form-control" min="0" />
                            </div>
                            <div class="mb-3">
                                <label for="budget" class="form-label">Budget:</label>
                                <input v-model="newAd.budget" type="number" id="budget" class="form-control" min="0" />
                            </div>
                            <div class="mb-3">
                                <label for="button_text" class="form-label">Button Text:</label>
                                <select v-model="newAd.button_text" id="button_text" class="form-select" required>
                                    <option value="View">View</option>
                                    <option value="Apply">Apply</option>
                                    <option value="Download">Download</option>
                                    <option value="More Info">More Info</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Advertisement</button>
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
            ads: {
                data: [],
                current_page: 1,
                last_page: 1,
                total: 0,
                prev_page_url: null,
                next_page_url: null,
            },
            campaign: {},
            newAd: {
                title: '',
                text: '',
                status: '',
                url: '',
                cpm: '',
                budget: '',
                button_text: '',
            },
            errorMessage: null,
            showModal: false,
        };
    },
    mounted() {
        this.fetchCampaign();
        this.fetchAds();
    },
    computed: {
        totalPages() {
            return Array.from({ length: this.ads.last_page }, (_, i) => i + 1);
        }
    },
    methods: {
        async fetchCampaign() {
            try {
                const response = await axios.get(`/api/campaigns/${this.$route.params.campaignId}`);
                this.campaign = response.data;
            } catch (error) {
                this.errorMessage = 'Error getting campaign data.';
                console.error('Error getting campaign data:', error);
            }
        },
        async fetchAds(page = 1) {
            try {
                const response = await axios.get(`/api/campaigns/${this.$route.params.campaignId}/ads?per_page=10&page=${page}`);
                this.ads = response.data;
            } catch (error) {
                this.errorMessage = 'Error getting ads.';
                console.error('Error getting ads:', error);
            }
        },
        async createAd() {
            try {
                await axios.post(`/api/campaigns/${this.$route.params.campaignId}/ads`, this.newAd);
                this.newAd = {
                    title: '',
                    text: '',
                    status: '',
                    url: '',
                    cpm: '',
                    budget: '',
                    button_text: ''
                };
                this.fetchAds();
                this.clearError();
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'Error creating ad.';
                console.error('Error creating ad:', error);
            } finally {
                this.closeModal();
            }
        },
        async deleteAd(adId) {
            try {
                await axios.delete(`/api/ads/${adId}`);
                this.fetchAds();
                this.clearError();
            } catch (error) {
                this.errorMessage = 'Error deleting ad.';
                console.error('Error deleting ad:', error);
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
