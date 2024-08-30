// assets/app.js
import { createApp } from 'vue';
import 'bootstrap/dist/css/bootstrap.min.css'; // Import Bootstrap CSS
import BookList from './components/BookList.vue';
import BookForm from './components/BookForm.vue';

createApp({
    components: {
        BookList,
        BookForm,
    },
}).mount('#app');
