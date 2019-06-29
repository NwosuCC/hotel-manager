<template>

  <!-- Sub-views -->
  <router-view></router-view>

</template>

<script>
  import BookingIndex from './BookingIndex.vue';
  import BookingCreate from './BookingCreate.vue';

  export default {
    name: 'Booking',
  }
</script>