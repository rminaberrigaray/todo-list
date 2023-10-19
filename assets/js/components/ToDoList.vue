<template>
  <transition
    enter-active-class="transition-opacity duration-300"
    leave-active-class="transition-opacity duration-300"
    enter-class="opacity-0"
    leave-to-class="opacity-0"
    mode="out-in"
  >
    <loader v-if="loading" />
    <div v-else class="space-y-4">
      <div class="text-3xl">
        Welcome <span class="italic">{{ user.username }}</span>!
      </div>
      <div class="space-y-1 max-w-xl mx-auto">
        <div class="text-xl text-center">
          This is your To Do List
        </div>
        <transition
          enter-active-class="transition-opacity duration-300"
          leave-active-class="transition-opacity duration-300"
          enter-class="opacity-0"
          leave-to-class="opacity-0"
          mode="out-in"
        >
          <div v-if="saving" class="flex space-x-2 items-center text-sm">
            <spinner class="w-4 h-4" />
            <span>Saving...</span>
          </div>
          <div v-else-if="lastSaved" class="text-sm">
            Last changes saved at: {{ lastSaved.toLocaleString("en-US") }}
          </div>
        </transition>
        <transition
          enter-active-class="transition-opacity duration-300"
          leave-active-class="transition-opacity duration-300"
          enter-class="opacity-0"
          leave-to-class="opacity-0"
          mode="out-in"
        >
          <Empty v-if="tasks.length === 0" message="Your task list is empty" />
          <div v-else class="flex flex-col w-full space-y-4">
            <Task v-for="task in tasks" :key="task.id" :task="task" />
          </div>
        </transition>
      </div>
    </div>
  </transition>
</template>

<script>
import Loader from './Loader.vue'
import Task from './Task.vue'
import Spinner from './Spinner.vue'
import Empty from './Empty.vue'

export default {
  
  components: { Loader, Task, Spinner, Empty },

  data() {
    return {
      loading: true,
      token: null,
      user: null,
      tasks: [],
      saving: false,
      lastSaved: null,
    }
  },

  async created() {
    try {
      this.token = sessionStorage.getItem('token');
      if (!this.token) throw 'No token found in session storage'
      this.user = await this.fetchUser()
      this.tasks = await this.fetchUserTasks()
      this.loading = false
    } catch (error) {
      window.location.replace('/login')
    }
  },

  methods: {
    async fetchUser() {
      const response = await axios.get('/api/users/token-info', {
        headers: {
          'Accept': 'application/json',
          'Authorization': `Bearer ${this.token}`
        }
      })
      return response.data.data
    },
    async fetchUserTasks() {
      const response = await axios.get(`/api/users/${this.user.id}`, {
        headers: {
          'Accept': 'application/json',
          'Authorization': `Bearer ${this.token}`
        }
      })
      return response.data.data.tasks
    },
  }
}
</script>
