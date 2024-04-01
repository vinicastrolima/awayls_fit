<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <router-link to="/" class="navbar-brand">VCL FIT</router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link to="/" class="nav-link">Home</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/products" class="nav-link">Produtos</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/orders" class="nav-link">Pedidos</router-link>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link to="/cart" class="nav-link">Carrinho</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/login">Login</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/register" class="nav-link">Registrar</router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </template>
  
  <script>
  export default {
    name: 'HeaderMain',
    data() {
      return {
        showModal: false
      };
    },
    methods: {
      openModal() {
        this.showModal = true;
      },
      closeModal() {
        this.showModal = false;
      }
    }
  }
  </script>
  
  <style scoped>
  /* Estilos específicos para este componente, se necessário */
  </style>
  