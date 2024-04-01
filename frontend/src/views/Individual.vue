<template>
  <div>
    <HeaderMain />

    <div class="container">
      <div class="row mt-5 align-items-center">
        <div class="col-md-6">
          <img :src="product.image_url" class="img-fluid" :alt="product.name">
        </div>
        <div class="col-md-6">
          <!-- Adicione a classe de margem Bootstrap ao título do produto -->
          <h2 class="mb-3">{{ product.name }}</h2>
          <p class="mb-4">{{ product.description }}</p>
          <p>R$ {{ product.price }}</p>
          <button class="btn btn-primary mt-3">Adicionar ao Carrinho</button>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import HeaderMain from '@/components/Header.vue';
import axios from 'axios';

export default {
  name: 'ProductPage',
  components: {
    HeaderMain
  },
  data() {
    return {
      product: {}
    };
  },
  mounted() {
    const productId = this.$route.params.id;
    this.fetchProduct(productId);
  },
  methods: {
    fetchProduct(productId) {
      axios.get(`${process.env.VUE_APP_ROOT_API_URL}/products/${productId}`)
        .then(response => {
          this.product = response.data;
        })
        .catch(error => {
          console.error('Erro ao obter detalhes do produto:', error);
        });
    }
  }
}
</script>

<style scoped>
/* Estilos específicos para este componente, se necessário */
</style>
