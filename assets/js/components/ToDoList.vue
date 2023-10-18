<template>
  <div>
    Cake + Vue test
  </div>
</template>

<script>
export default {
  mounted() {
    console.log(sessionStorage.getItem('token'));
  }
}
</script>
