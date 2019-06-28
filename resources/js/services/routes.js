import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use( VueRouter );


// import Login from '../components/auth/Login.vue';
// import Register from '../components/auth/Register.vue';
import AuthModule from '../components/auth/AuthModule.vue';

import Hotel from '../components/hotel/Hotel.vue';

// import RoomType from '../components/hotel/room-types/RoomType.vue';
// import RoomTypeIndex from '../components/hotel/room-types/RoomTypeIndex.vue';
// import RoomTypeCreate from '../components/hotel/room-types/RoomTypeCreate.vue';
import RoomTypeModule from '../components/hotel/room-types/RoomTypeModule.vue';

import RoomIndex from '../components/hotel/rooms/RoomIndex.vue';

import e404 from '../components/error/e404.vue';
import {AuthService} from "./auth-service";


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

    // Array of Auth components :: [Login, Register, etc]
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


    {
      path: '/rooms',
      name: 'room.index',
      component: RoomIndex,
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

  if (requiresAuth && ! AuthService.userAuthenticated()) {
    next('/login');
  } else {
    next();
  }
});


export { router };