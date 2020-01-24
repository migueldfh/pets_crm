import VueRouter from 'vue-router'

// Pages
import Register from './components/Register'
import Login from './components/Login'
import Dashboard from './components/Dashboard'
import AdminDashboard from './components/admin/Dashboard'

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
  // USER ROUTES
  {
    path: '/',
    name: 'dashboard',
    component: Dashboard,
    meta: {
      auth: true
    }
  },
]
const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})
export default router
