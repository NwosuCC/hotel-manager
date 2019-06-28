<template>

  <!-- Sub-views -->
  <router-view></router-view>

</template>

<script>
  import RoomIndex from './RoomIndex.vue';
  import RoomCreate from './RoomCreate.vue';

  export default {
    name: 'Room',
  }
</script>