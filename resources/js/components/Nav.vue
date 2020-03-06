<template>
    <div class="">
        <header class="cd-main-header js-cd-main-header">
            <div class="cd-logo-wrapper">
              <a href="#0" class="cd-logo"><img src="/img/cd-logo.svg" alt="Logo"></a>
            </div>

            <div class="cd-search js-cd-search">
              <form>
                <input class="reset" type="search" placeholder="Buscar...">
              </form>
            </div>

            <button class="reset cd-nav-trigger js-cd-nav-trigger" aria-label="Toggle menu"><span></span></button>

            <ul class="cd-nav__list js-cd-nav__list">
              <li class="cd-nav__item"
                  v-if="!$auth.check()"
                  v-for="(route, key) in routes.unlogged"
                  v-bind:key="route.path"
              >
                  <router-link  :to="{ name : route.path }" :key="key">
                      {{route.name}}
                  </router-link>
              </li>
              <li class="cd-nav__item cd-nav__item--has-children cd-nav__item--account js-cd-item--has-children" v-if="$auth.check() ? navVisible = true : navVisible = false">
                  <a href="#0">
                    <img src="/img/cd-avatar.svg" alt="avatar">
                    <span>Cuenta</span>
                  </a>

                <ul class="cd-nav__sub-list">
                  <li class="cd-nav__sub-item">
                      <a href="" @click.prevent="$auth.logout()">Logout</a>
                  </li>
                </ul>
              </li>
            </ul>
        </header> <!-- .cd-main-header -->
        <main class="cd-main-content">
          <nav class="cd-side-nav js-cd-side-nav">
            <ul class="cd-side__list js-cd-side__list">
              <li class="cd-side__item cd-side__item--selected cd-side__item--overview"
                  v-if="$auth.check()"
                  v-for="(route, key) in routes.user"
                  v-bind:key="route.path"
              >
                  <router-link  :to="{ name : route.path }" :key="key">
                      {{route.name}}
                  </router-link>
              </li>

              <li class="cd-side__item"
                  v-if="$auth.check()"
                  v-for="(route, key) in routes.subsidiaries"
                  v-bind:key="route.path"
              >
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}}
                </router-link>
              </li>

              <li class="cd-side__item"
                  v-if="$auth.check()"
                  v-for="(route, key) in routes.clients"
                  v-bind:key="route.path"
              >
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}}
                </router-link>
              </li>

              <li class="cd-side__item"
                  v-if="$auth.check()"
                  v-for="(route, key) in routes.inventory"
                  v-bind:key="route.path"
              >
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}}
                </router-link>
              </li>

              <li class="cd-side__item"
                  v-if="$auth.check()"
                  v-for="(route, key) in routes.products"
                  v-bind:key="route.path"
              >
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}}
                </router-link>
              </li>

              <li class="cd-side__item"
                  v-if="$auth.check()"
                  v-for="(route, key) in routes.services"
                  v-bind:key="route.path"
              >
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}}
                </router-link>
              </li>

              <li class="cd-side__item"
                  v-if="$auth.check()"
                  v-for="(route, key) in routes.sales"
                  v-bind:key="route.path"
              >
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}}
                </router-link>
              </li>

              <li class="cd-side__item"
                  v-if="$auth.check()"
                  v-for="(route, key) in routes.sellers"
                  v-bind:key="route.path"
              >
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}}
                </router-link>
              </li>
            </ul>

            <ul class="cd-side__list js-cd-side__list">
              <li><a href="" @click.prevent="$auth.logout()">Logout</a></li>
              <li class="cd-side__btn" v-if="!$auth.check()"><button class="reset" href="#0">Login</button></li>
              <li class="cd-side__btn" v-if="$auth.check()"><button class="reset" href="#0">Agregar Sucursal</button></li>
            </ul>
          </nav>

          <div class="cd-content-wrapper container-fluid">
            <div class="text-component text-center">
              <router-view></router-view>
            </div>
          </div> <!-- .content-wrapper -->
        </main> <!-- .cd-main-content -->
    </div>
</template>
<script>
  export default {
    data() {
      return {
        navVisible: false,
        routes: {
          // UNLOGGED
          unlogged: [
            {
              name: 'Registro',
              path: 'register'
            },
            {
              name: 'Login',
              path: 'login'
            }
          ],
          user: [
            {
              name: 'Dashboard',
              path: 'dashboard'
            }
          ],
          subsidiaries: [
            {
              name: 'Sucursales',
              path: 'subsidiaries'
            }
          ],
          sales: [
            {
              name: 'Ventas',
              path: 'sales'
            }
          ],
          sellers: [
            {
              name: 'Vendedores',
              path: 'sellers'
            }
          ],
          clients: [
            {
              name: 'Clientes',
              path: 'clients'
            }
          ],
          inventory: [
            {
              name: 'Inventario',
              path: 'inventory'
            }
          ],
          products: [
            {
              name: 'Productos',
              path: 'product'
            }
          ],
          services: [
            {
              name: 'Servicios',
              path: 'service'
            }
          ]
        }
      }
    },
    mounted() {
      //
    }
  }
</script>
