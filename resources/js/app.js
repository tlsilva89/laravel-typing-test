import './bootstrap';
import { createApp } from 'vue';
import TypingTest from './components/TypingTest.vue';

const app = createApp({});
app.component('typing-test', TypingTest);
app.mount('#app');
