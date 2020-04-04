<template>
  <div class="container-fluid">
    <h1>Ventas</h1>
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
                <th scope="col">Sucursal</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="sale in sales">
                <th scope="row"> {{ sale.folio }} </th>
                <!-- MTY - A, Tijuana - TJ, Saltillo - TS -->
                <td>{{ sale.client.name }}</td>
                <td>{{ sale.subsidiary.name }}</td>
                <td>${{ formatPrice(sale.total) }}</td>
                <td><p class="">Abierto</p></td>
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
              <div v-if="old_seller">
                <div class="form-row">
                  <div class="form-group col-md-6 text-left" v-if="created_seller">
                    <label for="client">Vendedor:</label>
                    <input type="text" name="" value="" v-model="seller.name" readonly>
                  </div>
                  <div class="form-group col-md-6 text-left" v-else>
                    <label for="inputEmail4">Vendedor <a href="#" data-toggle="tooltip" title="Agregar vendedor" @click.prevent="old_seller = false"><i class="fas fa-plus-circle"></i></a></label>
                    <Dropdown :options="sellers" v-on:selected="validateSeller" placeholder="Buscar..."></Dropdown>
                  </div>
                </div>
              </div>
              <div v-else>
                <div class="form-row">
                  <div class="form-group col-md-4 text-left">
                    <label for="">Nombre:</label>
                    <input type="text" name="" value="" class="form-control" v-model="seller_name">
                  </div>
                  <div class="form-group col-md-4 text-left">
                    <label for="">Apellido Paterno:</label>
                    <input type="text" name="" value="" class="form-control" v-model="first_name_seller">
                  </div>
                  <div class="form-group col-md-4 text-left">
                    <label for="">Apellido Materno:</label>
                    <input type="text" name="" value="" class="form-control" v-model="last_name_seller">
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
                    <input type="text" name="" value="" class="form-control" v-model="account_seller">
                  </div>
                  <div class="form-group col-md-4 text-left">
                    <label for="">RFC:</label>
                    <input type="text" name="" value="" class="form-control" v-model="rfc_seller">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6 text-left">
                    <label for="">Dirección:</label>
                    <textarea name="name" class="form-control" rows="8" cols="80" v-model="address_seller"></textarea>
                  </div>
                  <div class="form-group col-md-6 text-left">
                    <label for="">Celular:</label>
                    <input type="number" class="form-control" name="" value="" v-model="cellphone_seller">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4 md-offset-3">
                    <button type="button" class="btn btn-outline-primary" @click.prevent="addSeller()">Crear Vendedor</button>
                  </div>
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
                    <Dropdown :options="clients" v-on:selected="validateClient" placeholder="Buscar..."></Dropdown>
                  </div>
                </div>
              </div>
              <div v-else>
                <div class="form-row">
                  <div class="form-group col-md-4 text-left">
                    <label for="type">Tipo de Cliente:</label>
                    <select class="form-control custom-select" name="" v-model="type">
                      <option value="" disabled selected>Seleccionar...</option>
                      <option value="1">Particular</option>
                      <option value="2">Veterinaria Clientes</option>
                      <option value="3">Prospecto</option>
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
                <div class="form-row">
                  <div class="form-group col-md-4 offset-md-4">
                    <button type="button" class="btn btn-outline-primary" @click.prevent="addClient()">Crear Cliente</button>
                  </div>
                </div>
              </div>
              <hr>
              <div v-if="old_pet">
                <div class="form-row">
                  <div class="form-group col-md-6 text-left" v-if="created_pet">
                    <label for="client">Mascota:</label>
                    <input type="text" name="" value="" v-model="pet.name" readonly>
                  </div>
                  <div class="form-group col-md-6 text-left" v-else>
                    <label for="inputEmail4">Mascota <a href="#" data-toggle="tooltip" title="Agregar mascota" @click.prevent="old_pet = false"><i class="fas fa-plus-circle"></i></a></label>
                    <Dropdown :options="pets" v-on:selected="validatePet" placeholder="Buscar..."></Dropdown>
                  </div>
                </div>
              </div>
              <div v-else>
                <div class="form-row">
                  <div class="form-group col-md-4 text-left">
                    <label for="">Especie:</label>
                    <input type="text" name="" value="" class="form-control" v-model="kind">
                  </div>
                  <div class="form-group col-md-4 text-left">
                    <label for="">Género:</label>
                    <select class="" v-model="genus" class="form-control custom-select" name="">
                      <option value="" disabled selected>Seleccionar...</option>
                      <option value="H">Hembra</option>
                      <option value="M">Macho</option>
                    </select>
                  </div>
                  <div class="form-group col-md-4 text-left">
                    <label for="">Peso:</label>
                    <select class="" name="" v-model="weight">
                      <option value="" disabled selected>Seleccionar...</option>
                      <option value="0-5kg">0-5kg</option>
                      <option value="6-10kg">6-10kg</option>
                      <option value="11-15kg">11-15kg</option>
                      <option value="16-20kg">16-20kg</option>
                      <option value="21-25kg">21-25kg</option>
                      <option value="26-30kg">26-30kg</option>
                      <option value="31-35kg">31-35kg</option>
                      <option value="36-40kg">36-40kg</option>
                      <option value="41-45kg">41-45kg</option>
                      <option value="46-50kg">46-50kg</option>
                      <option value="51-55kg">51-55kg</option>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6 text-left">
                    <label for="">Nombre:</label>
                    <input type="text" name="" value="" class="form-control" v-model="pet_name">
                  </div>
                  <div class="form-group col-md-6 text-left">
                    <label for="">Familia:</label>
                    <input type="text" name="" value="" class="form-control" v-model="owner">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6 text-left">
                    <label for="">Nacimiento:</label>
                    <input type="date" name="" value="" class="form-control" v-model="birth">
                  </div>
                  <div class="form-group col-md-6 text-left">
                    <label for="">Muerte:</label>
                    <input type="date" name="" value="" class="form-control" v-model="death">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <button type="button" class="btn btn-outline-primary" @click.prevent="addPet()">Crear Mascota</button>
                  </div>
                </div>
              </div>
              <hr>
              <div class="services">
                <div class="form-row">
                  <div class="form-group col-md-6 text-left">
                    <label for="inputEmail4">Servicios: </label>
                    <Dropdown :options="services" :maxItem="10" v-on:selected="validateServices" placeholder="Buscar..."></Dropdown>
                  </div>
                </div>
                <div class="form-row">
                  <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                      <thead>
                        <tr>
                          <th scope="col">Código</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Moneda</th>
                          <th scope="col">Cantidad</th>
                          <th scope="col">Precio Unitario</th>
                          <th scope="col">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="service in uniqueServices">
                          <th scope="row"> {{ service.code }} </th>
                          <td>{{ service.name }}</td>
                          <td>{{ service.currency }}</td>
