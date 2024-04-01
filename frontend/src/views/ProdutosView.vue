<template>
  <div>
    <HeaderMain />
    
    <div class="container">
      <div class="row mt-5">
        <div class="col-12">
          <h1 class="text-center">Todos os Nossos produtos!🌱</h1>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12">
          <div class="row row-cols-1 row-cols-md-4 g-4">
            <div v-for="produto in produtos" :key="produto.id" class="col">
              <div class="card">
                <img :src="produto.image_url" class="card-img-top img-thumbnail" :alt="produto.name">
                <div class="card-body">
                  <h5 class="card-title">{{ produto.name }}</h5>
                  <p class="card-text">R$ {{ produto.price }}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <!-- Botão "Veja Mais" -->
                    <router-link :to="{ name: 'Product', params: { id: produto.id } }" class="btn btn-secondary">Veja Mais</router-link>
                    <!-- Botão "Adicionar ao Carrinho" -->
                    <button class="btn btn-primary">Add ao Carrinho</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import HeaderMain from '@/components/Header.vue';
import axios from 'axios';

export default {
  name: 'HomePage',
  components: {
    HeaderMain,
  },
  data() {
    return {
      produtos: []
    };
  },
  mounted() {
    // Faz a requisição à API quando o componente é montado
    axios.get(`${process.env.VUE_APP_ROOT_API_URL}/products`)
      .then(response => {
        // Atualiza a lista de produtos com os dados da resposta
        this.produtos = response.data;
      })
      .catch(error => {
        console.error('Erro ao obter produtos:', error);
      });
  }
}
</script>

<style scoped>
/* Estilos específicos para este componente, se necessário */
</style>
