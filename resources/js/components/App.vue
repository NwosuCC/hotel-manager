<template>

  <div>

    <!-- Message Alert -->
    <flash-message></flash-message>


    <!-- Nav Bar -->
    <app-nav :authUser="authUser" :activeRouteName="activeRouteName"></app-nav>

    <main class="d-flex mt-5 py-4" style="min-height: 75vh;">

      <div class="container">

        <!-- Add Loading... Spinner here -->

<!--        <router-view></router-view>-->
        <!-- use a dynamic transition name -->
        <transition :name="transitionName">
          <router-view></router-view>
        </transition>

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
        activeRouteName: this.$router.currentRoute.name,
        transitionName: 'slide-left'
      };
    },

    mounted(){
      this.$nextTick(function () {
        // Retrieve and dispatch default data :: { hotel, authUser }, if exists on localStorage
        this.authUser = AuthService.getUser();
        this.eventBus.$emit('user:authenticated', this.authUser);

        this.hotel = StorageService.getLocal('hotel');
        this.eventBus.$emit('hotel:loaded', this.hotel);
      })
    },

    watch:{
      $route (to, from){
        this.activeRouteName = this.$router.currentRoute.name;
        // Calculate page slide direction
        const toDepth = to.path.split('/').length;
        const fromDepth = from.path.split('/').length;
        this.transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left';
      }
    },
  }
</script>