<<<<<<< HEAD
                          <td><a href="#" @click.prevent="service.quantity -= 1"><i class="fas fa-minus-circle"></i></a>&nbsp;<input type="text" name="" class="inputQ" value="" v-model="service.quantity">&nbsp;<a href="#" @click.prevent="service.quantity += 1"><i class="fas fa-plus-circle"></i></a></td>
                          <td><input type="text" v-model="service.selling_price" class="inputQ" name="" value="" disabled></td>
=======
                          <td><a href="#" @click.prevent="service.quantity -= 1"><i class="fas fa-minus-circle"></i></a>&nbsp;<input type="text" name="" class="inputQ" value="" v-model="service.quantity" disabled>&nbsp;<a href="#" @click.prevent="service.quantity += 1"><i class="fas fa-plus-circle"></i></a></td>
                          <td><input type="text" v-model="service.selling_price" class="inputQ" name="" value=""></td>
>>>>>>> 6c341913844a028ce616bf2cfe6435e04346daa9
                          <td> ${{ service.selling_price * service.quantity }} </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="products">
                <div class="form-row">
                  <div class="form-group col-md-6 text-left">
                    <label for="inputEmail4">Productos: </label>
                    <Dropdown :options="inventories" :maxItem="10" v-on:selected="validateInventory" placeholder="Buscar..."></Dropdown>
                  </div>
                </div>
                <div class="form-row">
                  <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                      <thead>
                        <tr>
                          <th scope="col">Código</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Moneda</th>
                          <th scope="col">Cantidad</th>
                          <th scope="col">Precio Unitario</th>
                          <th scope="col">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="product in uniqueProducts">
                          <th scope="row"> {{ product.code }} </th>
                          <td>{{ product.name }}</td>
                          <td>{{ product.currency }}</td>
<<<<<<< HEAD
                          <td><a href="#" @click.prevent="product.quantity -= 1"><i class="fas fa-minus-circle"></i></a>&nbsp;<input type="text" name="" value="" class="inputQ" v-model="product.quantity">&nbsp;<a href="#" @click.prevent="product.quantity += 1"><i class="fas fa-plus-circle"></i></a></td>
                          <td><input type="text" class="inputQ" v-model="product.selling_price" name="" value="" disabled></td>
=======
                          <td><a href="#" @click.prevent="product.quantity -= 1"><i class="fas fa-minus-circle"></i></a>&nbsp;<input type="text" name="" value="" class="inputQ" v-model="product.quantity" disabled>&nbsp;<a href="#" @click.prevent="product.quantity += 1"><i class="fas fa-plus-circle"></i></a></td>
                          <td><input type="text" class="inputQ" v-model="product.selling_price" name="" value=""></td>
