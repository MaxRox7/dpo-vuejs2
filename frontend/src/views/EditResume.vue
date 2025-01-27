<template>
  <div class="max-w-3xl mx-auto p-4 mt-4">
    <div v-if="showStatus === 'loading'" class="animate-pulse">
      <!-- Skeleton for form inputs with animation -->
      <div class="mb-4">
        <div class="h-6 bg-gray-300 rounded w-24 mb-2 skeleton-loading"></div>
        <div class="h-10 bg-gray-200 rounded w-full skeleton-loading"></div>
      </div>
      <div class="mb-4">
        <div class="h-6 bg-gray-300 rounded w-32 mb-2 skeleton-loading"></div>
        <div class="h-10 bg-gray-200 rounded w-full skeleton-loading"></div>
      </div>
      <div class="mb-4">
        <div class="h-6 bg-gray-300 rounded w-28 mb-2 skeleton-loading"></div>
        <div class="h-10 bg-gray-200 rounded w-full skeleton-loading"></div>
      </div>
      <div class="mb-4">
        <div class="h-6 bg-gray-300 rounded w-24 mb-2 skeleton-loading"></div>
        <div class="h-10 bg-gray-200 rounded w-full skeleton-loading"></div>
      </div>
      <div class="mb-4">
        <div class="h-6 bg-gray-300 rounded w-32 mb-2 skeleton-loading"></div>
        <div class="h-10 bg-gray-200 rounded w-full skeleton-loading"></div>
      </div>
      <div class="mb-4">
        <div class="h-6 bg-gray-300 rounded w-28 mb-2 skeleton-loading"></div>
        <div class="h-10 bg-gray-200 rounded w-full skeleton-loading"></div>
      </div>
      <div class="mb-4">
        <div class="h-6 bg-gray-300 rounded w-36 mb-2 skeleton-loading"></div>
        <div class="h-10 bg-gray-200 rounded w-full skeleton-loading"></div>
      </div>
      <div class="mb-4">
        <div class="h-6 bg-gray-300 rounded w-32 mb-2 skeleton-loading"></div>
        <div class="h-10 bg-gray-200 rounded w-full skeleton-loading"></div>
      </div>
      <div class="mb-4">
        <div class="h-6 bg-gray-300 rounded w-40 mb-2 skeleton-loading"></div>
        <div class="h-10 bg-gray-200 rounded w-full skeleton-loading"></div>
      </div>
    </div>

    <div v-else-if="showStatus === 'completed'">
      <h1 class="text-2xl font-bold mb-6">Редактировать резюме</h1>
      <form @submit.prevent="updateResume">
        <!-- Name -->
        <div class="mb-4">
          <label class="block text-gray-700">Имя</label>
          <input
            v-model="resumeData.name"
            type="text"
            class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Profession -->
        <div class="mb-4">
          <label class="block text-gray-700">Профессия</label>
          <input
            v-model="resumeData.profession"
            type="text"
            class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Status -->
        <div class="mb-4">
          <label class="block text-gray-700">Статус</label>
          <input
            v-model="resumeData.status"
            type="text"
            class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Photo -->
        <div class="mb-4">
          <label class="block text-gray-700">Фото</label>
          <input
            v-model="resumeData.photo"
            type="text"
            class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- City -->
        <div class="mb-4">
          <label class="block text-gray-700">Город</label>
          <input
            v-model="resumeData.city"
            type="text"
            class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Phone -->
        <div class="mb-4">
          <label class="block text-gray-700">Телефон</label>
          <input
            v-model="resumeData.phone"
            type="text"
            class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Email -->
        <div class="mb-4">
          <label class="block text-gray-700">Email</label>
          <input
            v-model="resumeData.email"
            type="email"
            class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- BirthDate -->
        <div class="mb-4">
          <label class="block text-gray-700">Дата рождения</label>
          <input
            v-model="resumeData.birthDate"
            type="date"
            class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Desired Salary -->
        <div class="mb-4">
          <label class="block text-gray-700">Желаемая зарплата</label>
          <input
            v-model="resumeData.desiredSalary"
            type="number"
            class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Education List -->
        <div class="mb-4">
          <h2 class="text-lg font-semibold mb-4">Образование</h2>
          <div
            v-for="(education, index) in resumeData.educationList"
            :key="index"
            class="mb-6 border-b pb-4"
          >
            <label class="block text-gray-700">Учебное заведение</label>
            <input
              v-model="education.stateUnivesity"
              type="text"
              placeholder="Название университета"
              class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 mb-2"
            />

            <label class="block text-gray-700">Факультет</label>
            <input
              v-model="education.faculty"
              type="text"
              placeholder="Факультет"
              class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 mb-2"
            />

            <label class="block text-gray-700">Специализация</label>
            <input
              v-model="education.specialization"
              type="text"
              placeholder="Специализация"
              class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 mb-2"
            />

            <label class="block text-gray-700">Год окончания</label>
            <input
              v-model="education.year_finish"
              type="text"
              placeholder="Год окончания"
              class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 mb-2"
            />

            <label class="block text-gray-700">Уровень образования</label>
            <select
              v-model="education.educationLevel"
              class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 mb-2"
            >
              <option value="school">Школа</option>
              <option value="colledge">Колледж</option>
              <option value="university">Университет</option>
            </select>

            <!-- Кнопка для удаления учебного заведения -->
            <button
              @click.prevent="removeEducation(index)"
              type="button"
              class="mt-2 bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-4 rounded"
            >
              Удалить образование
            </button>
          </div>

          <!-- Кнопка для добавления нового учебного заведения -->
          <button
            @click.prevent="addEducation"
            type="button"
            class="mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
          >
            Добавить образование
          </button>
        </div>

        <!-- Skills -->
        <div class="mb-4">
          <label class="block text-gray-700">Навыки</label>
          <textarea
            v-model="skillsString"
            placeholder="Введите навыки через запятую"
            class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          ></textarea>
        </div>

        <!-- About -->
        <div class="mb-4">
          <label class="block text-gray-700">О себе</label>
          <textarea
            v-model="resumeData.about"
            class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          ></textarea>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
          <button
            type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
          >
            Сохранить изменения
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const route = useRoute()
const router = useRouter()

