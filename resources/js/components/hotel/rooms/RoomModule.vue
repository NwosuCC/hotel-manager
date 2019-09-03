<script>
  import Room from './Room.vue';
  import RoomIndex from './RoomIndex.vue';
  import RoomCreate from './RoomCreate.vue';

  export default {
    path: '/rooms',
    component: Room,
    // meta: {
    //   requiresAuth: true
    // },
    children: [
      {
        path: '',
        name: 'room.index',
        component: RoomIndex,
      },
      {
        path: 'create',
        name: 'room.create',
        component: RoomCreate,
        meta: {
          requiresSU: true
        },
      },
      {
        path: ':id/edit',
        name: 'room.edit',
        component: RoomCreate,
        meta: {
          requiresSU: true
        },
      },
    ]
  }
</script>
