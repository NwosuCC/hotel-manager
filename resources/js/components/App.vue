<template>

  <div>

    <!-- Message Alert -->
    <flash-message></flash-message>


    <!-- Nav Bar -->
    <app-nav :authUser="authUser"></app-nav>

    <main class="d-flex mt-5 py-4" style="min-height: 390px;">

      <div class="container">

        <!-- Add Loading... Spinner here -->

        <router-view></router-view>

      </div>

    </main>


    <!-- Footer -->
    <app-footer></app-footer>

  </div>

</template>

<script>
  import AppNav from './parts/AppNav.vue';
  import AppFooter from './parts/AppFooter.vue';
  import FlashMessage from './parts/FlashMessage.vue';
  import {AuthService} from "../services/auth-service";
  import {StorageService} from "../services/storage-service";

  export default {
    name: 'App',
    component: {
      'app-nav': AppNav,
      'app-footer': AppFooter,
      'flash-message': FlashMessage
    },
    data() {
      return {
        eventBus: vmEvents,
        authUser: null,
        hotel: null,
        year: (new Date()).getFullYear(),
      };
    },
    mounted(){
      this.$nextTick(function () {
        // Retrieve and dispatch default data :: { hotel, authUser }, if exists on localStorage
        this.authUser = AuthService.getCookie();
        this.eventBus.$emit('user:authenticated', this.authUser);

        this.hotel = StorageService.getLocal('hotel');
        this.eventBus.$emit('hotel:loaded', this.hotel);
      })
    },
  }
</script>
