<template>
  <div>
    <HeaderMain />
    
    <div class="login-container">
      <h1>Login</h1>
      <form @submit.prevent="login">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password" required>
        </div>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
import HeaderMain from '@/components/Header.vue';
import axios from 'axios';

export default {
  components: {
    HeaderMain
  },
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    login() {
      axios.post(`${process.env.VUE_APP_ROOT_API_URL}/login`, {
        email: this.email,
        password: this.password
      })
      .then(response => {
        // Se o login for bem-sucedido, você receberá o token JWT no corpo da resposta
        const token = response.data;
        // Salve o token JWT no localStorage para uso posterior
        localStorage.setItem('token', token);
        // Após o login bem-sucedido, redirecione o usuário para a página Home
        this.$router.push({ name: 'home' });
      });
    }
  }
};
</script>

<style scoped>
.login-container {
  max-width: 400px;
  margin: auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.form-group {
  margin-bottom: 15px;
}
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
button {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
button:hover {
  background-color: #0056b3;
}
</style>
