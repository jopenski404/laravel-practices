<template>
  <div id="app">
    <img alt="Vue logo" src="./assets/logo.png">
    <LoginForm v-if="!user"></LoginForm>
    <MainPage v-if="user || user != null " :user="user"></MainPage>
  </div>
</template>

<script>
import LoginForm from './components/LoginComponent.vue'
import MainPage from './components/MainPage.vue'

export default {
  name: 'Client',
  components: {
    LoginForm,
    MainPage
  },
  mounted() {
    this.$root.$on('LOGGED_IN', data => {
      this.user = data.user
      this.token = data.token
    });
  }, 
  data() {
    return {
      user:null,
      token:null,
            };
        },
    }
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
