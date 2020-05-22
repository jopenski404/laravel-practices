<template>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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
        name: 'UserDialog',
        mounted() {
            console.log('Mainpage component mounted.')
            this.getAllUsers();
        },
        props:['data'],
        data() {
            return {
              userData:null
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

          },
          updateUser(id){
              let index = this.users.map(function(x) {return x.id; }).indexOf(id);
              this.selectedUser = this.users[index];
              this.updateVisibility = true

          }
        },
     computed:{
         
     }
    
    }
</script>
