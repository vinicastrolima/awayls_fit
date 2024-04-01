import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ProductView from '../views/ProdutosView.vue'
import LoginPage from '../views/Login.Vue'
import ProductPage from '../views/Individual.vue'


const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage
  },
  {
    path: '/Products',
    name: 'Produtos',
    component: ProductView
  },
  {
    path: '/product/:id',
    name: 'Product',
    component: ProductPage,
    props: true
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
