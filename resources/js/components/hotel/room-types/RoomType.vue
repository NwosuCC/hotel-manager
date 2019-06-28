<template>

  <!-- Sub-views -->
  <router-view></router-view>

</template>

<script>
  import RoomTypeIndex from './RoomTypeIndex.vue';
  import RoomTypeCreate from './RoomTypeCreate.vue';

  export default {
    name: 'RoomType',
  }
</script>