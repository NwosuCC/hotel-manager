<template>

  <!--<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">-->
  <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top shadow-sm">

    <div class="container">

      <!-- App Title -->
      <a v-if="hotel" class="navbar-brand" href="/">
        {{ hotel.name }}
      </a>

      <!-- Right Menu Toggle -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Top Nav Links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- Left Side Of Navbar :: Menu Links -->
        <ul class="navbar-nav mr-auto d-sm-flex">

          <li class="nav-item dropdown">

            <a id="navbarDropdown2" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              Menu <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <router-link :to="{ name: 'room.index' }" class="dropdown-item">Rooms</router-link>
            </div>
          </li>
        </ul>

        <!-- Right Side Of Navbar :: Auth Links -->
        <ul class="navbar-nav ml-auto">

          <!-- Guest Links -->
          <li v-if=" ! authUser" class="nav-item">
            <router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
          </li>

          <li v-if=" ! authUser" class="nav-item">
            <router-link :to="{ name: 'register' }" class="nav-link">Register</router-link>
          </li>

          <!-- Auth User Links -->
          <li v-if="authUser" class="nav-item dropdown">

            <!-- User Avatar | Menu -->
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              authUser.name <span class="caret"></span>
            </a>

            <!-- Logout -->
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <router-link :to="{ name: 'logout' }" class="nav-link">Logout</router-link>
            </div>

          </li>

        </ul>
      </div>
    </div>
  </nav>

</template>

<script>
  export default {
    name: 'AppNav',
    data() {
      return {
        eventBus: vmEvents,
        hotel: null,
        authUser: null,
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
