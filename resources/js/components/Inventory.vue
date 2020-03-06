<template>
  <div class="container-fluid">
    <h1>Inventario</h1>
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
    <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="choice">
        <p>Debes elegir la sucursal antes de guardar.</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
    </div>
    <div class="row mt-4" v-if="invent === false">
      <hr>
      <div class="table-responsive">
        <table class="table table-borderless table-hover">
          <thead>
            <tr>
              <th scope="col">Código</th>
              <th scope="col">Descripción</th>
              <th scope="col">Costo</th>
              <th scope="col">% precio de venta</th>
              <th scope="col">Precio a Cliente Vet.</th>
              <th scope="col">Precio a Cliente Particular</th>
              <th scope="col">Cantidad Matriz</th>
              <th scope="col">Cantidad Sucursal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products">
              <th scope="row"> {{ product.code }} </th>
              <td>{{ product.name }}</td>
              <td> ${{ formatPrice(product.buying_price) }}</td>
              <td><input type="text" v-model="product.percentage" name="" value=""></td>
              <td><input type="text" v-model="product.price_clients" name="" value=""></td>
              <td><input type="text" v-model="product.price_supplier" name="" value=""></td>
              <td>{{ product.quantity }}</td>
              <td><input type="text" name="" value="" v-model="product.subsidiary_quantity"></td>
              <td><button type="button" name="button" class="btn btn-primary" @click.prevent="saveProduct(product.percentage, product.price_clients, product.price_supplier, product.buying_price, product.subsidiary_quantity, product.id, product.code)">Guardar</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row mt-4" v-else>
      <hr>
      <div class="table-responsive">
        <table class="table table-borderless table-hover">
          <thead>
            <tr>
              <th scope="col">Descripción</th>
              <th scope="col">Costo</th>
              <th scope="col">% precio de venta</th>
              <th scope="col">Precio a Vet. Clientes</th>
              <th scope="col">Precio a Vet. Proveedor</th>
              <th scope="col">Cantidad Matriz</th>
              <th scope="col">Cantidad Sucursal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="inventory in inventories">
              <td>{{ inventory.name }}</td>
              <td> ${{ formatPrice(inventory.cost) }}</td>
              <td><input type="text" v-model="inventory.operative_costs" name="" value=""></td>
              <td><input type="text" v-model="inventory.selling_price" name="" value=""></td>
              <td><input type="text" v-model="inventory.supplier_selling_price" name="" value=""></td>
              <td>{{ inventory.general_quantity }}</td>
              <td><a href="#" @click.prevent="inventory.quantity -= 1"><i class="fas fa-minus-circle" v-if="inventory.quantity > 0"></i></a>&nbsp;<input type="text" name="" value="" v-model="inventory.quantity">&nbsp;<a href="#" @click.prevent="inventory.quantity += 1"><i class="fas fa-plus-circle"></i></a></td>
              <td><button type="button" name="button" class="btn btn-primary" @click.prevent="saveProduct(inventory.percentage, inventory.price_clients, inventory.price_supplier, inventory.buying_price, inventory.subsidiary_quantity, inventory.id)">Guardar</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      subsidiary: null,
      subsidiaries: [],
      products: [],
      inventories: [],
      has_error: false,
      success_message: false,
      choice: false,
      invent: false,
    }
  },
  mounted() {
    this.getSubsidiaries()
  },
  watch: {
    subsidiary() {
      this.getInventorySubsidiary(this.subsidiary)
    },
  },
  methods: {
    formatPrice (value) {
        let val = (value/1).toFixed(2)
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },
    getSubsidiaries() {
      this.$http({
        url: `subsidiaries`,
        method: 'GET'
      }).then((res) => {
        this.subsidiaries = res.data.subsidiaries
        this.getProducts()
      }, () => {
        this.has_error = true
      })
    },
    getInventorySubsidiary(s) {
      this.$http({
        url: `subsidiary/${s}/products`,
        method: 'GET'
      }).then((res) => {
        this.inventories = res.data.inventories
        if (this.inventories.length != 0) {
            this.invent = true
        }
      }, () => {
        this.has_error = true
      })
    },
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
    saveProduct(p, c, r, b, s, i, d) {
      if (this.subsidiary == null) {
        this.choice = true
      } else {
        this.$http({
          url: `subsidiary/${this.subsidiary}/products`,
          method: 'POST',
          data: {
            product: i,
            percentage: p,
            buying_clients: c,
            buying_supplier: r,
            price: b,
            quantity: s,
            cod: d
          }
        }).then((res) => {
          this.success_message = true
          // this.getInventorySubsidiary(this.subsidiary)
        }, () => {
          this.has_error = true
        })
      }
    },
    // plus(p, n) {
    //   this.$http({
    //     url: `products/${p}`,
    //     method: 'GET'
    //   }).then((res) => {
    //     let temp_product = null
    //     temp_product = res.data.product
    //
    //     if (n < temp_product.quantity) {
    //
    //     }
    //   }, () => {
    //     this.has_error = true
    //   })
    // }
  }
}
</script>

<style lang="css" scoped>
</style>
