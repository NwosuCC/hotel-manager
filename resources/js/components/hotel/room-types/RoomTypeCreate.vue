<template>

  <div class="card my-4">

    <h5 class="card-header">
      <span v-if="roomType">Edit Room Type</span>
      <span v-else>Create Room Type</span>
    </h5>

    <div class="card-body">

      <form method="POST" @submit.prevent="submitRoomTypeForm" class="pb-4 px-3">
        <div class="form-group">
          <label class="col-form-label" for="name">* Name</label>

          <input type="text" id="name" v-model="form.name" :class="{'is-invalid': errors.name}" class="form-control" />

          <span v-if="errors.name" class="invalid-feedback" role="alert">
              <strong>{{ errors.name[0] }}</strong>
          </span>
        </div>

        <div class="form-group">
          <label class="col-form-label" for="price">* Price (USD)</label>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">$</span>
            </div>
            <input type="number" min="0" step="any" id="price" v-model.number="form.price" :class="{'is-invalid': errors.price}" class="form-control" />
            <!--<div class="input-group-append">-->
              <!--<span class="input-group-text">.00</span>-->
            <!--</div>-->
          </div>

          <span v-if="errors.name" class="invalid-feedback" role="alert">
              <strong>{{ errors.price[0] }}</strong>
          </span>
        </div>

        <button type="submit" class="btn btn-primary">Save Room Type</button>
      </form>
    </div>

  </div>

</template>

<script>
  import { ApiService } from '../../../services/api-service';

  export default {
    name: 'RoomTypeCreate',

    data() {
      return {
        form: { name: '', price: null },
        errors: {},
        roomType: null
      };
    },

    beforeRouteEnter (to, from, next) {
      let id = to.params['id'] || null;
      if(id){
        ApiService.getRoomTypeDetails(id, (err, data) => {
          next(vm => vm.setData(err, data));
        });
      }
      else {
        next();
      }
    },

    beforeRouteUpdate (to, from, next) {
      this.form = { name: '', price: null };
      let id = to.params['id'] || null;
      if(id){
        ApiService.getRoomTypeDetails(id, (err, data) => {
          this.setData(err, data);
          next();
        });
      }
      else {
        next();
      }
    },

    methods: {
      setData(err, data) {
        if (err) {
          this.error = err.toString();
        }
        else {
          this.roomType = data;
          this.form = {
            name: this.roomType.name, price: this.roomType.price
          };
        }
      },
      submitRoomTypeForm(){
        (this.roomType) ? this.updateRoomType() : this.addRoomType();
      },
      addRoomType(){
        ApiService.addRoomType(this.form, this.postResponseHandler);
      },
      updateRoomType(){
        ApiService.updateRoomType(this.form, this.roomType.id, this.postResponseHandler);
      },
      postResponseHandler(error, data){
        if(error){
          try{ this.errors = JSON.parse( data.message ); }catch (error){}
        }
        else {
          this.roomType = data;
          this.$router.push({ name: 'room-type.index'});
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