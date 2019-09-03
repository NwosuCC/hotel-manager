<template>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Register</div>

          <div class="card-body">
            <form method="POST" @submit.prevent="Register" class="pb-4 px-3">
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">
                  Name
                </label>

                <div class="col-md-6">
                  <input id="name" type="text" :class="{'is-invalid': hasError('name')}" class="form-control"
                         v-model="form.name" required autocomplete="name" autofocus>

                  <form-error-alert :error="errors.name"></form-error-alert>
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">
                  E-Mail Address
                </label>

                <div class="col-md-6">
                  <input id="email" type="email" :class="{'is-invalid': hasError('email')}" class="form-control"
                         v-model="form.email" required autocomplete="email" autofocus>

                  <form-error-alert :error="errors.email"></form-error-alert>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">
                  Password
                </label>

                <div class="col-md-6">
                  <input id="password" type="password" :class="{'is-invalid': hasError('password')}" class="form-control"
                         v-model="form.password" required autocomplete="current-password" autofocus>

                  <form-error-alert :error="errors.password" :name="'password'"></form-error-alert>
                </div>
              </div>

              <div class="form-group row">
                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">
                  Confirm Password
                </label>

                <div class="col-md-6">
                  <input id="password_confirmation" type="password" :class="{'is-invalid': hasError('password_confirmation')}" class="form-control"
                         v-model="form.password_confirmation" required autocomplete="current-password" autofocus>

                  <form-error-alert :error="errors.password_confirmation"></form-error-alert>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Register
                  </button>

                  <router-link :to="{ name: 'login' }" class="btn btn-link pull-right">
                    Sign In
                  </router-link>
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
  import {ApiService} from "../../services/api-service";
  import FormErrorAlert from "../common/FormErrorAlert";
  import {StorageService} from "../../services/storage-service";
  import {AlertService} from "../../services/alert-service";

  export default {
    name: 'Register',

    components: {
      'form-error-alert': FormErrorAlert
    },

    data() {
      return {
        eventBus: vmEvents,
        form: {
          name: '', email: '', password: '', password_confirmation: ''
        },
        errors: {},
        error: null,
      }
    },

    methods: {
      old(field){

      },
      hasError(field){
        return this.errors.hasOwnProperty( field );
      },
      route(field){

      },
      Register(){
        this.error = null;

        ApiService.register(this.form, (error, data) => {
          if (error) {
            if(data.errors){
              this.errors = data.errors;
            }
            else {
              AlertService.error(data.message);
            }
          }
          else {
            let {name, email} = data;
            StorageService.setSession('reg:info', {name, email});
            this.$router.push('login');
          }
        });
      }
    }
  }
</script>
