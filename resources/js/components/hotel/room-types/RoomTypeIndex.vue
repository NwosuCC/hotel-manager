<template>

  <div class="card my-4">

    <h5 class="card-header">Room Types</h5>

    <div class="card-body">

      <!-- Add Button -->
      <div v-if="isSuperUser" class="pb-3">
        <router-link :to="{ name: 'room-type.create' }" class="btn-clear info rounded pull-right">
          <i class="la la-plus mr-2"></i> Room Type
        </router-link>
      </div>

      <!-- List -->
      <div class="table-responsive" :style="{'min-height': minHeight + 'px'}">
        <table class="table" id="list-table">
          <thead>
          <tr>
            <th class="border-top-0 w-25">#</th>
            <th class="border-top-0 w-25">Name</th>
            <th class="border-top-0 w-25">Price</th>
            <th v-if="isSuperUser" class="border-top-0 w-25 text-center">Actions</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(roomType, i) in roomTypes" :key="roomType.id">
            <td>{{ startIndex + i }}</td>
            <td>{{ roomType.name }}</td>
            <td>{{ roomType.price }}</td>
            <td v-if="isSuperUser" class="text-center">
              <router-link :to="{ name: 'room-type.edit', params: {id: roomType.id} }" class="btn btn-sm btn-light btn-outline-info mr-1 py-0 px-1">
                <i class="la la-pencil"></i>
              </router-link>
              <a @click="deleteItem(i, roomType.id)" class="btn btn-sm btn-light btn-outline-danger text-danger mr-1 py-0 px-1">
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
  import {AuthService} from "../../../services/auth-service";

  export default {
    name: 'RoomTypeIndex',
    components: {
      'Pagination': Pagination,
    },

    data() {
      return {
        eventBus: vmEvents,
        roomTypes: [],
        pageInfo: null,
        error: null,
        minHeight: 0,
        startIndex: 1,
        isSuperUser: AuthService.superUser(),
      };
    },

    beforeRouteEnter (to, from, next) {
      ApiService.getRoomTypes(to.query.page || 1, (err, data) => {
        next(vm => vm.setData(err, data));
      });
    },

    beforeRouteUpdate (to, from, next) {
      this.roomTypes = null;

      ApiService.getRoomTypes(to.query.page || 1, (err, data) => {
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
          this.roomTypes = data;
          this.pageInfo = { meta, links, index: 'room-type.index' };
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
          ApiService.deleteRoomType(id, (error, data) => {
            if(error){
              this.errors = data.message;
              this.eventBus.$emit('flash:data', {message: data.message, type: 'danger'});
            }
            else {
              this.roomTypes.splice( index, 1 );
              this.eventBus.$emit('flash:data', {message: data.message});
            }
          });
        }
      }
    }
  }
</script>
