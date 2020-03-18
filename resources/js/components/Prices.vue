<template>
  <div class="container-fluid">
    <h1>Lista Precios</h1>
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
      <div class="col-3">
        <label for="">Sucursal:</label>
        <select class="" name="" v-model="subsidiary">
          <option disabled selected>Seleccionar...</option>
          <option v-for="subsidiary in subsidiaries" :value="subsidiary.id">{{ subsidiary.name }}</option>
        </select>
      </div>
      <div class="col-3">
        <label for="">Tipo de Cliente:</label>
        <select class="" name="" v-model="type">
          <option value="" disabled selected>Seleccionar...</option>
          <option value="1">Particular</option>
          <option value="2">Veterinaria Clientes</option>
        </select>
      </div>
    </div>
    <div class="row mt-4">
      <div class="table-responsive">
        <table class="table table-borderless table-hover">
          <thead>
            <tr>
              <th scope="col">Peso kg</th>
              <th scope="col">Urna Madera</th>
              <th scope="col">Urna Cristal</th>
              <th scope="col">Costal Terciopelo</th>
              <th scope="col">Acero Inoxidable</th>
              <th scope="col">Urna Premium</th>
              <th scope="col">Urna Biodegradable</th>
              <th scope="col">Sin Recuperación</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="price in prices">
              <th scope="row"> {{ price.weight }} </th>
              <td>${{ price.wood }}</td>
              <td>${{ price.cristal }}</td>
              <td>${{ price.terciopelo }}</td>
              <td>${{ price.inoxidable }}</td>
              <td>${{ price.premium }}</td>
              <td>${{ price.bio }}</td>
              <td>${{ price.without }}</td>
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
      prices: [],
      subsidiaries: [],
      has_error: false,
      success_message: false,
      subsidiary: null,
      type: null,
    }
  },
  mounted() {
    this.getSubsidiaries()
  },
  watch: {
    type() {
      this.getPrices(this.subsidiary, this.type)
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
    getPrices(s, t) {
      this.$http({
        url: `subsidiary/${s}/type/${t}/prices`,
        method: 'GET'
      }).then((res) => {
        this.prices = res.data.prices
      }, () => {
        this.has_error = true
      })
    },
  }
}
</script>
