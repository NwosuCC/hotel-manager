<template>

  <!--<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">-->
  <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top shadow-sm">

    <div class="container">

      <!-- App Title -->
      <router-link v-if="hotel" :to="{ name: 'home' }" class="navbar-brand">
        {{ hotel.name }}
      </router-link>
      <a v-else class="navbar-brand" href="/">
        Home
      </a>

      <!-- Right Menu Toggle -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Top Nav Links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- Left Side Of Navbar :: Menu Links -->
        <ul v-if="authUser" class="navbar-nav mr-auto d-sm-flex">

          <li class="nav-item dropdown">

            <a id="navbarDropdown2" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              Menu <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

              <router-link :to="{ name: 'room-type.index' }" class="dropdown-item">Room Types</router-link>
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

          <li v-if="authUser" class="nav-item">
            {{ authUser.email }}
          </li>

          <!-- Auth User Links -->
          <li v-if="authUser" class="nav-item dropdown">

            <!-- User Avatar | Menu -->
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ authUser.name }} <span class="caret"></span>
            </a>

            <!-- Logout -->
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a href @click.prevent="logOut()" class="dropdown-item">
                <i class="fa fa-power-off mt-1 mr-2"></i> Logout
              </a>
            </div>

          </li>

        </ul>
      </div>
    </div>
  </nav>

</template>

<script>
  import { ApiService } from '../../services/api-service';
  import {AuthService} from "../../services/auth-service";

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
        this.eventBus.$on('user:authenticated', (user) => {
          this.authUser = user;
        });
      })
    },
    methods: {
      logOut(){
        AuthService.removeCookie();

        ApiService.Logout({}, (error, data) => {
          window.location.href = '';
        });
      }
    }
  }
</script>
