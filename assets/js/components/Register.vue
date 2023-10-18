<template>
  <div class="w-full flex min-h-screen items-center justify-center bg-white dark:bg-gray-950 p-12">
    <form action="">
      <div class="max-w-sm rounded-3xl bg-gradient-to-b from-sky-300 to-purple-500 p-px dark:from-gray-800 dark:to-transparent">
        <div class="rounded-[calc(1.5rem-1px)] bg-white px-10 p-12 dark:bg-gray-900">
          <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Create new account</h1>
            <p class="text-sm tracking-wide text-gray-600 dark:text-gray-300">Already have an account? <a href="/login" class="text-blue-600 transition duration-200 hover:underline dark:text-blue-400">Login</a></p>
          </div>

          <div class="mt-8 space-y-8">
            <div class="space-y-6">
              <input
                class="w-full bg-transparent text-gray-600 dark:text-white dark:border-gray-700 rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-600 invalid:border-red-500 dark:placeholder-gray-300" 
                placeholder="Username" name="username" id="username" 
                v-model="username"
              />

              <input 
                class="w-full bg-transparent text-gray-600 dark:text-white dark:border-gray-700 rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-600 invalid:border-red-500 dark:placeholder-gray-300"
                placeholder="Password" type="password" name="password" id="password" 
                v-model="password"
              />
            </div>
            <div v-if="error" class="text-red-500">{{ error }}</div>

            <button 
              class="h-9 px-3 w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 focus:bg-blue-700 transition duration-500 rounded-md text-white"
              type="button"
              :disabled="!username || !password"
              @click="register"
            >
              Register
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: null,
      password: null,
      error: null
    }
  },
  
  methods: {
    async register() {
      try {
        const response = await axios.post(
          '/api/users/register', 
          {
            username: this.username,
            password: this.password
          },
          { headers: { 'Accept': 'application/json' } }
        )
        sessionStorage.setItem('token', response.data.data.token)
        window.location.replace('/')
      } catch (error) {
        this.error = 'Username already in use'
      }
    }
  }
}
</script>
