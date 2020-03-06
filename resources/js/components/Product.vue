<template>
  <div class="container-fluid">
    <h1>Productos Matriz</h1>
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
    <div class="row mt-4">
      <div class="row">
        <div class="col-md-4">
          <p>Filtro:
            <select class="" name="" v-model="productFilter">
              <option value="all" selected>Todos</option>
              <option value="product" selected>Productos</option>
              <option value="accesory" selected>Accesorios</option>
            </select>
          </p>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-borderless table-hover">
          <thead>
            <tr>
              <th scope="col">Código</th>
              <th scope="col">Descripción</th>
              <th scope="col">Moneda</th>
              <th scope="col">Costo Unitario</th>
              <th scope="col">Cantidad</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products" v-if="showProducts">
              <th scope="row"> {{ product.code }} </th>
              <td>{{ product.name }}</td>
              <td>{{ product.currency }}</td>
              <td>$<input type="text" v-model="product.buying_price" name="" value=""> </td>
              <td><a href="#" @click.prevent="product.quantity -= 1"><i class="fas fa-minus-circle"></i></a>&nbsp;<input type="text" name="" value="" v-model="product.quantity">&nbsp;<a href="#" @click.prevent="product.quantity += 1"><i class="fas fa-plus-circle"></i></a></td>
              <td><button type="button" name="button" class="btn btn-primary" @click.prevent="saveProduct(product.buying_price, product.quantity, product.id)">Guardar</button></td>
            </tr>
            <tr v-for="accesory in accesories" v-if="showAccesories">
              <th scope="row"> {{ accesory.code }} </th>
              <td>{{ accesory.name }}</td>
              <td>{{ accesory.currency }}</td>
              <td>$<input type="text" v-model="accesory.buying_price" name="" value=""> </td>
              <td><a href="#" @click.prevent="accesory.quantity -= 1"><i class="fas fa-minus-circle"></i></a>&nbsp;<input type="text" name="" value="" v-model="accesory.quantity">&nbsp;<a href="#" @click.prevent="accesory.quantity += 1"><i class="fas fa-plus-circle"></i></a></td>
              <td><button type="button" name="button" class="btn btn-primary" @click.prevent="saveProduct(accesory.buying_price, accesory.quantity, product.id)">Guardar</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import {VMoney} from 'v-money'

export default {
  data() {
    return {
      products: [],
      accesories: [],
      has_error: false,
      success_message: false,
      showAccesories: true,
      showProducts: true,
      productFilter: 'all',
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
    this.getProducts()
    this.getAccesories()
  },
  watch: {
    productFilter() {
      if(this.productFilter == 'accesory') {
        this.showAccesories =  true
        this.showProducts = false
      } else if (this.productFilter == 'product') {
        this.showAccesories =  false
        this.showProducts = true
      } else {
        this.showAccesories =  true
        this.showProducts = true
      }
    },
  },
  methods: {
    getProducts() {
      this.$http({
        url: `products`,
        method: 'GET'
      }).then((res) => {
        this.products = res.data.products
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
    saveProduct(b, q, i) {
      this.$http({
        url: `products`,
        method: 'POST',
        data: {
          product: i,
          price: this.parseValue(b),
          quantity: q,
        }
      }).then((res) => {
        this.success_message = true
      }, () => {
        this.has_error = true
      })
    },
    add(a) {
      console.log(a)
      return a + 1
    },
    minus(m) {
      return m - 1
    },
    formatPrice (value) {
        let val = (value/1).toFixed(2)
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },
    parseValue(string) {
        var pattern = /\$|\,/ig;
        return parseInt(string.replace(pattern, ''))
    },
  }
}
</script>
