import { createApp } from 'vue/dist/vue.esm-bundler';
import CoachAvailabilityForm from './CoachAvailabilityForm.vue';


const app = createApp({});
app.component('coach-availability-form', CoachAvailabilityForm);
app.mount('#app');
