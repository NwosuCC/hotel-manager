import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use( VueRouter );

import Hotel from '../components/hotel/Hotel.vue';
import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
import RoomIndex from '../components/hotel/rooms/RoomIndex.vue';


//ToDo: using title-case 'Router' will cause an error. Find out why?
export const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Hotel,
      props: true // pass route params to target component
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
    },
    {
      path: '/rooms',
      name: 'room.index',
      component: RoomIndex,
    },
  ]
});
