<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" > <h3>Please login</h3></div>

                    <div class="card-body">
                       <form @submit="login">
                      
                        <input type="email" id="username" class="form-control text-box" v-model="email" placeholder="Email" required/>
                        <br>
                        <span class="error-msg" >{{this.emailError}}</span>
                        <input type="password" id="password" class="form-control text-box" v-model="password" placeholder="Password" required/>
                        <br>
                        <span class="error-msg text-danger" v-if="this.passError" >{{this.passError}}</span>
                        <br>
                        <button class="btn custom-btn" type="submit" :disabled="submitText != 'Login'">{{submitText}}</button>
                        <br>

                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';

    axios.defaults.withCredentials = true;
    axios.defaults.baseURL = "http://localhost:8000";

    export default {  
        name: 'LoginForm',
        mounted() {
            console.log('Login component mounted.')
        },
        data() {
            return {
              email:    'test@gmail.com',
              password: '12345',
              emailError:null,
              passError:false   ,
              submitText:'Login'
            };
        },
      methods: {
        login(e) {
            e.preventDefault();
            this.submitText = "Logging in please wait."
           
            axios.post("api/login", {
                email: this.email,
                password: this.password
            })
            .then(res => {
               if(res.data.success){
                this.$root.$emit('LOGGED_IN', res.data);
               }else{
                this.passError = res.data.message
                console.log(res.data.message)
                this.submitText = "Login"
               }
               
           
        });
        }
    }
    }
</script>
