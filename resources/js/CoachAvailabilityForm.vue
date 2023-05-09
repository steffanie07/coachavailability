<template>
  <div class="container">
 <form @submit.prevent="submitForm">
    <div v-if="step === 1">
      <h2>Step 1: Coach Details</h2>
         <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" class="form-control" id="coach-name" v-model="coachName">
        </div>
        <div class="form-group">
          <button type="button" @click="saveCoachDetailsAndProceed">Next</button>
        </div>
        <div v-if="errors" class="alert alert-danger" role="alert">
          <ul>
            <li v-for="error in errors">{{ error }}</li>
          </ul>
        </div>
          </div>
    <div v-else-if="step === 2">
      <h2>Step 2: Coach Availability</h2>
        <div class="form-group">
          <label for="weekday">Day of Week:</label>
          <select class="form-control" id="weekday" v-model="weekday">
            <option value="" disabled>Please select a day of the week</option>
            <option v-for="(day, index) in daysOfWeek" :value="day">{{ day }}</option>
          </select>
        </div>
        <div class="form-group">
          <label for="start-time">Start Time:</label>
          <input type="time" class="form-control" id="start-time" v-model="startTime">
        </div>
        <div class="form-group">
          <label for="end-time">End Time:</label>
          <input type="time" class="form-control" id="end-time" v-model="endTime">
        </div>
        <div class="form-group">
          <label for="duration">Duration (in minutes):</label>
          <input type="number" class="form-control" id="duration" v-model="availability.duration">
        </div>
        <div class="form-group">
          <label for="is-available">Available:</label>
          <input type="checkbox" class="form-control" id="is-available" v-model="availability.is_available">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div v-if="errors" class="alert alert-danger" role="alert">
          <ul>
            <li v-for="error in errors">{{ error }}</li>
          </ul>
        </div>
        <div v-if="successMessage" class="alert alert-success" role="alert">
          {{ successMessage }}
        </div>
    </div>
  </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      coachName: '',
      coachId: '',
      step: 1,
      weekday: '',
      startTime: '',
      endTime: '',
      successMessage: '',
      isUnavailable: {
        Monday: false,
        Tuesday: false,
        Wednesday: false,
        Thursday: false,
        Friday: false,
        Saturday: false,
        Sunday: false,
      },
      availability: {
        weekday: '',
        startTime: '',
        endTime: '',
        duration: '',
        calendar: '',
      },
      daysOfWeek: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
      errorMessage: '',
      successMessage: '',
    };
  },
  

  methods: {
    async saveCoachDetailsAndProceed() {
      await this.saveCoachDetails();
      this.step = 2;
    },

    async saveCoachDetails() {
      try {
        console.log('Sending coach name:', this.coachName);
        const response = await axios.post('/api/coaches', { name: this.coachName });
        this.coachId = response.data.coach_id;
      } catch (error) {
        // Handle error
        if (error.response.status === 422) {
          console.log('Validation errors:', error.response.data.errors);
        }
      }
    },
    async submitForm() {
      if (!this.coachId) {
        await this.saveCoachDetails();
      }
      console.log('Submitting availability:', this.weekday, this.startTime, this.endTime);
      const unavailableDays = Object.entries(this.isUnavailable)
        .filter(([_, isUnavailable]) => isUnavailable)
        .map(([day, _]) => day);

      const formData = {
        coach_id: this.coachId,
        day_of_week: this.weekday,
        start_time: this.startTime,
        end_time: this.endTime,
        unavailable_days: unavailableDays,
        name:this.coachName,
      };

      try {
        await axios.post('/api/availabilities', formData);
        this.showForm = false;
        this.successMessage = 'Availability added successfully!';       

      } catch (error) {
        console.error('API error:', error);
        console.error('API error response:', error.response);
        if (error.response.status === 422) {
          console.log('Sending coach name:', this.coachName);
          console.log('Validation errors:', error.response.data.errors);
        }else{
          this.errorMessage = 'An unexpected error occurred. Please try again later.';
        }
      }
    },
  },
  
};
</script>
<style scoped>
.availability-form {
  margin: 2rem auto;
  max-width: 600px;
  padding: 1rem;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.form-group {
  margin-bottom: 1rem;
  display: flex;
  flex-direction: column;
}

label {
  font-weight: bold;
  margin-bottom: 0.5rem;
}

input[type="text"],
select,
input[type="time"] {
  padding: 0.5rem;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 1rem;
  margin-top: 0.25rem;
}

button[type="submit"] {
  padding: 0.5rem 1rem;
  background-color: #1f2937;
  color: #fff;
  border: none;
  border-radius: 5px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
}

button[type="submit"]:hover {
  background-color: #4b5563;
}

.error-message {
  color: red;
  margin-top: 0.5rem;
  font-size: 0.8rem;
}

.success-message {
  color: green;
  margin-top: 1rem;
}

@media (max-width: 768px) {
  .availability-form {
    max-width: 90%;
    padding: 0.5rem;
  }

  input[type="text"],
  select,
  input[type="time"] {
    font-size: 0.9rem;
  }

  button[type="submit"] {
    font-size: 0.9rem;
  }
}
</style>