import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use( VueRouter );


import {AuthService} from "./auth-service";

import AuthModule from '../components/auth/AuthModule.vue';
import e403 from '../components/error/e403.vue';
import e404 from '../components/error/e404.vue';

import Hotel from '../components/hotel/Hotel.vue';
import RoomTypeModule from '../components/hotel/room-types/RoomTypeModule.vue';
import RoomModule from '../components/hotel/rooms/RoomModule.vue';
import BookingModule from '../components/hotel/bookings/BookingModule.vue';
import {StorageService} from "./storage-service";


//ToDo: using title-case 'Router' will cause an error. Find out why?
const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Hotel,
      props: true // pass route params to target component
    },

    // Array de-structure of Auth components :: [Login, Register, etc]
    ...AuthModule,
    // {
    //   path: '/login',
    //   name: 'login',
    //   component: Login,
    // },
    // {
    //   path: '/register',
    //   name: 'register',
    //   component: Register,
    // },


    // Object containing the root RoomType and its sub-components :: {RoomTypeIndex, RoomTypeCreate, etc}
    RoomTypeModule,
    // {
    //   path: '/room-types',
    //   component: RoomType,
    //   children: [
    //     {
    //       path: '',
    //       name: 'room-type.index',
    //       component: RoomTypeIndex,
    //     },
    //     {
    //       path: 'create',
    //       name: 'room-type.create',
    //       component: RoomTypeCreate,
    //     }
    //   ]
    // }

    // Object containing the root Room and its sub-components :: {RoomIndex, RoomCreate, etc}
    RoomModule,
    // {
    //   path: '/rooms',
    //   name: 'room.index',
    //   component: RoomIndex,
    // },

    // Object containing the root Booking and its sub-components :: {BookingIndex, BookingCreate, etc}
    BookingModule,
    // {
    //   path: '/bookings',
    //   name: 'booking.index',
    //   component: BookingIndex,
    // },


    {
      path: '/error/:type',
      name: 'error',
      component: e403,
    },

    {
      path: '*',
      component: e404,
    },
  ]
});

// Overall Auth Guard
router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some((record) => {
    return record.meta.requiresAuth;
  });

  const requiresSU = to.matched.some((record) => {
    return record.meta.requiresSU;
  });

  const isLoggedIn = AuthService.userAuthenticated();
  const isAdmin = AuthService.isSuperUser();

  const signInRoute = '/login';
  const noAuthRoute = { name: 'error', params: {type:'unauthorised'} };

  if (requiresSU && ! isAdmin) {
    next(isLoggedIn ? noAuthRoute : signInRoute);
  }
  else if (requiresAuth && ! isLoggedIn) {
    StorageService.setSession('route:to', to);
    next(signInRoute);
  }
  else {
    next();
  }
});


export { router };
