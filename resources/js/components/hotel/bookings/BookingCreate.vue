<template>

  <div class="card my-4">

    <h5 class="card-header">
      <span v-if="booking">Edit Booking </span>
      <span v-else>Create Booking </span>
      <!--<span class="pull-right badge badge-pill badge-sm badge-success font-weight-light text-small">Running</span>-->
    </h5>

    <div class="card-body">

      <form method="POST" @submit.prevent="submitBookingForm" class="pb-4 px-3">
        <div class="row form-group">
          <!-- Room Type -->
          <div class="col-12 col-sm-6">
            <label class="col-form-label" for="room_id">* Room Type</label>

            <!--<select :disabled="booking && booking.is_active" v-model="form.room_type_id"-->
            <select v-model="form.room_type_id"
                    @change="filterRooms($event.target.value)" id="room_type_id" class="form-control">
              <option value="">- select -</option>
              <option v-for="{ id, name } in roomTypes" :value="id">{{ name }}</option>
            </select>
          </div>

          <!-- Room -->
          <div class="col-12 col-sm-6">
            <label class="col-form-label" for="room_id">* Room</label>

            <select v-model="form.room_id" :class="{'is-invalid': errors.room_id}" id="room_id" class="form-control">
              <option value="">- select -</option>
              <option v-for="{ id, name } in filteredRooms" :value="id">{{ name }}</option>
            </select>

            <span v-if="errors.room_id" class="invalid-feedback" role="alert">
                <strong>{{ errors.room_id[0] }}</strong>
            </span>
          </div>
        </div>


        <div class="row form-group">
          <!-- Start Date -->
          <div class="col-12 col-sm-6">
            <div class="form-group">
              <label class="col-form-label" for="start_date">* Start Date</label>

              <input type="date" id="start_date"
                     v-model="form.start_date" :class="{'is-invalid': errors.start_date}" class="form-control" />

              <span v-if="errors.start_date" class="invalid-feedback" role="alert">
                  <strong>{{ errors.start_date[0] }}</strong>
              </span>
            </div>
          </div>

          <!-- End Date -->
          <div class="col-12 col-sm-6">
            <label class="col-form-label" for="end_date">* End Date</label>

            <input type="date" id="end_date" v-model="form.end_date" :class="{'is-invalid': errors.end_date}" class="form-control" />

            <span v-if="errors.end_date" class="invalid-feedback" role="alert">
                <strong>{{ errors.end_date[0] }}</strong>
            </span>
          </div>
        </div>

        <div class="row form-group">
          <!-- Customer Name -->
          <div class="col-12 col-sm-6">
            <label class="col-form-label" for="customer_full_name">* Full Name</label>

            <input type="text" id="customer_full_name"
                   v-model="form.customer_full_name" :class="{'is-invalid': errors.customer_full_name}" class="form-control" />

            <span v-if="errors.customer_full_name" class="invalid-feedback" role="alert">
                <strong>{{ errors.customer_full_name[0] }}</strong>
            </span>
          </div>

          <!-- Customer Email -->
          <div class="col-12 col-sm-6">
            <div class="form-group">
              <label class="col-form-label" for="customer_email">* Email Address</label>

              <input type="text" id="customer_email"
                     v-model="form.customer_email" :class="{'is-invalid': errors.customer_email}" class="form-control" />

              <span v-if="errors.customer_email" class="invalid-feedback" role="alert">
                  <strong>{{ errors.customer_email[0] }}</strong>
              </span>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Booking</button>
      </form>
    </div>

  </div>

</template>

<script>
  import { ApiService } from '../../../services/api-service';

  export default {
    name: 'BookingCreate',

    data() {
      return {
        eventBus: vmEvents,
        roomTypes: [],
        rooms: [],
        filteredRooms: [],
        form: {
          name: '', room_id: ''
        },
        errors: {},
        booking: null
      };
    },

    beforeRouteEnter (to, from, next) {
      let id = to.params['id'] || null;
      if(id){
        ApiService.getBookingDetails(id, (err, data) => {
          next(vm => vm.setData(err, data));
        });
      }
      else {
        next();
      }
    },

    beforeRouteUpdate (to, from, next) {
      this.form = {
        name: '', room_id: ''
      };

      let id = to.params['id'] || null;
      if(id){
        ApiService.getBookingDetails(id, (err, data) => {
          this.setData(err, data);
          next();
        });
      }
      else {
        next();
      }
    },

    created(){
      ApiService.getRoomTypes(null, (err, data) => {
        (err) ? this.error = err.toString() : this.roomTypes = data || [];
        this.fillInOldFormValues();
      });

      ApiService.getRooms(null, (err, data) => {
        (err) ? this.error = err.toString() : this.rooms = data || [];
        this.fillInOldFormValues();
      });
    },

    methods: {
      setData(err, data) {
        if (err) {
          this.error = err.toString();
        }
        else {
          this.booking = data;
          this.fillInOldFormValues();
        }
      },

      fillInOldFormValues(){
        let room = this.rooms.find(room => room.id === this.booking.room_id);

        if( ! this.rooms || ! this.roomTypes || ! room){
          return;
        }

        this.filterRooms( room.room_type_id );

        this.form = {
          room_type_id: room.room_type_id,
          room_id: room.id,
          start_date: this.getDatePart( this.booking.start_date ),
          end_date: this.getDatePart( this.booking.end_date ),
          customer_full_name: this.booking['customer_full_name'],
          customer_email: this.booking['customer_email'],
        };
      },

      getDatePart(timestamp){
        // return (new Date( timestamp )).toISOString().split('T')[0];
        let timestampDate = new Date( timestamp );
        let ISODate = new Date(timestampDate.getTime() - (timestampDate.getTimezoneOffset() * 60000)).toISOString();
        return ISODate.split('T')[0];
      },

      filterRooms(id){
        this.form.room_id = '';
        this.filteredRooms = this.rooms.filter(
          room => Number(room.room_type_id) === Number(id)
        );
      },

      submitBookingForm(){
        (this.booking) ? this.updateBooking() : this.addBooking();
      },

      addBooking(){
        ApiService.addBooking(this.form, this.postResponseHandler);
      },

      updateBooking(){
        ApiService.updateBooking(this.form, this.booking.id, this.postResponseHandler);
      },

      postResponseHandler(error, data){
        if(error){
          if(data.errors){
            this.errors = data.errors;
          }
          else {
            this.eventBus.$emit('flash:data', {message: data.message, type: 'danger'});
          }
//          console.log('this.errors: ', this.errors, ' | data: ', data);
        }
        else {
          this.booking = data;
          this.$router.push({ name: 'booking.index'});
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
