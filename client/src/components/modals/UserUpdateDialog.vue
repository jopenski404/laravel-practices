<template>
<div>
     <b-modal ref="my-modal"  
              :title="'Update User #'+ userData.id " 
              @show="resetModal"
              @hidden="resetModal"
              @ok="handleOk">
      <div class="d-block">
      <form ref="form" @submit.stop.prevent="handleSubmit">

        <b-form-group label-cols="4" label-cols-lg="2" label="Name" label-for="input-default">
          <b-form-input id="input-default" v-model="userData.name"></b-form-input>
        </b-form-group>
        <b-form-group label-cols="4" label-cols-lg="2" label="Email" label-for="input-default">
          <b-form-input id="input-default" v-model="userData.email">></b-form-input>
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
              // Trigger submit handler
              this.handleSubmit()
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
