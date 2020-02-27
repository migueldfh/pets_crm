<template>
  <div class="container-fluid">
    <h1>Vendedores</h1>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="has_error">
        <p>Tuvimos problemas al traer datos, intenta de nuevo mas tarde.</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="success_message">
        <p>Se agrego correctamente el dato.</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="success_message = false">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="row">
      <div class="col">
        <label for="">Selecciona sucursal:</label>
        <select class="" name="" v-model="subsidiary">
          <option value="" disabled selected>Seleccionar...</option>
          <option v-for="subsidiary in subsidiaries" :value="subsidiary.id">{{ subsidiary.name }}</option>
        </select>
      </div>
      <div class="col">
        <button type="button" class="btn btn-outline-primary" name="button" @click="addSeller()">Agregar</button>
      </div>
    </div>
    <div class="row mt-4">
      <div class="table-responsive">
        <table class="table table-borderless table-hover">
          <thead>
            <tr>
              <th scope="col">Cuenta</th>
              <th scope="col">Nombre</th>
              <th scope="col">Apellidos</th>
              <th scope="col">Email</th>
              <th scope="col">RFC</th>
              <th scope="col">Telefono</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="seller in sellers">
              <th scope="row"> {{ seller.account }} </th>
              <td>{{ seller.name }}</td>
              <td>{{ seller.first_name }} {{ seller.last_name }}</td>
              <td>{{ seller.office_email }}</td>
              <td>{{ seller.rfc }}</td>
              <td>{{ seller.cellphone }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div id="add_seller" class="modal fade modal-fixed-footer" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-center">
          <div class="modal-header">
            <h1 class="modal-title text-center">Agregar Vendedor</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="closeShowModal()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-4 text-left">
                <label for="">Nombre:</label>
                <input type="text" name="" value="" class="form-control" v-model="name">
              </div>
              <div class="form-group col-md-4 text-left">
                <label for="">Apellido Paterno:</label>
                <input type="text" name="" value="" class="form-control" v-model="first_name">
              </div>
              <div class="form-group col-md-4 text-left">
                <label for="">Apellido Materno:</label>
                <input type="text" name="" value="" class="form-control" v-model="last_name">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6 text-left">
                <label for="">Email Personal:</label>
                <input type="email" name="" value="" class="form-control" v-model="personal_email">
              </div>
              <div class="form-group col-md-6 text-left">
                <label for="">Email empresa:</label>
                <input type="email" name="" value="" class="form-control" v-model="office_email">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4 text-left">
                <label for="">Cuenta:</label>
                <input type="text" name="" value="" class="form-control" v-model="account">
              </div>
              <div class="form-group col-md-4 text-left">
                <label for="">RFC:</label>
                <input type="text" name="" value="" class="form-control" v-model="rfc">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6 text-left">
                <label for="">Dirección:</label>
                <textarea name="name" class="form-control" rows="8" cols="80" v-model="address"></textarea>
              </div>
              <div class="form-group col-md-6 text-left">
                <label for="">Celular:</label>
                <input type="number" class="form-control" name="" value="" v-model="cellphone">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click.prevent="closeShowModal()">Cancelar</button>
            <button type="button" class="btn btn-primary" @click.prevent="createSeller()">Crear</button>
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
      sellers: [],
      subsidiaries: [],
      subsidiary: null,
      name: null,
      first_name: null,
      last_name: null,
      rfc: null,
      address: null,
      account: null,
      personal_email: null,
      office_email: null,
      cellphone: null,
      shift: null,
      success_message: false,
      has_error: false,
    }
  },
  mounted() {
    this.getSubsidiaries()
  },
  watch: {
    subsidiary() {
      this.getSellers(this.subsidiary)
    },
  },
  methods: {
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
    getSellers(s) {
      this.$http({
        url: `subsidiary/${s}/sellers`,
        method: 'GET'
      }).then((res) => {
        this.sellers = res.data.sellers
      }, () => {
        this.has_error = true
      })
    },
    createSeller() {
      this.$http({
        url: `sellers`,
        method: 'POST',
        data: {
          subsidiary: this.subsidiary,
          name: this.name,
          shift: this.shift,
          first_name: this.first_name,
          last_name: this.last_name,
          address: this.address,
          rfc: this.rfc,
          account: this.account,
          personal_email: this.personal_email,
          office_email: this.office_email,
          cellphone: this.cellphone
        }
      }).then((res) => {
        this.seller = res.data.seller
        this.closeShowModal()
        this.getSellers(this.subsidiary)
        this.name = null
        this.shift = null
        this.first_name = null
        this.last_name = null
        this.address = null
        this.rfc = null
        this.account = null
        this.personal_email = null
        this.office_email = null
        this.cellphone = null
      }, () => {
        this.has_error = true
      })
    },
    addSeller() {
      $(document).ready(() => {
					$(`#add_seller`).modal('show');
			});
    },
    closeShowModal() {
  		$(document).ready(() => {
  				$(`#add_seller`).modal('hide');
  		});
		},
  }
}
</script>

<style lang="css" scoped>
</style>
