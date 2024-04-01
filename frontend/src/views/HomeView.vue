<template>
  <div>
    <HeaderMain />
    
    <div class="container">
      <div class="row mt-5">
        <div class="col-12">
          <h1 class="text-center">Destaques! 🏆</h1>
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
                    <button @click="verDetalhes(produto.id)" class="btn btn-secondary">Veja Mais</button>
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
    HeaderMain
  },
  data() {
    return {
      produtos: []
    };
  },
  mounted() {
    // Faz a requisição à API quando o componente é montado
    axios.get(`${process.env.VUE_APP_ROOT_API_URL}/destaques`)
      .then(response => {
        // Atualiza a lista de produtos com os dados da resposta
        this.produtos = response.data;
      })
      .catch(error => {
        console.error('Erro ao obter produtos:', error);
      });
  },
  methods: {
    verDetalhes(id) {
      this.$router.push({ name: 'Product', params: { id: id } });
    }
  }
}
</script>

<style scoped>
/* Estilos específicos para este componente, se necessário */
</style>
