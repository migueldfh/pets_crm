<template>
<div>
    <h3>Lista de Usuarios</h3>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="has_error">
        <p>Tuvimos problemas al traer datos, intenta de nuevo mas tarde.</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="row">
      <div class="col-2 justify-content-start">
        <button name="button" class="btn btn-outline-primary" @click="addUser()">Agregar usuario</button>
      </div>
    </div>
    <table class="table">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Email</th>
            <th scope="col">Dia de registro</th>
        </tr>
        <tr v-for="user in users" v-bind:key="user.id" style="margin-bottom: 5px;">
            <th scope="row">{{ user.id }}</th>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.created_at}}</td>
        </tr>
    </table>
    <div id="add_user" class="modal fade modal-fixed-footer" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-center">
          <div class="modal-header">
            <h1 class="modal-title text-center">Agregar Venta</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="closeShowModal()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="has_error && !success">
                <p v-if="error == 'registration_validation_error'">Error en la validación, revisa los campos.</p>
                <p v-else>Error en el sistema, intenta de nuevo mas tarde y envia mensaje al de sistemas.</p>
            </div>
            <form autocomplete="off" @submit.prevent="createUser" v-if="!success" method="post">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" class="form-control" v-model="name">
                </div>
                <div class="form-group">
                    <label for="account">Cuenta:</label>
                    <input type="text" id="account" class="form-control" v-model="account">
                </div>
                <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.email }">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email">
                    <span class="help-block" v-if="has_error && errors.email">{{ errors.email }}</span>
                </div>
                <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" class="form-control" v-model="password">
                    <span class="help-block" v-if="has_error && errors.password">{{ errors.password }}</span>
                </div>
                <div class="form-group">
                  <label for="">Sucursal:</label>
                  <select class="" name="" v-model="subsidiary">
                    <option disabled selected>Seleccionar...</option>
                    <option v-for="subsidiary in subsidiaries" :value="subsidiary.id">{{ subsidiary.name }}</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-default">Crear usuario</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
</template>
<script>
  export default {
    data() {
      return {
        has_error: false,
        success: false,
        users: null,
        name: null,
        account: null,
        email: null,
        password: null,
        subsidiary: null,
        subsidiaries: []
      }
    },
    mounted() {
      this.getUsers()
      this.getSubsidiaries()
    },
    methods: {
      getUsers() {
        this.$http({
          url: `users`,
          method: 'GET'
        })
            .then((res) => {
              this.users = res.data.users
            }, () => {
              this.has_error = true
            })
      },
      getSubsidiaries() {
        this.$http({
          url: `subsidiaries`,
          method: 'GET'
        }).then((res) => {
          this.subsidiaries = res.data.subsidiaries
        }, () => {
          this.has_error = true
        })
      },
      createUser() {
        var app = this
        this.$auth.register({
          data: {
            name: app.name,
            email: app.email,
            account: app.account,
            password: app.password,
            zone: app.subsidiary,
          },
          success: function () {
            app.success = true
            app.closeShowModal()
          },
          error: function (res) {
            console.log(res.response.data.errors)
            app.has_error = true
            app.error = res.response.data.error
            app.errors = res.response.data.errors || {}
          }
        })
      },
      addUser() {
        $(document).ready(() => {
  					$(`#add_user`).modal('show');
  			});
      },
      closeShowModal() {
    		$(document).ready(() => {
    				$(`#add_user`).modal('hide');
    		});
  		},
    }
  }
</script>
