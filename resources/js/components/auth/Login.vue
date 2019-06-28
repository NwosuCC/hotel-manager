<template>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <div class="card my-4">
          <div class="card-header">Login</div>

          <div class="card-body">

            <ul v-if="error" class="text-danger pl-4">
              <li class="ml-2">{{ error }}</li>
            </ul>

            <form method="POST" @submit.prevent="Login" class="pb-4 px-3">

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">
                  E-Mail Address
                </label>

                <div class="col-md-6">
                  <input id="email" type="email" v-model="form.email" class="form-control" required autocomplete="email" autofocus>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">
                  Password
                </label>

                <div class="col-md-6">
                  <input id="password" type="password" v-model="form.password" class="form-control" required autocomplete="current-password" autofocus>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input v-model="form.remember" class="form-check-input" type="checkbox" id="remember">

                    <label class="form-check-label" for="remember">
                      Remember Me
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Login
                  </button>

                  <!--@if (Route::has('password.request'))-->
                  <a v-if="1" class="btn btn-link" href="#">
                    Forgot Your Password?
                  </a>
                  <!--@endif-->
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  import { ApiService } from '../../services/api-service';
  import { AuthService } from '../../services/auth-service';
  import {StorageService} from "../../services/storage-service";

  export default {
    name: 'Login',
    data() {
      return {
        eventBus: vmEvents,
        authUser: null,
        form: {},
        error: null
      }
    },
    beforeRouteEnter (to, from, next) {
      AuthService.removeCookie();
      vmEvents.$emit('user:authenticated', null);
      next();
    },
    methods: {
      Login(){
        this.error = null;

        ApiService.Login(this.form, (error, data) => {
          if (error) {
//            this.eventBus.$emit('flash:data', {message: data.message, type: 'danger'});
            this.error = data.message;
          }
          else {
            AuthService.setCookie( data );
            StorageService.setSession( AuthService.getSessionKey(), data.id );
            window.location.href = '/';
          }
        });
      }
    }
  }
</script>
