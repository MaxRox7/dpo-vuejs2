<template>
  <div class="grid grid-cols-1 gap-4 ">
    <!-- Поле для ввода профессии -->
    <div v-if="step === 1">

      <input
      v-model="fullName"
      type="text"
      placeholder="ФИО"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <input
      v-model="age"
      type="text"
      placeholder="Введите возраст"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <!-- Поле для ввода телефона с валидацией -->
    <input
      @input="hasInput = true"
      v-model="phone"
      type="text"
      placeholder="Телефон"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />
    <p v-if="!isPhoneValid && hasInput" class="text-red-600">
      Номер телефона должен содержать только цифры и быть длиной от 6 до 10 символов
    </p>

        <!-- Поле для ввода email -->
        <input
      @input="hasEmail = true"
      v-model="email"
      type="email"
      placeholder="Email"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />
    <p v-if="!isEmailValid && hasEmail" class="text-red-600">Введите корректный email</p>
    <!-- Поле для выбора даты рождения -->
    <input
      v-model="birthDate"
      type="date"
      placeholder="Дата рождения"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <input
      v-model="photoUrl"
      type="text"
      placeholder="Ссылка на фото"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

  </div>
  <div v-if="step === 2">
    <input
      v-model="profession"
      type="text"
      placeholder="Профессия"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <input
      v-model="desiredSalary"
      type="text"
      placeholder="Желаемая зарплата"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <!-- Поле для поиска города -->
    <div class="relative flex flex-col">
      <input
        v-model="searchQuery"
        type="text"
        :placeholder="searchQuery || 'Введите город'"
        class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
      />

      <select
        @change="handleSelectCity"
        v-if="isCityListVisible"
        id="cities"
        size="5"
        class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
      >
        <option v-if="cities.length === 0" disabled>Ничего не найдено</option>
        <option
          v-for="city in cities"
          :key="city.id"
          :value="city.id"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
        >
          {{ city.title }}
        </option>
      </select>
    </div>
  </div>

    <!-- Выпадающий список для выбора уровня образования -->
    <div v-if="step === 3">
    <!-- Поля для ввода учебного заведения и специальности -->
    <div>
      <div v-if="isVisibleEducation">
        <div v-for="(edu, index) in educationList" :key="index" class="flex flex-col gap-4 mt-4">
          <!-- Выпадающий список для выбора уровня образования -->
          <Select v-model="edu.educationLevel">
            <!-- Привязка к educationList -->
            <SelectTrigger>
              <SelectValue placeholder="Образование" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectLabel>Варианты уровней образования</SelectLabel>
                <SelectItem value="school"> Среднее </SelectItem>
                <SelectItem value="colledge"> Среднее специальное </SelectItem>
                <SelectItem value="not_university"> Неоконченное высшее </SelectItem>
                <SelectItem value="university"> Высшее </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>

          <div
            v-if="
              edu.educationLevel === 'university' ||
              edu.educationLevel === 'not_university' ||
              edu.educationLevel === 'colledge'
            "
            class="flex flex-col gap-4"
          >
            <div class="relative flex flex-col">
              <input
                v-model="edu.stateUnivesity"
                type="text"
                :placeholder="'Учебное заведение ' + (index + 1)"
                class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
                @input="fetchUniversities(index)"
              />
              <select
                @change="handleSelectUniversity(index, $event)"
                v-if="edu.isVisibleUniversities"
                size="5"
                class="bg-gray-50 border z-10 top-4 border-gray-300 text-gray-900 text-sm rounded-lg"
              >
                <option v-if="edu.universities.length === 0" disabled>Ничего не найдено</option>
                <option v-for="univers in edu.universities" :key="univers.id">
                  {{ univers.title }}
                </option>
              </select>
            </div>
            <!-- Поля для ввода факультета, специальности, года окончания -->
            <input
              v-model="edu.faculty"
              type="text"
              placeholder="Факультет"
              class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
            />
            <input
              v-model="edu.specialization"
              type="text"
              placeholder="Специализация"
              class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
            />
            <input
              v-model="edu.year_finish"
              type="text"
              placeholder="Год окончания"
              class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
            />
          </div>
          <!-- Поле для ввода учебного заведения -->

          <!-- Кнопка для удаления блока -->
          <button
            @click="removeEducationBlock(index)"
            class="bg-red-500 text-white px-4 py-2 rounded mt-2"
          >
            Удалить
          </button>
        </div>
      </div>
    </div>

    <button @click="addEducationBlock" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
      Добавить образование
    </button>

    <!-- Поле для ввода желаемой зарплаты -->

  </div>

  <div v-if="step === 4">
    <!-- Поле для ввода ключевых навыков -->
    <textarea
      v-model="skills"
      placeholder="Ключевые навыки"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    ></textarea>

    <!-- Поле для ввода информации о себе -->
    <textarea
      v-model="about"
      placeholder="О себе"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    ></textarea>

    <Select v-model="status">
      <SelectTrigger>
        <SelectValue placeholder="" />
      </SelectTrigger>
      <SelectContent>
        <SelectGroup>
          <SelectItem class="text-blue-600" value="Новый"> Новый </SelectItem>
          <SelectItem class="text-orange-600" value="Назначено собеседование">
            Назначено собеседование
          </SelectItem>
          <SelectItem class="text-green-600" value="Принят">Принят</SelectItem>
          <SelectItem class="text-red-600" value="Отказ"> Отказ </SelectItem>
        </SelectGroup>
      </SelectContent>
    </Select>
  </div>

    <!-- Кнопка для применения данных -->
    <button
    v-if="step === 4"
    @click="applyData" class="bg-green-500 text-white px-4 py-2 rounded mt-4">
      Применить
    </button>
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
        class="bg-[#ff7f50] text-white px-4 py-2 rounded"
      >
        Далее
      </button>
    </div>



