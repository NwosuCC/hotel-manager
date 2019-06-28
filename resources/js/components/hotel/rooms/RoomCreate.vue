<template>

  <div class="card my-4">

    <h5 class="card-header">
      <span v-if="room">Edit Room </span>
      <span v-else>Create Room </span>
    </h5>

    <div class="card-body">

      <form method="POST" @submit.prevent="submitRoomForm" class="pb-4 px-3">
        <!-- Room Type -->
        <div class="form-group">
          <label class="col-form-label" for="room_type_id">* Room Type</label>

          <select id="room_type_id" v-model="form.room_type_id" :class="{'is-invalid': errors.room_type_id}" class="form-control">
            <option value="">- select -</option>
            <option v-for="{ id, name } in roomTypes" :value="id">{{ name }}</option>
          </select>

          <span v-if="errors.room_type_id" class="invalid-feedback" role="alert">
              <strong>{{ errors.room_type_id[0] }}</strong>
          </span>
        </div>

        <!-- Name -->
        <div class="form-group">
          <label class="col-form-label" for="name">* Name</label>

          <input type="text" id="name" v-model="form.name" :class="{'is-invalid': errors.name}" class="form-control" />

          <span v-if="errors.name" class="invalid-feedback" role="alert">
              <strong>{{ errors.name[0] }}</strong>
          </span>
        </div>

        <button type="submit" class="btn btn-primary">Save Room</button>
      </form>
    </div>

  </div>

</template>

<script>
  import { ApiService } from '../../../services/api-service';

  export default {
    name: 'RoomCreate',

    data() {
      return {
        hotel: null,
        roomTypes: [],
        form: { name: '', room_type_id: '', hotel_id: '' },
        errors: {},
        room: null
      };
    },

    beforeRouteEnter (to, from, next) {
      let id = to.params['id'] || null;
      if(id){
        ApiService.getRoomDetails(id, (err, data) => {
          next(vm => vm.setData(err, data));
        });
      }
      else {
        next();
      }
    },

    beforeRouteUpdate (to, from, next) {
      this.form = { name: '', room_type_id: '' };

      let id = to.params['id'] || null;
      if(id){
        ApiService.getRoomDetails(id, (err, data) => {
          this.setData(err, data);
          next();
        });
      }
      else {
        next();
      }
    },

    created(){
      ApiService.getHotel((err, data) => {
        if(err){
          this.error = err.toString();
        }
        else {
          this.hotel = data || [];
          this.form.hotel_id = this.hotel.id;
        }
      });

      ApiService.getRoomTypes(null, (err, data) => {
        (err) ? this.error = err.toString() : this.roomTypes = data || [];
      });
    },

    methods: {
      setData(err, data) {
        if (err) {
          this.error = err.toString();
        }
        else {
          this.room = data;
          this.form = {
            name: this.room.name, room_type_id: this.room.room_type_id
          };
        }
      },
      submitRoomForm(){
        (this.room) ? this.updateRoom() : this.addRoom();
      },
      addRoom(){
        ApiService.addRoom(this.form, this.postResponseHandler);
      },
      updateRoom(){
        ApiService.updateRoom(this.form, this.room.id, this.postResponseHandler);
      },
      postResponseHandler(error, data){
        if(error){
          try{ this.errors = JSON.parse( data.message ); }catch (error){}
        }
        else {
          this.room = data;
          this.$router.push({ name: 'room.index'});
        }
      },
    }
  }
</script>

<style scoped>
  .invalid-feedback {
    font-size: 14px;
  }
</style>