import { createApp } from 'vue';
import CoachAvailabilityForm from './components/CoachAvailabilityForm.vue';

const app = createApp({});
app.component('coach-availability-form', CoachAvailabilityForm);
app.mount('#app');
