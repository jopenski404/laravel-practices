import Vue from 'vue'
import './plugins/bootstrap-vue'
import App from './App.vue'
import axios from 'axios'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

axios.defaults.withCredentials = true

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
