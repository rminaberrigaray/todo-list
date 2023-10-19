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
        <div class="py-2">
          <input
            class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            type="text" 
            placeholder="Add new task (press enter)"
            v-model="newTaskDescription"
            @keyup.enter="newTask"
          >
        </div>
        <transition
          enter-active-class="transition-opacity duration-300"
          leave-active-class="transition-opacity duration-300"
          enter-class="opacity-0"
          leave-to-class="opacity-0"
          mode="out-in"
        >
          <Empty v-if="tasks.length === 0" message="Your task list is empty" />
          <div v-else class="flex flex-col w-full space-y-2">
            <Task 
              v-for="task in tasks" :key="task.id" 
              :task="task" 
              @change-completed="onChangeCompleted($event, task)"
              @remove="removeTask"
            />
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

const defaultHeaders = (token) => {
   return {
    'Accept': 'application/json',
    'Authorization': `Bearer ${token}`
  }
}

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
      newTaskDescription: null
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
        headers: defaultHeaders(this.token)
      })
      return response.data.data
    },
    async fetchUserTasks() {
      const response = await axios.get(`/api/users/${this.user.id}`, {
        headers: defaultHeaders(this.token)
      })
      return response.data.data.tasks
    },
    async onChangeCompleted(value, task) {
      task.completed = value
      this.saving = true
      await this.updateTask(task)
      this.lastSaved = new Date()
      this.saving = false
    },
    async onEnterKeyup(event) {
      if (event.target.value) {
        await this.newTask(event.target.value)
      }
    },
    async newTask() {
      if(this.newTaskDescription) {
        this.saving = true
        await axios.post('/api/tasks',
          { 
            user_id: this.user.id,
            description: this.newTaskDescription 
          }, 
          { headers: defaultHeaders(this.token) }
        )
          this.lastSaved = new Date()
          this.saving = false
          this.newTaskDescription = null
          this.tasks = await this.fetchUserTasks()
      }
    },
    async updateTask(task) {
      await axios.patch(`/api/tasks/${task.id}`,
        { completed: task.completed }, 
        { headers: defaultHeaders(this.token) }
      )
    },
    async removeTask(task) {
      this.saving = true
      await axios.delete(`/api/tasks/${task.id}`,
        { headers: defaultHeaders(this.token) }
      )
      this.lastSaved = new Date()
      this.saving = false
      this.newTaskDescription = null
      this.tasks = await this.fetchUserTasks()
    }
  }
}
</script>
