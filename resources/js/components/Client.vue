<template>
  <div class="container-fluid">
    <h1>Clientes</h1>
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
        <button type="button" class="btn btn-outline-primary" name="button" @click="addClient()">Agregar</button>
      </div>
    </div>
    <div class="row mt-4">
      <div class="table-responsive">
        <table class="table table-borderless table-hover">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nombre</th>
              <th scope="col">Categoria</th>
              <th scope="col">Tipo de Persona</th>
              <th scope="col">RFC</th>
              <th scope="col">Dirección</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="client in clients">
              <th scope="row"> {{ client.id }} </th>
              <td>{{ client.name }}</td>
              <td>{{ client.category }}</td>
              <td v-if="client.person_type == 0">Fisica</td>
              <td v-else>Moral</td>
              <td>{{ client.rfc }}</td>
              <td>{{ client.street }} #{{ client.ext_number }}, {{ client.neighborhood }}, {{ client.zipcode }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div id="add_client" class="modal fade modal-fixed-footer" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-center">
          <div class="modal-header">
            <h1 class="modal-title text-center">Agregar Cliente</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="closeShowModal()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-4 text-left">
                <label for="type">Tipo de Cliente:</label>
                <select class="form-control custom-select" name="" v-model="type">
                  <option value="" disabled selected>Seleccionar...</option>
                  <option value="Veterinaria Clientes">Veterinaria Clientes</option>
                  <option value="Particular">Particular</option>
                  <option value="Prospecto">Prospecto</option>
                  <option value="Prevision">Prevision</option>
                </select>
              </div>
              <div class="form-group col-md-4 text-left">
                <label for="person_type">Tipo persona:</label>
                <select class="form-control custom-select" name="" v-model="person_type">
                  <option value="" disabled selected>Seleccionar...</option>
                  <option value="0">Fisica con actividad empresarial</option>
                  <option value="1">Moral</option>
                </select>
              </div>
              <div class="form-group col-md-4 text-left">
                <label for="person_type">Moneda:</label>
                <select class="form-control custom-select" name="" v-model="currency">
                  <option value="" disabled selected>Seleccionar...</option>
                  <option value="MXN">MXN</option>
                  <option value="USD">USD</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3 text-left">
                <label for="">Categoría:</label>
                <input type="text" name="" value="" class="form-control" v-model="category">
              </div>
              <div class="form-group col-md-8 text-left">
                <label for="name">Nombre:</label>
                <input type="text" v-model="name" class="form-control" name="" value="">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4 text-left">
                <label for="">RFC:</label>
                <input type="text" name="" value="" class="form-control" v-model="rfc">
              </div>
              <div class="form-group col-md-8 text-left">
                <label for="">Vendedor:</label>
                <Dropdown :options="sellers" v-on:selected="validateSelection" placeholder="Buscar..." ></Dropdown>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6 text-left">
                <label for="street">Calle:</label>
                <input type="text" name="" value="" class="form-control" v-model="street" id="street">
              </div>
              <div class="form-group col-md-3 text-left">
                <label for="int_number">No. Int.:</label>
                <input type="text" name="" value="" class="form-control" id="int_number">
              </div>
              <div class="form-group col-md-3 text-left">
                <label for="ext_number">No. Ext.:</label>
                <input type="text" name="" value="" class="form-control" v-model="ext_number" id="ext_number">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4 text-left">
                <label for="neighborhood">Colonia:</label>
                <input type="text" id="neighborhood" name="" class="form-control" value="" v-model="neighborhood">
              </div>
              <div class="form-group col-md-4 text-left">
                <label for="refere">Referencia:</label>
                <input type="text" name="" class="form-control" value="" id="refere">
              </div>
              <div class="form-group col-md-4 text-left">
                <label for="cp">Código Postal:</label>
                <input type="text" name="" class="form-control" value="" v-model="zipcode" id="cp">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4 text-left">
                <label for="country">País:</label>
                <select class="" name="" class="form-control custom-select" v-model="country">
                  <option value="" v-for="country in countries" :value="country.id">{{ country.name }}</option>
                </select>
              </div>
              <div class="form-group col-md-4 text-left">
                <label for="state">Estado:</label>
                <select class="" name="" class="form-control custom-select" v-model="state">
                  <option value="" v-for="state in states" :value="state.id">{{ state.name }}</option>
                </select>
              </div>
              <div class="form-group col-md-4 text-left">
                <label for="city">Ciudad:</label>
                <select class="" name="" class="form-control custom-select" v-model="city">
                  <option value="" v-for="city in cities" :value="city.id">{{ city.name }}</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2 text-left">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                  <label class="form-check-label" for="defaultCheck1">
                    Crédito
                  </label>
                </div>
              </div>
              <div class="form-group col-md-3 text-left">
                <label for="days">Días de crédito:</label>
                <input type="number" name="" value="" v-model="max_days_credit">
              </div>
              <div class="form-group col-md-2 text-left">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                  <label class="form-check-label" for="defaultCheck1">
                    Limite de Crédito
                  </label>
                </div>
              </div>
              <div class="form-group col-md-2 text-left">
                <label for="days">Máximo:</label>
                <input type="text" name="" value="" v-model="max_credit_limit">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click.prevent="closeShowModal()">Cancelar</button>
            <button type="button" class="btn btn-primary" @click.prevent="createClient()">Crear</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from 'vue-simple-search-dropdown'

