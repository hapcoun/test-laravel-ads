<template>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Welcome to the Ads Management System</h1>

        <div class="text-center mb-5">
            <router-link to="/users" class="btn btn-primary">Go to Users</router-link>
        </div>

        <h2 class="mb-4">Statistics</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <canvas id="campaignChart"></canvas>
            </div>
            <div class="col-md-6 mb-4">
                <canvas id="adChart"></canvas>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {Chart, registerables} from 'chart.js';

Chart.register(...registerables);

export default {
    data() {
        return {
            campaignData: {
                active: 0,
                archived: 0
            },
            adData: {
                cpm: [],
                budget: []
            }
        };
    },
    mounted() {
        this.fetchStatistics();
    },
    methods: {
        async fetchStatistics() {
            try {
                // const [campaignsResponse, adsResponse] = await Promise.all([
                //     axios.get('/api/campaigns/stats'),
                //     axios.get('/api/ads/stats')
                // ]);

                // this.campaignData.active = campaignsResponse.data.active;
                // this.campaignData.archived = campaignsResponse.data.archived;
                //
                // this.adData.cpm = adsResponse.data.cpm;
                // this.adData.budget = adsResponse.data.budget;

                this.campaignData.active = 10;
                this.campaignData.archived = 3;

                this.adData.cpm = [2, 4, 3, 2, 1, 5, 2];
                this.adData.budget = [300, 500, 100, 240, 40, 5000, 330];

                this.createCampaignChart();
                this.createAdChart();
            } catch (error) {
                console.error('Error fetching statistics:', error);
            }
        },
        createCampaignChart() {
            const ctx = document.getElementById('campaignChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Active', 'Archived'],
                    datasets: [{
                        data: [this.campaignData.active, this.campaignData.archived],
                        backgroundColor: ['#36A2EB', '#FF6384']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Campaign Status'
                        }
                    }
                }
            });
        },
        createAdChart() {
            const ctx = document.getElementById('adChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.adData.cpm.map((_, index) => `Ad ${index + 1}`), // Assuming labels as Ad numbers
                    datasets: [{
                        label: 'CPM',
                        data: this.adData.cpm,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    },
                        {
                            label: 'Budget',
                            data: this.adData.budget,
                            backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Ads CPM and Budget'
                        }
                    }
                }
            });
        }
    }
};
</script>

<style scoped>
.container {
    max-width: 800px;
    margin: auto;
}

.card {
    height: 100%;
}
</style>
