<template>
    <div class="">
        <header class="cd-main-header js-cd-main-header">
            <div class="cd-logo-wrapper">
              <a href="#0" class="cd-logo"><img src="/img/cd-logo.svg" alt="Logo"></a>
            </div>

            <div class="cd-search js-cd-search">
              <form>
                <input class="reset" type="search" placeholder="Search...">
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
                    <span>Account</span>
                  </a>

                <ul class="cd-nav__sub-list">
                  <!-- <li class="cd-nav__sub-item"><a href="#0">My Account</a></li>
                  <li class="cd-nav__sub-item"><a href="#0">Edit Account</a></li> -->
                  <li class="cd-nav__sub-item" v-if="$auth.check()">
                      <a href="" @click.prevent="$auth.logout()">Logout</a>
                  </li>
                </ul>
              </li>
            </ul>
        </header> <!-- .cd-main-header -->
        <main class="cd-main-content">
          <nav class="cd-side-nav js-cd-side-nav">
            <ul class="cd-side__list js-cd-side__list">
              <li class="cd-side__item cd-side__item--has-children cd-side__item--overview"
                  v-if="$auth.check(2)"
                  v-for="(route, key) in routes.user"
                  v-bind:key="route.path"
              >
                  <router-link  :to="{ name : route.path }" :key="key">
                      {{route.name}}
                  </router-link>
              </li>

              <li class="cd-side__item cd-side__item--has-children js-cd-item--has-children"
                  v-if="$auth.check(2)"
              >
                <a href="#0">Clientes<!--span class="cd-count">3</span--></a>

                <ul class="cd-side__sub-list">
                  <li class="cd-side__sub-item"><a aria-current="page" href="#0">Agregar cliente</a></li>
                </ul>
              </li>

              <li class="cd-side__item cd-side__item--has-children js-cd-item--has-children"
                  v-if="$auth.check(2)"
              >
                <a href="#0">Sucursales<!--span class="cd-count">3</span--></a>

                <ul class="cd-side__sub-list">
                  <li class="cd-side__sub-item"><a aria-current="page" href="#0">Agregar sucursal</a></li>
                  <li class="cd-side__sub-item"><a href="#0">Agregar zona</a></li>
                  <li class="cd-side__sub-item"><a href="#0">Administrar zonas</a></li>
                </ul>
              </li>

              <li class="cd-side__item cd-side__item--has-children js-cd-item--has-children"
                  v-if="$auth.check(2)"
              >
                <a href="#0">Inventario</a>

                <ul class="cd-side__sub-list">
                  <li class="cd-side__sub-item"><a href="#0">Agregar</a></li>
                  <li class="cd-side__sub-item"><a href="#0">Lista por zona</a></li>
                </ul>
              </li>

              <li class="cd-side__item cd-side__item--has-children js-cd-item--has-children"
                  v-if="$auth.check(2)"
              >
                <a href="#0">Ventas</a>

                <!-- <ul class="cd-side__sub-list">
                  <li class="cd-side__sub-item"><a href="#0">Agregar</a></li>
                  <li class="cd-side__sub-item"><a href="#0">Lista por zona</a></li>
                </ul> -->
              </li>

              <li class="cd-side__item cd-side__item--has-children js-cd-item--has-children"
                  v-if="$auth.check(2)"
              >
                <a href="#0">Cobranza</a>

                <!-- <ul class="cd-side__sub-list">
                  <li class="cd-side__sub-item"><a href="#0">Agregar</a></li>
                  <li class="cd-side__sub-item"><a href="#0">Lista por zona</a></li>
                </ul> -->
              </li>
            </ul>

            <!-- <ul class="cd-side__list js-cd-side__list">
              <li class="cd-side__label"><span>Secondary</span></li>
              <li class="cd-side__item cd-side__item--has-children cd-side__item--bookmarks js-cd-item--has-children">
                <a href="#0">Bookmarks</a>

                <ul class="cd-side__sub-list">
                  <li class="cd-side__sub-item"><a href="#0">All Bookmarks</a></li>
                  <li class="cd-side__sub-item"><a href="#0">Edit Bookmark</a></li>
                  <li class="cd-side__sub-item"><a href="#0">Import Bookmark</a></li>
                </ul>
              </li>

              <li class="cd-side__item cd-side__item--has-children cd-side__item--images js-cd-item--has-children">
                <a href="#0">Images</a>

                <ul class="cd-side__sub-list">
                  <li class="cd-side__sub-item"><a href="#0">All Images</a></li>
                  <li class="cd-side__sub-item"><a href="#0">Edit Image</a></li>
                </ul>
              </li>

              <li class="cd-side__item cd-side__item--has-children cd-side__item--users js-cd-item--has-children">
                <a href="#0">Users</a>

                <ul class="cd-side__sub-list">
                  <li class="cd-side__sub-item"><a href="#0">All Users</a></li>
                  <li class="cd-side__sub-item"><a href="#0">Edit User</a></li>
                  <li class="cd-side__sub-item"><a href="#0">Add User</a></li>
                </ul>
              </li>
            </ul> -->

            <ul class="cd-side__list js-cd-side__list">
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
          // LOGGED USER
          user: [
            {
              name: 'Dashboard',
              path: 'dashboard'
            }
          ],
        }
      }
    },
    mounted() {
      //
    }
  }
</script>
