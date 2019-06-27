<template>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Register</div>

          <div class="card-body">
            <!-- ToDo -->
            <form method="POST" :action="route('login')">
              <!-- ToDo -->
              <!--@csrf-->

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">
                  E-Mail Address
                </label>

                <div class="col-md-6">
                  <input id="email" type="email" :class="{'is-invalid': hasError('email')}" class="form-control"
                         name="email" :value="old('email')" required autocomplete="email" autofocus>

                  <span class="invalid-feedback" role="alert">
                      <strong>{{ errors.email }}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">
                  Password
                </label>

                <div class="col-md-6">
                  <input id="password" type="password" :class="{'is-invalid': hasError('password')}" class="form-control"
                         name="password" required autocomplete="current-password" autofocus>

                  <span class="invalid-feedback" role="alert">
                      <strong>{{ errors.password }}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input :checked="old('remember')" class="form-check-input" type="checkbox" name="remember" id="remember">

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
                  <a v-if="1" class="btn btn-link" :href="route('password.request')">
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
  export default {
    name: 'Register',
    data() {
      return {
        errors: {}
      }
    },
    methods: {
      old(field){

      },
      hasError(field){
        return this.errors.hasOwnProperty( field );
      },
      route(field){

      }
    }
  }
</script>
