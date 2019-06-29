<template>

  <div class="card my-4">

    <h5 class="card-header">Bookings</h5>

    <div class="card-body">

      <!-- Add Button -->
      <div class="row pb-3">
        <div class="col-4 small">
          <select @change="filterByDate('year',$event.target.value)" :value="query.year" id="year" class="small form-control form-control-sm">
            <option value="">- year -</option>
            <option v-for="y in 10" :value="initialYear + y">{{ initialYear + y }}</option>
          </select>
        </div>

        <div class="col-4 small">
          <select @change="filterByDate('month',$event.target.value)" :value="query.month" id="month" class="small form-control form-control-sm">
            <option value="">- month -</option>
            <option v-for="month in Months" :value="month">{{ month }}</option>
          </select>
        </div>

        <div class="col-4">
          <router-link :to="{ name: 'booking.create' }" class="btn-clear info rounded pull-right">
            <i class="la la-plus mr-2"></i> Booking
          </router-link>
        </div>
      </div>

      <!-- List -->
      <div class="table-responsive" :style="{'min-height': minHeight + 'px'}">
        <table class="table text-nowrap" id="list-table">
          <thead>
          <tr>
            <th class="border-top-0">#</th>
            <th class="border-top-0">Room</th>
            <th class="border-top-0">Type</th>
            <th class="border-top-0">Price</th>
            <th class="border-top-0">Start Date</th>
            <th class="border-top-0">End Date</th>
            <th class="border-top-0">Total Nights</th>
            <th class="border-top-0">Total Price</th>
            <th class="border-top-0">Name</th>
            <th class="border-top-0">Email</th>
            <th class="border-top-0">Date Booked</th>
            <th class="border-top-0">Actions</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(booking, i) in bookings" :key="booking.id">
            <td>{{ startIndex + i }}</td>
            <td>{{ booking.room.name }}</td>
            <td>{{ booking.room.room_type.name }}</td>
            <td>{{ booking.room.room_type.price }}</td>
            <td>{{ booking.start_date | dayDate }}</td>
            <td>{{ booking.end_date | dayDate }}</td>
            <td>{{ booking.total_nights }}</td>
            <td>{{ booking.total_price }}</td>
            <td>{{ booking.customer_full_name }}</td>
            <td>{{ booking.customer_email }}</td>
            <td>{{ booking.created_at | dayDate }}</td>
            <td class="text-center">
              <router-link :to="{ name: 'booking.edit', params: {id: booking.id} }" class="btn btn-sm btn-light btn-outline-info mr-1 py-0 px-1">
                <i class="la la-pencil"></i>
              </router-link>
              <a @click="deleteItem(i, booking.id)" class="btn btn-sm btn-light btn-outline-danger text-danger mr-1 py-0 px-1">
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
    name: 'BookingIndex',
    components: {
      'Pagination': Pagination,
    },

    data() {
      return {
        eventBus: vmEvents,
        bookings: [],
        pageInfo: null,
        error: null,
        minHeight: 0,
        startIndex: 1,
        initialYear: 2013,
        Months: [
          'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ],
        query: {
          year: this.$route.query.year || '', month: this.$route.query.month || '',
        },
    };
    },

    beforeRouteEnter (to, from, next) {
      ApiService.getBookingsPaginated(to.query, (err, data) => {
        next(vm => vm.setData(err, data));
      });
    },

    beforeRouteUpdate (to, from, next) {
      this.bookings = [];
      this.query = {
        year: to.query.year || '', month: to.query.month || '',
      };

      ApiService.getBookingsPaginated(to.query, (err, data) => {
        this.setData(err, data);
        next();
      });
    },

    methods: {
      filterByDate(part, value){
        let { year, month, ...other } = Object.assign({}, this.$route.query, {[part]: value});
        this.$router.push({
          query : { ...other, year, month }
        });
      },
      setData(err, { data, links, meta }) {
        if (err) {
          this.error = err.toString();
        }
        else {
          this.bookings = data;
          this.pageInfo = { meta, links, index: 'booking.index' };
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
          ApiService.deleteBooking(id, (error, data) => {
            if(error){
              this.errors = data.message;
              this.eventBus.$emit('flash:data', {message: data.message, type: 'danger'});
            }
            else {
              this.bookings.splice( index, 1 );
              this.eventBus.$emit('flash:data', {message: data.message});
            }
          });
        }
      }
    }
  }
</script>