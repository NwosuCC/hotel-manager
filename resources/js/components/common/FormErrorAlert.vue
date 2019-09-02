<template>

  <span v-if="error" class="invalid-feedback" role="alert">
      <strong>{{ Array.isArray(error) ? error[0] : error }}</strong>
  </span>

</template>

<script>
  export default {
    name: 'FormErrorAlert',
    props: ['error'],
  }
</script>