const showStatus = ref('loading')

const resumeData = ref({})
const itemId = route.params.id

// Список навыков в строку для удобного редактирования
const skillsString = ref('')

// Загружаем данные резюме по ID
onMounted(() => {
  fetch(`http://localhost:8080/api/cvID?` + new URLSearchParams({ id: itemId }))
    .then((response) => {
      if (!response.ok) {
        throw new Error('Resume not found')
      }
      return response.json()
    })
    .then((data) => {
      if (!data) {
        throw new Error('Resume not found')
      }
      resumeData.value = data
      showStatus.value = 'completed'
    })
    .catch(() => {
      // Перенаправление на компонент ошибки
      showStatus.value = 'error'
      router.push('/error')
    })
})

// Функция для обновления данных резюме
function updateResume() {
  // Преобразуем строку навыков в массив объектов
  resumeData.value.skills = skillsString.value.split(',').map((skill) => ({ link: skill.trim() }))

  fetch(`http://localhost:8080/api/cv/${itemId}/edit`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(resumeData.value)
  }).then((response) => {
    if (response.ok) {
      alert('Резюме успешно обновлено')
    } else {
      alert('Ошибка обновления резюме')
    }
  })
}

// Функция для добавления нового элемента в список образования
function addEducation() {
  resumeData.value.educationList.push({
    stateUnivesity: '',
    faculty: '',
    specialization: '',
    year_finish: '',
    isVisibleUniversities: false,
    educationLevel: 'school'
  })
}

// Функция для удаления элемента из списка образования
function removeEducation(index) {
  resumeData.value.educationList.splice(index, 1)
}
</script>

<style scoped>
/* Animation for loading skeleton */
.skeleton-loading {
  background-image: linear-gradient(
    90deg,
    rgba(229, 231, 235, 1) 0%,
    rgba(243, 244, 246, 1) 50%,
    rgba(229, 231, 235, 1) 100%
  );
  background-size: 200% 100%;
  animation: skeleton-animation 1.5s infinite linear;
}

@keyframes skeleton-animation {
  0% {
    background-position: -200% 0;
  }
  100% {
    background-position: 200% 0;
  }
}
</style>
