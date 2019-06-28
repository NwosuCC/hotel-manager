<template>

  <div v-if="message" id="flash-message" :class="alertClass" role="alert"
       style="position: fixed; z-index: 10000; top: 3px; right:15px; min-width: 300px; border-radius: 1px;">

    {{ message }}

  </div>

</template>

<script>
  export default {
    name: 'FlashMessage',
    data(){
      return {
        eventBus: vmEvents,
        message: null, alertClass: null
      }
    },
    mounted(){
      this.$nextTick(function(){
        this.eventBus.$on('flash:data', ({message, type}) => {
          this.flash(message, type);
        });
      })
    },
    methods: {
      flash(message, type){
        this.message = String( message ).trim();
        this.alertClass = 'alert alert-' + (type || 'success');

        setTimeout(() => {
          document.getElementById('flash-message').setAttribute('style', "display:none");
          this.message = null;
        }, 5000);
      },
    },
  }
</script>
