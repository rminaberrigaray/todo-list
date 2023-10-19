<template>
  <div class="h-[80vh] w-full flex flex-col items-center justify-center space-y-4">
    <spinner class="w-24 h-24" />
    <div class="flex flex-col justify-center mb-6 text-center">
      <div class="text-xl font-medium tracking-wide text-gray-600 dark:text-gray-200">
        Loading...
      </div>
    </div>
  </div>
</template>

<script>
import Spinner from './Spinner.vue';

export default {
  
  components: { Spinner }
  
}

</script>