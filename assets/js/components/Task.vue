<template>
  <label 
    class="p-4 w-full group flex items-center space-x-4 text-gray-900 dark:text-gray-300 bg-slate-200 hover:bg-slate-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md select-none cursor-pointer ease-in-out duration-100"
    :for="task.id"
    :title="(task.completed)? 'Mark as pending' : 'Mark as completed'"
  >
    <input 
      class="peer w-6 h-6 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
      :id="task.id" 
      type="checkbox"
      v-model="checked" 
    >
    <input
      v-if="editing"
      class="inline w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      type="text" 
      placeholder="Add new task (press enter)"
      v-model="newDescription"
      @keyup.enter="onChangeDescription"
    >
    <span v-else class="grow text-xl font-medium group-hover:line-through group-hover:peer-checked:no-underline peer-checked:line-through">
      {{ task.description }}
    </span>
    
    <button
      type="button"
      title="Edit"
      @click.stop="editTask"
    >🖊️</button>
    <button
      type="button"
      title="Remove"
      @click.stop="$emit('remove', task)"
    >✖️</button>
  </label>
</template>

<script>
export default {
  
  props: { 
    task: {
      type: Object,
      required: true
    } 
  },

  data() {
    return {
      editing: false,
      newDescription: null,
    }
  },

  computed: {
    checked: {
      get() {
        return this.task.completed
      },
      set(value) {
        this.$emit('change-completed', value)
      }
    }
  },

  methods: {
    editTask() {
      this.editing = true
      this.newDescription = this.task.description
    },
    onChangeDescription() {
      this.$emit('change-description', this.newDescription)
      this.newDescription = null
      this.editing = false
    }
  }
}
</script>