<template>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!-- Test Admin -->
        <div class="row mt-3 mb-5 py-2 border border-dark border-left-0 border-right-0">
          <div class="col-4 text-right">Test Admin</div>
          <div class="col-8">
            <div>Username: <span v-if="admin">{{ admin.email }}</span></div>
            <div>Password: <span v-if="admin">{{ admin.password }}</span></div>
          </div>
        </div>

        <div class="card mt-2 mb-4">
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
  import {AlertService} from "../../services/alert-service";

  export default {
    name: 'Login',

    data() {
      return {
        eventBus: vmEvents,
        authUser: null,
        form: {},
        error: null,
        admin: null
      }
    },

    beforeRouteEnter (to, from, next) {
      AuthService.endSession();

      // De-activate Auth User info set at various parts of the app
      vmEvents.$emit('user:authenticated', null);
      console.log('Login: auth ended');

      // If the current user has just registered, retrieve the locally-stored data
      let regInfo = StorageService.pullSession('reg:info') || {};

      // Fetch demo Admin login credentials (for test purposes only)
      ApiService.getDemoData((err, data) => {
        next(vm => vm.setData(err, data, regInfo));
      });
    },

    methods: {
      setData(err, data, {name, email}) {
        if (err) {
          this.error = err.toString();
        }
        else {
          this.admin = data['admin'];
        }
        // If previous route is '/register' and registration was successful
        if(name){
          AlertService.success(`${name}, your account has been created. Please, login to continue`);
          this.form.email = email;
        }
      },
      Login(){
        this.error = null;

        ApiService.login(this.form, (error, data) => {
          if (error) {
            this.error = data.message;
          }
          else {
            AuthService.startSession( data );
            let nextRoute = StorageService.pullSession('route:to');
            window.location.href = nextRoute ? nextRoute.fullPath : '/';
            // nextRoute ? this.$router.push(nextRoute) : window.location.href = '/';
            // this.$router.go(-1);
          }
        });
      }
    }
  }
</script>
