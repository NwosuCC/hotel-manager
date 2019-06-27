<template>

  <div class="pg-footer">

    <div v-if="hotel" class="w-100 pt-4 pb-2 px-5 bg-secondary">
      <div class="row">
        <div class="col-12 col-sm-6 col-lg-4 offset-lg-2">
          <p class="m-0 text-warning">Address</p>
          <ul class="list-unstyled text-light">
            <li>
              {{ hotel.address + (hotel.address ? ',' : '') }}
            </li>
            <li>
            <span class="mr-2">
              {{ hotel.city }}
            </span>
              <span v-if="hotel.zip_code">
              ({{ hotel.zip_code }})
            </span>
              <span v-if="hotel.city || hotel.zip_code">, </span>
            </li>
            <li>
              {{ hotel.country }}
            </li>
          </ul>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 offset-lg-2">
          <p class="m-0 text-warning">Contacts (24/7)</p>
          <ul class="list-unstyled text-light">
            <li class="row">
              <i class="col-1 pt-1 mr-2 fa fa-phone"></i>
              <span>{{ hotel.phone_number }}</span>
            </li>
            <li class="row">
              <i class="col-1 pt-1 mr-2 fa fa-envelope"></i>
              <span>{{ hotel.email }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <footer v-if="hotel" class="py-3 bg-dark">

      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; {{ hotel.name }} {{ year }}</p>
      </div>

    </footer>

  </div>


</template>

<script>
  export default {
    name: 'AppFooter',
    data() {
      return {
        hotel: null,
        eventBus: vmEvents,
        year: (new Date()).getFullYear(),
      };
    },
    mounted(){
      this.$nextTick(function(){
        this.eventBus.$on('hotel:loaded', (hotel) => {
          this.hotel = hotel;
        });
      })
    }
  }
</script>
