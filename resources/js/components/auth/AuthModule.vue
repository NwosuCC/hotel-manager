<script>
  import Login from './Login.vue';
  import Register from './Register.vue';

  export default [
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
  ]
</script>