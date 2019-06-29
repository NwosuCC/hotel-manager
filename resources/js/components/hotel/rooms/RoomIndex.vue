<template>

  <div class="card my-4">

    <h5 class="card-header">Rooms</h5>

    <div class="card-body">

      <!-- Add Button -->
      <div class="pb-3">
        <router-link :to="{ name: 'room.create' }" class="btn-clear info rounded pull-right">
          <i class="la la-plus mr-2"></i> Room
        </router-link>
      </div>

      <!-- List -->
      <div class="table-responsive" :style="{'min-height': minHeight + 'px'}">
        <table class="table" id="list-table">
          <thead>
          <tr>
            <th class="border-top-0 w-25">#</th>
            <th class="border-top-0 w-25">Name</th>
            <th class="border-top-0 w-25">Type</th>
            <th class="border-top-0 w-25">Actions</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(room, i) in rooms" :key="room.id">
            <td>{{ startIndex + i }}</td>
            <td>{{ room.name }}</td>
            <td>{{ room.room_type.name }}</td>
            <td class="text-center">
              <router-link :to="{ name: 'room.edit', params: {id: room.id} }" class="btn btn-sm btn-light btn-outline-info mr-1 py-0 px-1">
                <i class="la la-pencil"></i>
              </router-link>
              <a @click="deleteItem(i, room.id)" class="btn btn-sm btn-light btn-outline-danger text-danger mr-1 py-0 px-1">
                <i class="la la-trash"></i>
              </a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <hr />

      <!-- Pagination -->
      <pagination :pageInfo="pageInfo" @start:index="startIndex = $event"></pagination>

    </div>

  </div>

</template>

<script>
  import { ApiService } from '../../../services/api-service';
  import Pagination from '../../common/Pagination.vue';

  export default {
    name: 'RoomIndex',
    components: {
      'Pagination': Pagination,
    },

    data() {
      return {
        eventBus: vmEvents,
        rooms: [],
        pageInfo: null,
        error: null,
        minHeight: 0,
        startIndex: 1,
      };
    },

    beforeRouteEnter (to, from, next) {
      ApiService.getRoomsPaginated(to.query.page, (err, data) => {
        next(vm => vm.setData(err, data));
      });
    },

    beforeRouteUpdate (to, from, next) {
      this.rooms = null;

      ApiService.getRoomsPaginated(to.query.page, (err, data) => {
        this.setData(err, data);
        next();
      });
    },

    methods: {
      setData(err, { data, links, meta }) {
        if (err) {
          this.error = err.toString();
        }
        else {
          this.rooms = data;
          this.pageInfo = { meta, links, index: 'room.index' };
          this.setTableMinHeight();
        }
      },
      setTableMinHeight(){
        setTimeout(() => {
          let newHeight = $('#list-table').outerHeight() + 20;
          if(newHeight > this.minHeight){
            this.minHeight = newHeight
          }
        }, 200);
      },
      deleteItem(index, id){
        if(confirm('Delete this entry?')){
          ApiService.deleteRoom(id, (error, data) => {
            if(error){
              this.errors = data.message;
              this.eventBus.$emit('flash:data', {message: data.message, type: 'danger'});
            }
            else {
              this.rooms.splice( index, 1 );
              this.eventBus.$emit('flash:data', {message: data.message});
            }
          });
        }
      }
    }
  }
</script>