>>>>>>> 6c341913844a028ce616bf2cfe6435e04346daa9
                          <td> ${{ product.selling_price * product.quantity }} </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="accesories">
                <div class="form-row">
                  <div class="form-group col-md-6 text-left">
                    <label for="inputEmail4">Accesorios: </label>
                    <Dropdown :options="accesories" :maxItem="10" v-on:selected="validateAccesories" placeholder="Buscar..."></Dropdown>
                  </div>
                  <div class="form-group col-md-4 text-left pt-4">
                    <button type="button" @click.prevent="addAccesoriesPack()" name="button" class="btn btn-info">Agregar accesorios</button>
                  </div>
                </div>
                <div class="form-row">
                  <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                      <thead>
                        <tr>
                          <th scope="col">Código</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Moneda</th>
                          <th scope="col">Cantidad</th>
                          <th scope="col">Precio Unitario</th>
                          <th scope="col">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="accesory in uniqueAccesories">
                          <th scope="row"> {{ accesory.code }} </th>
                          <td>{{ accesory.name }}</td>
                          <td>{{ accesory.currency }}</td>
<<<<<<< HEAD
                          <td><a href="#" @click.prevent="accesory.quantity -= 1"><i class="fas fa-minus-circle"></i></a>&nbsp;<input type="text" name="" class="inputQ" value="" v-model="accesory.quantity">&nbsp;<a href="#" @click.prevent="accesory.quantity += 1"><i class="fas fa-plus-circle"></i></a></td>
                          <td><input type="text" v-model="accesory.selling_price" class="inputQ" name="" value="" disabled></td>
=======
                          <td><a href="#" @click.prevent="accesory.quantity -= 1"><i class="fas fa-minus-circle"></i></a>&nbsp;<input type="text" name="" class="inputQ" value="" v-model="accesory.quantity" disabled>&nbsp;<a href="#" @click.prevent="accesory.quantity += 1"><i class="fas fa-plus-circle"></i></a></td>
                          <td><input type="text" v-model="accesory.selling_price" class="inputQ" name="" value=""></td>
