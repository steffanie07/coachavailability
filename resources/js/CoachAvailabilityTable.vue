<template>
    <table>
      <thead>
        <tr>
          <th>Weekday</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="availability in availabilities" :key="availability.id">
          <td>{{ weekdayLabels[availability.weekday] }}</td>
          <td>{{ availability.start_time }}</td>
          <td>{{ availability.end_time }}</td>
          <td>
            <button @click="editAvailability(availability)">Edit</button>
            <button @click="deleteAvailability(availability.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </template>
  
  <script>
  export default {
    props: {
      availabilities: {
        type: Array,
        required: true,
      },
    },
    data() {
      return {
        weekdayLabels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
      };
    },
    methods: {
      editAvailability(availability) {
        this.$emit('edit-availability', availability);
      },
      deleteAvailability(id) {
        this.$emit('delete-availability', id);
      },
    },
  };
  </script>
  