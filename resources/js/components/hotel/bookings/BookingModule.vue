<script>
  import Booking from './Booking.vue';
  import BookingIndex from './BookingIndex.vue';
  import BookingCreate from './BookingCreate.vue';

  export default {
    path: '/bookings',
    component: Booking,
    meta: {
      requiresAuth: true
    },
    children: [
      {
        path: '',
        name: 'booking.index',
        component: BookingIndex,
      },
      {
        path: 'create',
        name: 'booking.create',
        component: BookingCreate,
      },
      {
        path: ':id/edit',
        name: 'booking.edit',
        component: BookingCreate,
      },
    ]
  }
</script>