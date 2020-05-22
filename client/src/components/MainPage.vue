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
                            <button class="btn border" @click="updateUser(row.id)" :disabled=" user.id != row.id || !!updatePermission">Update</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn bg-danger text-light" @click="deleteUser(row.id)" :disabled="!deletePermission">Delete</button>
                        </td>
                   </tr>
                </tbody>
                </table>

                <b-modal ref="my-modal" hide-footer title="Using Component Methods">
                    <div class="d-block text-center">
                        <h3>Hello From My Modal!</h3>
                    </div>
                    <b-button class="mt-3" variant="outline-danger" block>Close Me</b-button>
                    <b-button class="mt-2" variant="outline-warning" block>Toggle Me</b-button>
                </b-modal>
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
        components: {
            
              
            },
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
                selectedUser: null,
                updateVisibility:false
            };
        },
      methods: {
          getAllUsers(){
          
                axios.post("api/get-all-users")
                    .then(res => {
                        console.log(res.data)
                     this.users = res.data.data
                    });

          },
          updateUser(id){
              let index = this.users.map(function(x) {return x.id; }).indexOf(id);
              this.selectedUser = this.users[index];
              this.$refs['my-modal'].show();

          }
        },
     computed:{
         deletePermission: function(){
             return this.user.role == 1 || this.user.role == "1"
         },
         updatePermission: function(){
             let permission = false;
             if(this.user.role == 1 ){
                 permission == true
             }

             return permission
         }
     }
    
    }
</script>