import './bootstrap';

import { createApp } from 'vue';
import router from './router';
import 'flowbite';

import App from './components/App.vue';

const app = createApp(App);
app.use( router );
app.mount('#app');
