<template>
  <div class="container-fluid">
    <h1>Reportes</h1>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="has_error">
        <p>Tuvimos problemas al traer datos, intenta de nuevo mas tarde.</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="row mt-4">
      <div class="row">
        <div class="col-md-4">
          <p>Servicios:
            <select class="" name="" v-model="services">
              <option value="" disabled selected>Seleccionar...</option>
              <option value="cinco">0-5kg</option>
              <option value="diez">6-10kg</option>
              <option value="quince">11-15kg</option>
              <option value="veinte">16-20kg</option>
              <option value="veinticinco">21-25kg</option>
              <option value="treinta">26-30kg</option>
              <option value="treintaycinco">31-35kg</option>
              <option value="cuarenta">36-40kg</option>
              <option value="cuarentaycinco">41-45kg</option>
              <option value="cincuenta">46-50kg</option>
              <option value="cincuentaycinco">51-55kg</option>
            </select>
          </p>
        </div>
        <div class="col-md-4">
          <p>Placas:
            <select class="" name="" v-model="placs">
              <option value="" disabled selected>Seleccionar...</option>
              <option value="cinco">Placas ID hueso rojo grande</option>
              <option value="diez">Placas ID hueso rosa grande</option>
              <option value="quince">Placas ID hueso azul grande</option>
              <option value="veinte">Placas ID corazon rosa grande</option>
            </select>
          </p>
        </div>
        <div class="col-md-4">
          <p>Urnas:
            <select class="" name="" v-model="urnes">
              <option value="" disabled selected>Seleccionar...</option>
              <option value="cinco" selected>Urna Biodegradable Corazon</option>
              <option value="diez" selected>Urna ecologica grande (retangular)</option>
              <option value="quince" selected>Urna arte nogal chica</option>
              <option value="veinte" selected>Urna de madera natural chica</option>
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
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <GChart
          type="ColumnChart"
          :data="chartData"
          :options="chartOptions"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { GChart } from 'vue-google-charts'

export default {
  data() {
    return {
      has_error: false,
      services: null,
      placs: null,
      urnes: null,
      products: [],
      chartData: [
        ['Mes', 'Servicios', 'Placas', 'Urnas'],
        ['Dic', 1000, 400, 200],
        ['Ene', 1170, 460, 250],
        ['Feb', 660, 1120, 300],
        ['Mar', 1030, 540, 350]
      ],
      chartOptions: {
        chart: {
          title: 'Ventas',
          subtitle: '',
        }
      }
    }
  },
  components: {
    GChart
  },
}
</script>

<style lang="css" scoped>
</style>
