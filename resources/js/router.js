import VueRouter from 'vue-router'

// Pages
import Register from './components/Register'
import Login from './components/Login'
import Dashboard from './components/Dashboard'
import AdminDashboard from './components/admin/Dashboard'
import Subsidiary from './components/Subsidiary'
import Sales from './components/Sales'
import Seller from './components/Seller'
import Client from './components/Client'

// Routes
const routes = [
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      auth: false
    }
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      auth: false
    }
  },
  {
    path: '/',
    name: 'dashboard',
    component: Dashboard,
    meta: {
      auth: true
    }
  },
  {
    path: '/sucursales',
    name: 'subsidiaries',
    component: Subsidiary,
    meta: {
      auth: true
    }
  },
  {
    path: '/ventas',
    name: 'sales',
    component: Sales,
    meta: {
      auth: true
    }
  },
  {
    path: '/vendedores',
    name: 'sellers',
    component: Seller,
    meta: {
      auth: true
    }
  },
  {
    path: '/clientes',
    name: 'clients',
    component: Client,
    meta: {
      auth: true
    }
  }
]
const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})
export default router
