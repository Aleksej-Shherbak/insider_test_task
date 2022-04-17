import Teams from "../components/Teams.vue";
import Fixtures from "../components/Fixtures";
import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: Teams,
        name: 'home'
    },
    {
        path: "/fixtures",
        component: Fixtures,
        name: 'fixtures'
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
