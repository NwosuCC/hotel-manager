<template>

  <div>

    <!-- Nav Bar -->
    <app-nav :authUser="authUser"></app-nav>

    <main class="py-4">

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

  export default {
    name: 'App',
    component: {
      'app-nav': AppNav,
      'app-footer': AppFooter
    },
    data() {
      return {
        eventBus: vmEvents,
        // ToDo: wire this up
        authUser: null,
        year: (new Date()).getFullYear(),
      };
    },
  }
</script>
