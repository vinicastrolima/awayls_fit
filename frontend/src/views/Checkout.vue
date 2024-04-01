<template>
    <div>
      <h1>Detalhes do Carrinho</h1>
      
      <!-- Lista de Itens do Carrinho -->
      <div v-if="cart.items && cart.items.length > 0">
        <h2>Itens do Carrinho</h2>
        <ul>
          <li v-for="(item, index) in cart.items" :key="index">
            {{ item.name }} - Quantidade: {{ item.quantity }}
          </li>
        </ul>
      </div>
      <div v-else>
        <p>Nenhum item no carrinho.</p>
      </div>
      
      <!-- Formulário para adicionar Endereço de Entrega e Método de Pagamento -->
      <div>
        <h2>Checkout</h2>
        <form @submit.prevent="fazerCheckout">
          <div class="form-group">
            <label for="deliveryAddress">Endereço de Entrega:</label>
            <input type="text" class="form-control" id="deliveryAddress" v-model="deliveryAddress" required>
          </div>
          <div class="form-group">
            <label for="paymentMethod">Método de Pagamento:</label>
            <select class="form-control" id="paymentMethod" v-model="paymentMethod" required>
              <option value="cash">Dinheiro</option>
              <option value="credit_card">Cartão de Crédito</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Finalizar Compra</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'CartDetails',
    data() {
      return {
        cart: {},
        deliveryAddress: '',
        paymentMethod: 'cash'
      };
    },
    mounted() {
      this.carregarDetalhesCarrinho();
    },
    methods: {
      carregarDetalhesCarrinho() {
        axios.get(`${process.env.VUE_APP_ROOT_API_URL}/cart/details`)
          .then(response => {
            this.cart = response.data;
          })
          .catch(error => {
            console.error('Erro ao carregar detalhes do carrinho:', error);
          });
      },
      fazerCheckout() {
        const data = {
          delivery_address: this.deliveryAddress,
          payment_method: this.paymentMethod
        };
        axios.post(`${process.env.VUE_APP_ROOT_API_URL}/cart/checkout`, data)
          .then(response => {
            console.log('Checkout realizado com sucesso:', response.data);
          })
          .catch(error => {
            console.error('Erro ao fazer checkout:', error);
          });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Estilos específicos para este componente, se necessário */
  </style>
  