</template>

<script setup>
import { ref, computed, watch, defineEmits } from 'vue'
import StatusResume from '../components/StatusResume.vue'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue
} from '@/components/ui/select'


const step = ref(1)

const nextStep = () => {
  if (step.value < 4) step.value++
}
const prevStep = () => {
  if (step.value > 1) step.value--
}
const age = ref('')
const profession = ref('')
const photoUrl = ref('')
const fullName = ref('')
const email = ref('')
const birthDate = ref('')
const education = ref('')
const desiredSalary = ref('')
const skills = ref('')
const about = ref('')
const hasInput = ref(false)
const hasEmail = ref(false)
const phone = ref('')
const regexPhone = /^\d{6,10}$/
const regexEmail = /^\S+@\S+\.\S+$/
const isPhoneValid = computed(() => regexPhone.test(phone.value))
const isEmailValid = computed(() => regexEmail.test(email.value))
const isApply = ref(false)
const emit = defineEmits(['submit'])
const isCityListVisible = ref(false)

const isVisibleEducation = ref(false)

const status = ref('Новый')

const statusComputed = computed(() => {
  const labels = {
    new: 'Новый',
    interview: 'Назначено собеседование',
    complete: 'Принят',
    denied: 'Отказ'
  }
  return labels[status.value] || 'Новый'
})

const applyData = () => {
  isApply.value = true
  const formData = {
    profession: profession.value,
    age: age.value,
    status: status.value,
    city: searchQuery.value,
    photoUrl: photoUrl.value,
    fullName: fullName.value,
    phone: phone.value,
    email: email.value,
    birthDate: birthDate.value,
    education: education.value,
    desiredSalary: desiredSalary.value,
    skills: skills.value,
    about: about.value,
    additionalEducation: additionalEducation.value,
    educationList: educationList.value // Добавляем список образований
  }
  emit('submit', formData)
}

// Логика для добавления и удаления дополнительного образования
const additionalEducation = ref([])

const addEducation = () => {
  additionalEducation.value.push({ link: '' })
}

const removeEducation = (index) => {
  additionalEducation.value.splice(index, 1)
}

// Логика для динамического добавления образования
const educationList = ref([])

const addEducationBlock = () => {
  isVisibleEducation.value = true
  educationList.value.push({
    stateUnivesity: '',
    faculty: '',
    specialization: '',
    year_finish: '',
    isVisibleUniversities: false
  })
}

const removeEducationBlock = (index) => {
  educationList.value.splice(index, 1)
}

// Логика для поиска городов
const searchQuery = ref('')
const cities = ref([])
const selectedCity = ref(null)
const isVisible = computed(
  () => isCityListVisible.value && searchQuery.value.trim() !== '' && cities.value.length > 0
)

watch(searchQuery, (newValue) => {
  if (newValue.trim() !== '') {
    fetchCities()
    isCityListVisible.value = true // показать выпадающий список при вводе текста
  } else {
    cities.value = []
    isCityListVisible.value = false // скрыть список, если строка пуста
  }
})

const fetchCities = () => {
  const params = new URLSearchParams({
    v: '5.81',
    country_id: '1',
    region_id: '0',
    offset: '0',
    need_all: '0',
    count: '10',
    q: searchQuery.value
  })

  fetch(`api/method/database.getCities?${params}`, { headers })
    .then((response) => response.json())
    .then((data) => {
      cities.value = data.response.items
    })
    .catch((error) => {
      console.error('Ошибка при получении данных:', error)
    })
}

