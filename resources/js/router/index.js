import { createRouter, createWebHistory } from 'vue-router';
import UserManagement from '../components/UserManagement.vue';
import UserCampaigns from '../components/UserCampaigns.vue';
import CampaignAds from '../components/CampaignAds.vue';
import HomePage from '../components/HomePage.vue';

const routes = [
    { path: '/', component: HomePage },
    { path: '/users', component: UserManagement },
    { path: '/users/:userId/campaigns', component: UserCampaigns, props: true },
    { path: '/campaigns/:campaignId/ads', component: CampaignAds, props: true }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
