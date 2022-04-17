require('./bootstrap');

import router from "./router.js";
import Index from   "../components/Index"
import store from "./store.js";
import { createApp } from 'vue'

const app = createApp(Index).use(store).use(router).mount('#app');