const handleSelectCity = (event) => {
  selectedCity.value = event.target.value
  searchQuery.value = event.target.options[event.target.selectedIndex].text
  isCityListVisible.value = false // скрыть выпадающий список
  cities.value = []
}

// Логика для поиска университетов
const headers = { Authorization: `Bearer ${import.meta.env.VITE_KEY_NAME}` }

const fetchUniversities = (index) => {
  const stateUniversity = educationList.value[index].stateUnivesity
  const params = new URLSearchParams({
    v: '5.81',
    q: stateUniversity,
    city_id: selectedCity.value,
    count: '10'
  })

  fetch(`api/method/database.getUniversities?${params}`, { headers })
    .then((response) => response.json())
    .then((data) => {
      educationList.value[index].universities = data.response.items
      educationList.value[index].isVisibleUniversities =
        stateUniversity.trim() !== '' && data.response.items.length > 0
    })
    .catch((error) => {
      console.error('Ошибка при получении данных:', error)
      educationList.value[index].universities = []
      educationList.value[index].isVisibleUniversities = false
    })
}

// Обработка выбора университета
const handleSelectUniversity = (index, event) => {
  const selectedUniversity = event.target.value
  educationList.value[index].stateUnivesity = selectedUniversity
  educationList.value[index].isVisibleUniversities = false
}
</script>

<style>
/* Основной стиль для элементов ввода */
input,
textarea,
select {
  border: 1px solid #e5e7eb; /* Светло-серая рамка */
  padding: 12px; /* Внутренний отступ */
  border-radius: 8px; /* Закругленные углы */
  width: 100%; /* Ширина на всю строку */
  font-size: 14px; /* Размер шрифта */
  font-family: 'Arial', sans-serif; /* Основной шрифт */
  transition: border-color 0.3s, box-shadow 0.3s; /* Плавные переходы */
}

/* Фокусное состояние */
input:focus,
textarea:focus,
select:focus {
  border-color: #3b82f6; /* Синий цвет рамки */
  box-shadow: 0 0 0 2px #bfdbfe; /* Подсветка */
  outline: none; /* Убираем стандартный фокус */
}

/* Стиль для кнопок */
button {
  padding: 10px 20px; /* Отступы */
  border: none; /* Убираем границу */
  border-radius: 8px; /* Закругленные углы */
  font-size: 14px; /* Размер шрифта */
  font-weight: bold; /* Жирный шрифт */
  cursor: pointer; /* Указатель при наведении */
  transition: background-color 0.3s, transform 0.2s; /* Плавные переходы */
}

button:hover {
  transform: scale(1.05); /* Легкое увеличение при наведении */
}

button:active {
  transform: scale(0.95); /* Легкое уменьшение при нажатии */
}

button.bg-blue-500 {
  background-color: #3b82f6; /* Синий фон */
  color: white; /* Белый текст */
}

button.bg-blue-500:hover {
  background-color: #2563eb; /* Темно-синий при наведении */
}

button.bg-gray-500 {
  background-color: #6b7280; /* Серый фон */
  color: white; /* Белый текст */
}

button.bg-gray-500:hover {
  background-color: #4b5563; /* Темно-серый при наведении */
}

button.bg-green-500 {
  background-color: #10b981; /* Зеленый фон */
  color: white; /* Белый текст */
}

button.bg-green-500:hover {
  background-color: #059669; /* Темно-зеленый при наведении */
}

button.bg-red-500 {
  background-color: #ef4444; /* Красный фон */
  color: white; /* Белый текст */
}

button.bg-red-500:hover {
  background-color: #dc2626; /* Темно-красный при наведении */
}

/* Ошибки */
.text-red-600 {
  color: #dc2626; /* Красный цвет текста */
  font-size: 12px; /* Размер шрифта */
  margin-top: 4px; /* Отступ сверху */
}

/* Стили для выпадающего списка */
select {
  appearance: none; /* Убираем стандартный стиль браузера */
  background: #f9fafb; /* Светлый фон */
  font-size: 14px; /* Размер шрифта */
}

select option {
  padding: 8px; /* Отступы внутри */
  font-size: 14px; /* Размер шрифта */
}

/* Обертка для flex-элементов */
.flex {
  display: flex; /* Включаем flex */
  gap: 8px; /* Пробелы между элементами */
}

.flex-col {
  flex-direction: column; /* Колонка */
}

/* Сетка */
.grid {
  display: grid; /* Включаем грид */
  gap: 16px; /* Пробелы между строками */
}

.grid-cols-1 {
  grid-template-columns: 1fr; /* Одна колонка */
}




</style>