<template>
    <div>
      <HeaderMain />
      <h1 class="mt-4 mb-3">Detalhes do Pedido</h1>
      
      <!-- Informações do Pedido -->
      <div class="pedido-info mb-4">
        <h2>ID do Pedido: {{ pedido.id }}</h2>
        <p>Total: R$ {{ pedido.total_amount }}</p>
        <p>Método de Pagamento: {{ pedido.payment_method }}</p>
        <p>Endereço de Entrega: {{ pedido.delivery_address }}</p>
        <p>Data de Criação: {{ formatarData(pedido.created_at) }}</p>
        <p>Data de Atualização: {{ formatarData(pedido.updated_at) }}</p>
      </div>
      
      <!-- Lista de Itens -->
      <div class="pedido-itens">
        <h2>Itens do Pedido</h2>
        <ul class="list-group">
          <li class="list-group-item" v-for="item in pedido.items" :key="item.name">
            {{ item.name }} - Quantidade: {{ item.quantity }}
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import HeaderMain from '@/components/Header.vue';
  import axios from 'axios';
  
  export default {
    name: 'DetalhesPedido',
    props: {
      id: {
        type: Number,
        required: true
      }
    },
    components: {
      HeaderMain
    },
    data() {
      return {
        pedido: null
      };
    },
    mounted() {
      this.carregarDetalhesPedido();
    },
    methods: {
      carregarDetalhesPedido() {
        const token = localStorage.getItem('token');
        if (token) {
          axios.get(`${process.env.VUE_APP_ROOT_API_URL}/orders/${this.id}`, {
            headers: {
              Authorization: `Bearer ${token}`
            }
          })
            .then(response => {
              this.pedido = response.data;
            })
            .catch(error => {
              console.error('Erro ao carregar detalhes do pedido:', error);
            });
        }
      },
      formatarData(data) {
        return new Date(data).toLocaleString();
      }
    }
  };
  </script>
  
  <style scoped>
  /* Estilos específicos para este componente */
  .pedido-info {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
  }
  
  .pedido-itens {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
  }
  
  .pedido-itens ul {
    margin: 0;
    padding: 0;
  }
  
  .pedido-itens li {
    list-style: none;
    margin-bottom: 5px;
  }
  </style>
  