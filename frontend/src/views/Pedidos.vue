<template>
    <div>
      <HeaderMain />
      <div class="container mt-4">
        <h1 class="mb-4">Pedidos</h1>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Total</th>
              <th>Método de Pagamento</th>
              <th>Ações</th> <!-- Nova coluna para o botão "Ver detalhes" -->
            </tr>
          </thead>
          <tbody>
            <tr v-for="pedido in pedidos" :key="pedido.id">
              <td>{{ pedido.id }}</td>
              <td>{{ pedido.total_amount }}</td>
              <td>{{ pedido.payment_method }}</td>
              <td>
                <button @click="verDetalhes(pedido.id)" class="btn btn-primary">Ver detalhes</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  import HeaderMain from '@/components/Header.vue';
  import axios from 'axios';
  
  export default {
    name: 'PedidosPage',
    components: {
      HeaderMain
    },
    data() {
      return {
        pedidos: []
      };
    },
    mounted() {
      this.carregarPedidos();
    },
    methods: {
      carregarPedidos() {
        const token = localStorage.getItem('token');
        if (token) {
          axios.get(`${process.env.VUE_APP_ROOT_API_URL}/orders`, {
            headers: {
              Authorization: `Bearer ${token}`
            }
          })
          .then(response => {
            this.pedidos = response.data;
          })
          .catch(error => {
            console.error('Erro ao obter pedidos:', error);
          });
        }
      },
      verDetalhes(id) {
        this.$router.push({ name: 'DetalhesPedido', params: { id: id } });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Estilos específicos para este componente, se necessário */
  </style>
