<template>
    <div class="grid gap-6">
      <!-- Шаги -->
      <div v-if="step === 1">
        <h2 class="text-lg font-bold mb-4">Шаг 1: Основная информация</h2>
        <input
          v-model="fullName"
          type="text"
          placeholder="ФИО"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
        />
        <input
          v-model="age"
          type="text"
          placeholder="Введите возраст"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
        />
        <input
          v-model="phone"
          type="text"
          placeholder="Телефон"
          @input="hasInput = true"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
        />
        <p v-if="!isPhoneValid && hasInput" class="text-red-600">
          Номер телефона должен содержать только цифры и быть длиной от 6 до 10 символов
        </p>
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          @input="hasEmail = true"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
        />
        <p v-if="!isEmailValid && hasEmail" class="text-red-600">Введите корректный email</p>
        <input
          v-model="birthDate"
          type="date"
          placeholder="Дата рождения"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
        />
      </div>
  
      <div v-if="step === 2">
        <h2 class="text-lg font-bold mb-4">Шаг 2: Информация о профессии</h2>
        <input
          v-model="profession"
          type="text"
          placeholder="Профессия"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
        />
        <div class="relative flex flex-col">
          <input
            v-model="searchQuery"
            type="text"
            :placeholder="searchQuery || 'Введите город'"
            class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
          />
          <select
            @change="handleSelectCity"
            v-if="isCityListVisible"
            id="cities"
            size="5"
            class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
          >
            <option v-if="cities.length === 0" disabled>Ничего не найдено</option>
            <option
              v-for="city in cities"
              :key="city.id"
              :value="city.id"
            >
              {{ city.title }}
            </option>
          </select>
        </div>
      </div>
  
      <div v-if="step === 3">
        <h2 class="text-lg font-bold mb-4">Шаг 3: Образование</h2>
        <div v-for="(edu, index) in educationList" :key="index" class="mt-4">
          <Select v-model="edu.educationLevel">
            <SelectTrigger>
              <SelectValue placeholder="Образование" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem value="school">Среднее</SelectItem>
                <SelectItem value="colledge">Среднее специальное</SelectItem>
                <SelectItem value="not_university">Неоконченное высшее</SelectItem>
                <SelectItem value="university">Высшее</SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
          <input
            v-if="edu.educationLevel !== 'school'"
            v-model="edu.stateUnivesity"
            type="text"
            placeholder="Учебное заведение"
            class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
          />
          <button
            @click="removeEducationBlock(index)"
            class="bg-red-500 text-white px-4 py-2 rounded mt-2"
          >
            Удалить
          </button>
        </div>
        <button @click="addEducationBlock" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
          Добавить образование
        </button>
      </div>
  
      <div v-if="step === 4">
        <h2 class="text-lg font-bold mb-4">Шаг 4: Навыки и информация о себе</h2>
        <textarea
          v-model="skills"
          placeholder="Ключевые навыки"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
        ></textarea>
        <textarea
          v-model="about"
          placeholder="О себе"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
        ></textarea>
      </div>
  
      <div class="flex justify-between mt-6">
        <button
          v-if="step > 1"
          @click="prevStep"
          class="bg-gray-500 text-white px-4 py-2 rounded"
        >
          Назад
        </button>
        <button
          v-if="step < 4"
          @click="nextStep"
          class="bg-blue-500 text-white px-4 py-2 rounded"
        >
          Далее
        </button>
        <button
          v-if="step === 4"
          @click="applyData"
          class="bg-green-500 text-white px-4 py-2 rounded"
        >
          Применить
        </button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  // Состояние шага
  const step = ref(1)
  
  const nextStep = () => {
    if (step.value < 4) step.value++
  }
  const prevStep = () => {
    if (step.value > 1) step.value--
  }
  </script>
  