export default {
  components: {
    Dropdown,
  },
  data() {
    return {
      clients: [],
      subsidiaries: [],
      sellers: [],
      countries: [],
      states: [],
      cities: [],
      seller: {},
      subsidiary: null,
      folio: null,
      subsidiary: null,
      type: null,
      person_type: null,
      category: null,
      name: null,
      rfc: null,
      street: null,
      ext_number: null,
      neighborhood: null,
      city: null,
      state: null,
      zipcode: null,
      country: null,
      currency: null,
      owner: null,
      vet: null,
      admon: null,
      discount: null,
      credit: null,
      max_days_credit: null,
      credit_limit: null,
      max_credit_limit: null,
      success_message: false,
      has_error: false,
    }
  },
  mounted() {
    this.getSubsidiaries()
    this.getCountries()
  },
  watch: {
    subsidiary() {
      this.getClients(this.subsidiary)
      this.getSellers(this.subsidiary)
    },
    country() {
      this.getStates(this.country)
    },
    state() {
      this.getCities(this.state)
    },
  },
  methods: {
    getCountries() {
      this.$http({
        url: `countries`,
        method: 'GET'
      }).then((res) => {
        this.countries = res.data.countries
      }, () => {
        this.has_error = true
      })
    },
    getStates(st) {
      this.$http({
        url: `countries/${st}/states`,
        method: 'GET'
      }).then((res) => {
        this.states = res.data.states
      }, () => {
        this.has_error = true
      })
    },
    getCities(ct) {
      this.$http({
        url: `states/${ct}/cities`,
        method: 'GET'
      }).then((res) => {
        this.cities = res.data.cities
      }, () => {
        this.has_error = true
      })
    },
    validateSelection (selection) {
      let u = this
      u.seller = selection
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
    getClients(c) {
      this.$http({
        url: `subsidiary/${c}/clients`,
        method: 'GET'
      }).then((res) => {
        this.clients = res.data.clients
      }, () => {
        this.has_error = true
      })
    },
    createClient() {
      this.$http({
        url: `clients`,
        method: 'POST',
        data: {
          seller_id: this.seller.id,
          subsidiary_id: this.subsidiary,
          type: this.type,
          person_type: this.person_type,
          category: this.category,
          name: this.name,
          rfc: this.rfc,
          street: this.street,
          ext_number: this.ext_number,
          neighborhood: this.neighborhood,
          city: this.city,
          state: this.state,
          zipcode: this.zipcode,
          country: this.country,
          currency: this.currency,
          photo: null,
          owner: this.owner,
          vet: this.vet,
          admon: this.admon,
          discount: this.discount,
          credit: this.credit,
          max_days_credit: this.max_days_credit,
          credit_limit: this.credit_limit,
          max_credit_limit: this.max_credit_limit,
          account_holder: this.account_holder,
          account_number: this.account_number,
          bank_name: this.bank_name,
        }
      }).then((res) => {
        this.client = res.data.client
        this.old_client = true
        this.created_client = true
        this.getClients(this.subsidiary)
        this.closeShowModal()
      }, () => {
        this.has_error = true
      })
    },
    addClient() {
      $(document).ready(() => {
					$(`#add_client`).modal('show');
			});
    },
    closeShowModal() {
  		$(document).ready(() => {
  				$(`#add_client`).modal('hide');
  		});
		},
  }
}
</script>

<style lang="css" scoped>
</style>