>>>>>>> 6c341913844a028ce616bf2cfe6435e04346daa9
                          <td> ${{ accesory.selling_price * accesory.quantity }} </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="form row">
                <hr>
                <div class="colt">
                  <h3>Cantidad total: {{ productsQuantity }}</h3>
                </div>
                <div class="col">
                  <h3>Total: ${{ formatPrice(productsTotal) }}</h3>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" @click.prevent="closeShowModal()">Cancelar</button>
            <button type="button" class="btn btn-primary" @click.prevent="addFinalSale()">Crear</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {VMoney} from 'v-money'
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
      old_seller: true,
      created_seller: false,
      old_pet: true,
      created_pet: false,
      has_error: false,
      success_message: false,
      subsidiaries: [],
      sales: [],
      clients: [],
      sellers: [],
      countries: [],
      states: [],
      cities: [],
      pets: [],
      inventories: [],
      products: [],
      newProducts: [],
      services: [],
      servicios: [],
      accesories: [],
      accesorios: [],
      accesoriesPack: [],
      price: {},
      client: {},
      seller: {},
      pet: {},
      folio: 'TJ-001',
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
      seller_name: null,
      shift: null,
      first_name_seller: null,
      last_name_seller: null,
      rfc_seller: null,
      address_seller: null,
      account_seller: null,
      personal_email: null,
      office_email: null,
      cellphone_seller: null,
      pet_name: null,
      kind: null,
      genus: null,
      weight: null,
      owner: null,
      birth: null,
      death: null,
      money: {
        decimal: '.',
        thousands: ',',
        prefix: '$',
        suffix: '',
        precision: 0,
        masked: false
      },
    }
  },
  directives: {money: VMoney},
  mounted() {
    this.getSubsidiaries()
    this.getCountries()
    this.getServices()
    this.getAccesories()
    this.getAccesoryPack()
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  },
  watch: {
    subsidiary() {
      this.getDataSubsidiary(this.subsidiary)
      this.getSellers(this.subsidiary)
      this.getInventorySubsidiary(this.subsidiary)
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
    },
    uniqueProducts() {
      return this.products.reduce((seed, current) => {
        return Object.assign(seed, {
          [current.code]: current
        });
      }, {});
    },
    uniqueServices() {
      return this.servicios.reduce((seed, current) => {
        return Object.assign(seed, {
          [current.code]: current
        });
      }, {});
    },
    uniqueAccesories() {
      return this.accesorios.reduce((seed, current) => {
        return Object.assign(seed, {
          [current.code]: current
        });
      }, {});
    },
    productsTotal() {
      this.newProducts = {...this.uniqueProducts, ...this.uniqueServices, ...this.uniqueAccesories}
      let total = [];

      Object.entries(this.newProducts).forEach(([key, val]) => {
          if (val.selling_price != undefined && val.selling_price != 0) {
              total.push(val.selling_price * val.quantity) // the value of the current key.
          }
      });

      return total.reduce(function(total, num){ return total + num }, 0);
    },
    productsQuantity() {
      let total = [];

      Object.entries(this.newProducts).forEach(([key, val]) => {
          if (val.quantity != undefined && val.quantity != 0) {
              total.push(val.quantity) // the value of the current key.
          }
      });

      return total.reduce(function(total, num){ return total + num }, 0);
    },
  },
  methods: {
    formatPrice (value) {
        let val = (value/1).toFixed(2)
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },
    parseValue(string) {
        var pattern = /\$|\,/ig;
        return parseInt(string.replace(pattern, ''))
    },
    validateSelection (selection) {
      let u = this
      u.seller = selection
    },
    validateSeller (selection) {
      let u = this
      u.seller = selection
    },
    validatePet (selection) {
      let u = this
      u.pet = selection
    },
    validateClient (selection) {
      let u = this
      u.client = selection
    },
    validateInventory (selection) {
      let u = this
      let product = selection
      u.products.push(product)
    },
    validateServices (selection) {
      let u = this
      let service = selection
      u.servicios.push(service)

      this.getPrices(service.code)
    },
    validateAccesories (selection) {
      let u = this
      let accesory = selection
      u.accesorios.push(accesory)
    },
    getPrices(s) {
      this.$http({
        url: `services/${s}/prices`,
        method: 'GET'
      }).then((res) => {
        this.price = res.data.price
      }, () => {
        this.has_error = true
      })
    },
    getServices() {
      this.$http({
        url: `services`,
        method: 'GET'
      }).then((res) => {
        this.services = res.data.services
      }, () => {
        this.has_error = true
      })
    },
    getAccesories() {
      this.$http({
        url: `accesories`,
        method: 'GET'
      }).then((res) => {
        this.accesories = res.data.accesories
      }, () => {
        this.has_error = true
      })
    },
    getAccesoryPack() {
      this.$http({
        url: `accesories/pack`,
        method: 'GET'
      }).then((res) => {
        this.accesoriesPack = res.data.accesoriesPack
      }, () => {
        this.has_error = true
      })
    },
    addAccesoriesPack() {
      this.accesorios = [...this.accesoriesPack]
    },
    getInventorySubsidiary(s) {
      this.$http({
        url: `subsidiary/${s}/products`,
        method: 'GET'
      }).then((res) => {
        this.inventories = res.data.inventories
        this.invent = true
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
    getPets(c) {
      this.$http({
        url: `subsidiary/${c}/pets`,
        method: 'GET'
      }).then((res) => {
        this.pets = res.data.pets
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
        this.getPets(d)
      }, () => {
        this.has_error = true
      })
    },
    addClient() {
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
      }, () => {
        this.has_error = true
      })
    },
    addSeller() {
      this.$http({
        url: `sellers`,
        method: 'POST',
        data: {
          subsidiary: this.subsidiary,
          name: this.seller_name,
          shift: this.shift,
          first_name: this.first_name_seller,
          last_name: this.last_name_seller,
          address: this.address_seller,
          rfc: this.rfc_seller,
          account: this.account_seller,
          personal_email: this.personal_email,
          office_email: this.office_email,
          cellphone: this.cellphone_seller
        }
      }).then((res) => {
        this.seller = res.data.seller
        this.old_seller = true
        this.created_seller = true
        this.getSellers(this.subsidiary)
      }, () => {
        this.has_error = true
      })
    },
    addPet() {
      this.$http({
        url: `pets`,
        method: 'POST',
        data: {
          subsidiary: this.subsidiary,
          client: this.client.id,
          name: this.pet_name,
          kind: this.kind,
          genus: this.genus,
          weight: this.weight,
          owner: this.owner,
          birth: this.birth,
          death: this.death
        }
      }).then((res) => {
        this.pet = res.data.pet
        this.old_pet = true
        this.created_pet = true
      }, () => {
        this.has_error = true
      })
    },
    addFinalSale() {
      this.$http({
        url: `sales`,
        method: 'POST',
        data: {
          subsidiary: this.subsidiary,
          client: this.client.id,
          seller: this.seller.id,
          pet: this.pet.id,
          total: this.productsTotal,
          quantity: this.productsQuantity,
          products: this.newProducts,
          folio: this.folio
        }
      }).then((res) => {
        this.closeShowModal()
        this.success_message = true
        this.sales = res.data.sales
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
      this.old_client = true
      this.old_seller = true
      this.old_pet = true
      this.products = []
      this.newProducts = []
		},
  }
}
</script>

<style lang="css" scoped>
.table {
  margin-bottom: 0;
}
.inputQ {
  width: 100px;
}
</style>
