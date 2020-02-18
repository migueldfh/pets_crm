<template>
  <div class="container-fluid">
    <h1 class="text-left">Ventas</h1>
    <div class="row">
      <div class="col">
        <label for="">Sucursal:</label>
        <select class="" name="" v-model="subsidiary">
          <option disabled selected>Seleccionar...</option>
          <option v-for="subsidiary in subsidiaries" :value="subsidiary.id">{{ subsidiary.name }}</option>
        </select>
      </div>
      <div class="col">
        <label for="">Buscar:</label>
        <input type="text" name="" value="">
      </div>
    </div>
    <div v-if="subSelected">
      <div class="row">
        <div class="col-2 justify-content-start">
          <button name="button" class="btn btn-outline-primary" @click="addSale()">Agregar venta</button>
        </div>
      </div>
      <div class="row mt-4">
        <hr>
        <div class="table-responsive">
          <table class="table table-borderless table-hover">
            <thead>
              <tr>
                <th scope="col">Folio</th>
                <th scope="col">Cliente</th>
                <th scope="col">Zona</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="sale in sales">
                <th scope="row"> {{ sale.folio }} </th>
                <td>Venta 1</td>
                <td>Zona 3 (Monterrey)</td>
                <td><p class="text-success">Completado</p></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div id="add_sale" class="modal fade modal-fixed-footer" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-center">
          <div class="modal-header">
            <h1 class="modal-title text-center">Agregar Venta</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="closeShowModal()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-row justify-content-between">
                <div class="form-group col-md-2 text-left">
                  <label for="folio">Folio:</label>
                  <input type="text" class="form-control" v-model="folio" id="folio">
                </div>
                <div class="form-group col-md-4 text-left">
                  <label for="fecha">Fecha:</label>
                  <input type="text" class="form-control" v-model="parseDate" id="fecha">
                </div>
                <div class="form-group col-md-4 text-left">
                  <label for="venc">Vencimiento:</label>
                  <input type="text" class="form-control" id="venc">
                </div>
              </div>
              <hr>
              <div v-if="old_client">
                <div class="form-row">
                  <div class="form-group col-md-6 text-left" v-if="created_client">
                    <label for="client">Cliente:</label>
                    <input type="text" name="" value="" v-model="client.name" readonly>
                  </div>
                  <div class="form-group col-md-6 text-left" v-else>
                    <label for="inputEmail4">Cliente <a href="#" data-toggle="tooltip" title="Agregar cliente" @click.prevent="old_client = false"><i class="fas fa-plus-circle"></i></a></label>
                    <Dropdown :options="clients" placeholder="Buscar..."></Dropdown>
                  </div>
                </div>
              </div>
              <div v-else>
                <div class="form-row">
                  <div class="form-group col-md-4 text-left">
                    <label for="type">Tipo de Cliente:</label>
                    <select class="form-control custom-select" name="" v-model="type">
                      <option value="" disabled selected>Seleccionar...</option>
                      <option value="Veterinaria Clientes">Veterinaria Clientes</option>
                      <option value="Veterinaria Proveedor">Veterinaria Proveedor</option>
                      <option value="Prospecto">Prospecto</option>
                    </select>
                  </div>
                  <div class="form-group col-md-4 text-left">
                    <label for="person_type">Tipo persona:</label>
                    <select class="form-control custom-select" name="" v-model="person_type">
                      <option value="" disabled selected>Seleccionar...</option>
                      <option value="">Fisica con actividad empresarial</option>
                      <option value="">Moral</option>
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
                    <Dropdown :options="sellers" placeholder="Buscar..."></Dropdown>
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
                <div class="form-row">
                  <div class="form-group col-md-4 offset-md-4">
                    <button type="button" class="btn btn-outline-primary">Crear Cliente</button>
                  </div>
                </div>
              </div>
              <hr>
              <div class="form-row">

              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click.prevent="closeShowModal()">Cancelar</button>
            <button type="button" class="btn btn-primary" @click.prevent="addSale()">Crear</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from 'vue-simple-search-dropdown'
import moment from 'moment-timezone'
import 'moment/locale/es'

moment.tz.setDefault('America/Mexico_City')
moment.locale('es');

export default {
  components: {
    Dropdown,
  },
  data() {
    return {
      loading: true,
      subSelected: false,
      old_client: true,
      created_client: false,
      subsidiaries: [],
      sales: [],
      clients: [],
      client: {},
      sellers: [],
      countries: [],
      states: [],
      cities: [],
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
      date_sale: new Date(),
    }
  },
  mounted() {
    this.getSubsidiaries()
    this.getCountries()
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  },
  watch: {
    subsidiary() {
      this.getDataSubsidiary(this.subsidiary)
      this.getSellers(this.subsidiary)
    },
    country() {
      this.getStates(this.country)
    },
    state() {
      this.getCities(this.state)
    },
  },
  computed: {
    parseDate() {
      return moment().tz('America/Mexico_City').format("MM-DD-YYYY")
    }
  },
  methods: {
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
    getDataSubsidiary(d) {
      this.$http({
        url: `subsidiary/${d}/sales`,
        method: 'GET'
      }).then((res) => {
        this.sales = res.data.sales
        this.subSelected = true
        this.getClients(d)
      }, () => {
        this.has_error = true
      })
    },
    addClient() {
      this.$http({
        url: `clients`,
        method: 'POST',
        data: {
          subsidiary: this.new_subsidiary
        }
      }).then((res) => {
        this.client = res.data.client
        this.old_client = true
        this.created_client = true
      }, () => {
        this.has_error = true
      })
    },
    addSale() {
      $(document).ready(() => {
					$(`#add_sale`).modal('show');
			});
    },
    closeShowModal() {
				$(document).ready(() => {
						$(`#add_sale`).modal('hide');
				});
			},
  }
}
</script>

<style lang="css" scoped>
</style>
