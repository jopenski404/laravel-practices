<template>
<div>
     <b-modal ref="my-modal"  
              :title="'Update User #'+ userData.id " 
               hide-footer>
      <div class="d-block">
      <form ref="form" @submit.stop.prevent="handleSubmit">

        <b-form-group label-cols="4" label-cols-lg="4" label="Name" label-for="input-default">
          <b-form-input id="input-default" v-model="userData.name"></b-form-input>
        </b-form-group>
        <b-form-group label-cols="4" label-cols-lg="4" label="Email" label-for="input-default">
          <b-form-input id="input-default" type="email"  v-model="userData.email"></b-form-input>
        </b-form-group>
        <b-form-group label-cols="4" label-cols-lg="4" label="Age" label-for="input-default">
          <b-form-input id="input-default" type="number" v-model="userData.age"></b-form-input>
        </b-form-group>
        <b-form-group label-cols="4" label-cols-lg="4" label="Password" label-for="input-default">
          <b-form-input id="input-default" type="password" v-model="password" :disabled="!editPassword"></b-form-input>
          <b-form-checkbox v-model="editPassword">Change password</b-form-checkbox>
        </b-form-group>
        <b-form-group label-cols="4" label-cols-lg="4" label="Confirm Password" label-for="input-default" v-if="editPassword">
          <b-form-input id="input-default" type="password" v-model="c_password" :disabled="!editPassword"></b-form-input>
          <small id="passwordHelp" class="text-danger" v-if="password != c_password">
            Input must be the same with password above
          </small>
        </b-form-group>
        <b-form-group label="Role">
          <b-form-radio-group
            id="radio-group-1"
            v-model="userData.role"
            :options="rolesRadioOption"
            name="roles-radio">
            </b-form-radio-group>
        </b-form-group>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="resetModal" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" @click="handleOk" :disabled="editPassword && password != c_password">Save changes</button>
      </div>
  
    </b-modal>
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

        },
        props:['dataProp','userProp','showProp','rolesProp'],
        data() {
            return {
              userData:{
                id:null,
                name:null,
                email:null,
                role:null
              },
              password: 'password',
              editPassword :false,
              c_password : null,
              roles:null,
            };
        },
      methods: {
          resetModal() {
                this.$root.$emit('RESET_MODAL', true);
                this.userData ={
                    id:null,
                    name:null,
                    email:null,
                    role:null
                  }
                this.$refs['my-modal'].hide()
            },
            handleOk(bvModalEvt) {
              // Prevent modal from closing
              bvModalEvt.preventDefault()

              

              let data = {
                id : this.userData.id,
                name : this.userData.name,
                role : this.userData.role,
                age  : this.userData.age,
                password: this.password,
                c_password: this.c_password
              }
              if(!this.editPassword){
                delete data.password
                delete data.c_password
              }

              axios.post("api/update-details",data)
                .then(res => {
                  if(res.status == 200){
                    console.log('emit')
                    axios.defaults.headers.common = {'Authorization': `Bearer ${res.data.token}`}
                    this.$root.$emit('LOGGED_IN', res.data.user);
                  }else{
                    console.log('not')
                    this.passError = res.data.message
                    this.submitText = "Login"
                  }  

                });
         
            },
        },
        watch: {
          showProp: function (val) {
              if(val){
                this.$refs['my-modal'].show();
                this.userData = this.dataProp
                this.roles = this.rolesProp
              }
          },
         
        },
        computed:{
          rolesRadioOption(){
            let options = []
            if(this.roles){
              for( let x = 0 ; x <= this.roles.length-1; x++){
                options.push({ text:this.roles[x].name, value: this.roles[x].id })
                console.log("options: ",options)
              }
            }
          
            return options
          }
        }
    
    }
</script>
