<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <table class="table table-bordered">
                <thead>
                    <tr>           
                    <th v-for="col in tableHeaders" :key="col.name">{{col.name}}</th>
                    </tr>
                </thead>
                <tbody>
                   <tr v-for="row in users" :key="row.id">
                        <td >{{row.id}}</td>
                        <td >{{row.name}}</td>
                        <td >{{row.email}}</td>
                        <td >{{row.role_desc}}</td>
                        <td>
                            <button class="btn border" @click="updateUser(row.id)" :disabled="row.role != 1 && user.id != row.id">Update</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn bg-danger text-light" @click="deleteUser(row.id)" >Delete</button>
                        </td>
                   </tr>
                </tbody>
                </table>

            </div>
        </div>
    </div>
</template>
<script>

    import axios from 'axios';

    axios.defaults.withCredentials = true;
    axios.defaults.baseURL = "http://localhost:8000";

    export default {  
        name: 'MainPage',
        mounted() {
            console.log('Mainpage component mounted.')
            this.getAllUsers();
        },
        props:['user'],
        data() {
            return {
                email:    'test@gmail.com',
                password: '12345',
                emailError:null,
                passError:null,
                tableHeaders:[
                    {name:'ID'},
                    {name:'Name'},
                    {name:'Email'},
                    {name:'Role'},
                    {name:'Action'}
                    ],
                users: null,
                permissions: {
                    create:false,
                    update:false,
                    delete:false,
                }
            };
        },
      methods: {
          getAllUsers(){
          
                axios.post("api/get-all-users", {
                        email: this.email,
                        password: this.password
                    })
                    .then(res => {
                        console.log(res.data)
                     this.users = res.data.data
                    });

          }
        }
    
    }
</script>