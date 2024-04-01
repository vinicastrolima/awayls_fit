import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import ProductView from '../views/ProdutosView.vue';
import ProductPage from '../views/Individual.vue';
import LoginPage from '../views/LoginView.vue';
import PedidosPage from '../views/Pedidos.vue';
import DetalhesPedido from '../views/OrderView.vue';
import CartDetails from '../views/Checkout.vue'; 

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/loginPage',
    name: 'LoginPage',
    component: LoginPage
  },
  {
    path: '/orders',
    name: 'PedidosPage',
    component: PedidosPage
  },
  {
    path: '/pedido/:id',
    name: 'DetalhesPedido',
    component: DetalhesPedido,
    props: true
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
    path: '/cart',
    name: 'CartDetails', // Nome da nova rota
    component: CartDetails // Componente da nova rota
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

export default router;
