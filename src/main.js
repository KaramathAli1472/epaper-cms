import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { auth, db, storage } from './firebase';

const app = createApp(App);

// Optional: Firebase globally available in components
app.config.globalProperties.$auth = auth;
app.config.globalProperties.$db = db;
app.config.globalProperties.$storage = storage;

app.use(router);
app.mount('#app');

