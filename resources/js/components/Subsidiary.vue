<template>
  <div class="container">
    <div class="states">
      <h2 class="text-left">Sucursales</h2>
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
          <label for="">Agregar sucursal:</label>
          <input type="text" name="" value="" v-model="new_subsidiary">
          <button type="button" class="btn btn-outline-primary" name="button" @click="addSubsidiary()">Agregar</button>
        </div>
      </div>
    </div>
    <div class="zones">
      <h2 class="text-left">Zonas por sucursal</h2>
      <div class="row" v-if="selectedSubsidiary">
        <div class="col">
          <label for="">Selecciona zona:</label>
          <select class="" name="" v-model="zone">
            <option value="" disabled selected>Seleccionar...</option>
            <option v-for="zone in zones" :value="zone.id">{{ zone.name }}</option>
          </select>
        </div>
        <div class="col">
            <label for="">Agregar zona:</label>
            <input type="text" name="" value="" v-model="new_zone">
            <button type="button" class="btn btn-outline-primary" name="button" @click="addZone()">Agregar</button>
        </div>
      </div>
    </div>
    <div class="cities">
      <h2 class="text-left">Ciudades</h2>
      <div class="row" v-if="selectedZone">
        <div class="col">
          <ul class="text-left list-unstyled" style="list-style: none">
            <li v-for="city in cities">{{ city.name }}</li>
          </ul>
        </div>
        <div class="col">
            <label for="">Agregar ciudad a zona:</label>
            <input type="text" name="" value="" v-model="new_city">
            <button type="button" class="btn btn-outline-primary" name="button" @click="addCity()">Agregar</button>
        </div>
      </div>
    </div>
  </div>
</template>
Ventas: Tipos servicios de cremacion, placas, refacciones de maquinas y ventas de maquinas, urnas.
Reporte: Exportar a excel total de ventas por tipo de cliente (Vet. Cliente, Particular), suma de ventas (todo por mes o rango de tiempo)
Reporte a nivel vendedor. Filtro por fecha, Totales de ventas por tipo y tabla de ventas que hizo. filtro en tabla.
Reporte a nivel tipo de venta.
Reporte
Cliente: Estados de cuenta.
<script>
export default {
  data() {
    return {
      subsidiaries: [],
      zones: [],
      cities: [],
      zone: null,
      subsidiary: null,
      new_subsidiary: null,
      new_zone: null,
      new_city: null,
      selectedSubsidiary: false,
      selectedZone: false,
      success_message: false,
      has_error: false,
    }
  },
  mounted() {
    this.getSubsidiaries()
  },
  watch: {
    subsidiary() {
      this.getZones(this.subsidiary)
    },
    zone() {
      this.getCities(this.zone)
    }
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
    addSubsidiary() {
      this.$http({
        url: `subsidiaries`,
        method: 'POST',
        data: {
          subsidiary: this.new_subsidiary
        }
      }).then((res) => {
        this.subsidiaries = res.data.subsidiaries
        this.new_subsidiary = null
        this.success_message = true
      }, () => {
        this.has_error = true
      })
    },
    getZones(s) {
      this.$http({
        url: `zones/${s}`,
        method: 'GET',
      }).then((res) => {
        this.zones = res.data.zones
        this.selectedSubsidiary = true
      }, () => {
        this.has_error = true
      })
    },
    addZone() {
      this.$http({
        url: `zones`,
        method: 'POST',
        data: {
          subsidiary: this.subsidiary,
          zone: this.new_zone
        }
      }).then((res) => {
        this.zones = res.data.zones
        this.new_zone = null
        this.success_message = true
      }, () => {
        this.has_error = true
      })
    },
    getCities(c) {
      this.$http({
        url: `cities/${c}`,
        method: 'GET',
      }).then((res) => {
        this.cities = res.data.cities
        this.selectedZone = true
      }, () => {
        this.has_error = true
      })
    },
    addCity() {
      this.$http({
        url: `cities`,
        method: 'POST',
        data: {
          zone: this.zone,
          city: this.new_city
        }
      }).then((res) => {
        this.cities = res.data.cities
        this.new_city = null
        this.success_message = true
      }, () => {
        this.has_error = true
      })
    },
  }
}
</script>

<style lang="css" scoped>
</style>
