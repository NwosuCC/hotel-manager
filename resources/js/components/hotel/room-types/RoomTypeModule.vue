<script>
  import RoomType from './RoomType.vue';
  import RoomTypeIndex from './RoomTypeIndex.vue';
  import RoomTypeCreate from './RoomTypeCreate.vue';

  export default {
    path: '/room-types',
    component: RoomType,
    // meta: {
    //   requiresAuth: true
    // },
    children: [
      {
        path: '',
        name: 'room-type.index',
        component: RoomTypeIndex,
      },
      {
        path: 'create',
        name: 'room-type.create',
        component: RoomTypeCreate,
        meta: {
          requiresSU: true
        },
      },
      {
        path: ':id/edit',
        name: 'room-type.edit',
        component: RoomTypeCreate,
        meta: {
          requiresSU: true
        },
      },
    ]
  }
</script>
