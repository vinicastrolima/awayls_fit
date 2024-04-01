import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import 'bootstrap'; // Importe o Bootstrap
import 'bootstrap/dist/css/bootstrap.css'; // Importe o arquivo CSS do Bootstrap

createApp(App).use(router).mount('#app');
