import router from '@/router';
import axios from 'axios';
import { createApp } from 'vue';
import VueAxios from "vue-axios";
import App from './App.vue';
import './style.css';
import './registerServiceWorker'


// 5. Create and mount the root instance.
const app = createApp(App)

app.use(router)

app.mount('#app')

// Axios Plugin
app.use(VueAxios, axios);

app.provide("axios", app.config.globalProperties.axios);


// Now the app has started!