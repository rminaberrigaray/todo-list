import Vue from 'vue';
import axios from 'axios';
import ToDoList from './components/ToDoList.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Vue = Vue;

Vue.component('to-do-list', ToDoList);
Vue.component('login', Login);
Vue.component('register', Register);

const app = new Vue({
  el: '#app'
});
