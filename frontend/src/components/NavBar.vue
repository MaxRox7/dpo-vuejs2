<template>
  <div class="navbar-container">
    <div class="navbar-content">
      <h1 @click="route.push('/')"
        class="navbar-item navbar-home">
        Drag-and-drop
      </h1>
      <h1 @click="route.push('/new')"
        class="navbar-item navbar-new">
        Add Resume
      </h1>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRouter()
</script>

<style lang="scss" scoped>
/* Контейнер для навигационной панели */
.navbar-container {
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(135deg, #6a5acd, #ff7f50); /* Градиентный фон */
  padding: 16px 0;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Контейнер для элементов навигации */
.navbar-content {
  display: flex;
  gap: 24px;
  align-items: center;
}

/* Элементы навигации */
.navbar-item {
  font-family: 'Poppins', sans-serif; /* Современный шрифт */
  font-weight: 600;
  font-size: 1.25rem;
  cursor: pointer;
  padding: 8px 16px;
  border-radius: 5px;
  transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
  text-align: center;
}

/* Стиль для первого элемента */
.navbar-home {
  background-color: #ffffff;
  color: #6a5acd;
}

.navbar-home:hover {
  background-color: #6a5acd;
  color: #ffffff;
  transform: scale(1.05);
}

/* Стиль для второго элемента */
.navbar-new {
  background-color: #ffffff;
  color: #ff7f50;
}

.navbar-new:hover {
  background-color: #ff7f50;
  color: #ffffff;
  transform: scale(1.05);
}
</style>
