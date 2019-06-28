<template>

  <div v-if="hotel" class="container">

    <!-- Heading Row -->
    <div class="row align-items-center my-5">

      <div class="col-lg-7">
        <img class="img-fluid rounded mb-4 mb-lg-0" :src="hotelLogo" alt="">
      </div>

      <div class="col-lg-5">
        <h1 class="font-weight-light">
          {{ hotel.name }} Hotels
        </h1>
        <p>
          Located at {{ hotel.address }}, here you've got a great place to relax and put things together.
          We offer modern, standard facilities and services you'll definitely love, at really competitive prices.
          Try here the next time out, and feel the difference that will make you want to always come back!
        </p>
        <a class="btn btn-primary" href="#">Take a Tour</a>
      </div>
      <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->

    <!-- Call to Action Well -->
    <div class="card text-white bg-secondary my-5 py-4 text-center">
      <div class="card-body">
        <p class="text-white m-0">This call to action card is a great place to showcase some important information or display a clever tagline!</p>
      </div>
    </div>

    <!-- Content Row -->
    <div class="row">
      <div class="col-md-4 mb-5">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="card-title">Card One</h2>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn btn-primary btn-sm">More Info</a>
          </div>
        </div>
      </div>
      <!-- /.col-md-4 -->
      <div class="col-md-4 mb-5">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="card-title">Card Two</h2>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod tenetur ex natus at dolorem enim! Nesciunt pariatur voluptatem sunt quam eaque, vel, non in id dolore voluptates quos eligendi labore.</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn btn-primary btn-sm">More Info</a>
          </div>
        </div>
      </div>
      <!-- /.col-md-4 -->
      <div class="col-md-4 mb-5">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="card-title">Card Three</h2>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn btn-primary btn-sm">More Info</a>
          </div>
        </div>
      </div>
      <!-- /.col-md-4 -->

    </div>
    <!-- /.row -->

  </div>

</template>

<script>
  import { ApiService } from '../../services/api-service';
  import { StorageService } from '../../services/storage-service';

  export default {
    name: 'Hotel',
    data() {
      return {
        eventBus: vmEvents,
        hotel: null,
        error: null,
        hotelLogo: 'images/eerie-home.jpg', // ToDo: fix this into hotel :: maybe, fetch from disk
      };
    },
    mounted(){
      this.$nextTick(function(){
        // Get hold of stored Hotel info from App.vue, on any other page reload
        this.eventBus.$on('hotel:loaded', (hotel) => {
          this.hotel = hotel;
        });
      });
    },
    beforeRouteEnter (to, from, next) {
      ApiService.getHotel((err, data) => {
        next(vm => vm.setData(err, data));
      });
    },
    beforeRouteUpdate (to, from, next) {
      ApiService.getHotel((err, data) => {
        this.setData(err, data);
        next();
      });
    },
    methods: {
      setData(err, response) {
        if (err) {
          this.error = err.toString();
        }
        else {
          StorageService.setLocal('hotel', response);
          this.hotel = response;
          this.eventBus.$emit('hotel:loaded', this.hotel);
        }
      },
    }
  }
</script>