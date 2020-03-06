<template>
  <div class="container-fluid">
    <h1>Servicios</h1>
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
      <div class="table-responsive">
        <table class="table table-borderless table-hover">
          <thead>
            <tr>
              <th scope="col">Código</th>
              <th scope="col">Descripción Ticket</th>
              <th scope="col">Descripción</th>
              <th scope="col">Moneda</th>
              <th scope="col">Precio</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="service in services">
              <th scope="row"> {{ service.code }} </th>
              <td>{{ service.desc_ticket }}</td>
              <td>{{ service.name }}</td>
              <td>{{ service.currency }}</td>
              <td>${{ formatPrice(service.selling_price) }}</td>
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
      services: [],
      has_error: false,
      success_message: false,
    }
  },
  mounted() {
    this.getServices()
  },
  methods: {
    formatPrice (value) {
        let val = (value/1).toFixed(2)
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
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
    }
  }
}
</script>

<style lang="css" scoped>
</style>
