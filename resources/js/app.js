import './bootstrap';

import { createApp } from 'vue';
import router from './router';
import 'flowbite';

import App from './components/App.vue';
import Pagination from './components/utilities/Pagination.vue';

const app = createApp(App);
app.use( router );
app.component( 'pagination', Pagination );
app.mount('#app');
