<template>
  <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center space-x-4 mb-4">
      <img :src="photoUrl" alt="Фото" class="w-24 h-24 rounded-full object-cover" />
      <div>
        <h1 class="text-3xl font-bold">{{ fullName }}</h1>
        <p class="text-gray-600">{{ profession }}</p>
      </div>
    </div>
    <div class="mb-4">
      <p class="text-gray-700"><strong>Город:</strong> {{ city }}</p>
      <p class="text-gray-700"><strong>Телефон:</strong> {{ phone }}</p>
      <p class="text-gray-700"><strong>Email:</strong> {{ email }}</p>
      <p class="text-gray-700"><strong>Дата рождения:</strong> {{ birthDate }}</p>

      <div v-for="(edu, index) in educationList" :key="index" class="flex flex-col pl-4">
        <h1 class="text-red-600">
          <strong> Образование {{ index + 1 }}</strong>
        </h1>
        <p class="text-gray-700">
          <strong>Образование:</strong>
          {{ edu.educationLevel === 'colledge' ? 'Среднее специальное' : ''
          }}{{ edu.educationLevel === 'not_university' ? 'Неоконченное высшее' : ''
          }}{{ edu.educationLevel === 'university' ? 'Высшее' : '' }}
          {{ edu.educationLevel === 'school' ? 'Школа' : '' }}
        </p>

        <div v-if="edu.educationLevel !== 'school'" class="flex flex-col gap-2 pt-2">
          <p class="text-gray-600"><strong>Учебное заведение:</strong> {{ edu.stateUnivesity }}</p>
          <p class="text-gray-600"><strong>Факультет:</strong> {{ edu.faculty }}</p>
          <p class="text-gray-600"><strong>Специализация:</strong> {{ edu.specialization }}</p>
          <p class="text-gray-600"><strong>Год окончания:</strong> {{ edu.year_finish }}</p>
        </div>
      </div>

      <div v-for="(edu, index) in additionalEducation" :key="index" class="flex flex-col pt-2">
        <p class="text-gray-600">
          <strong>Ссылка на {{ index + 1 }} доп образование:</strong> {{ edu.link }}
        </p>
      </div>
      <p class="text-gray-700 mt-2"><strong>Желаемая зарплата:</strong> {{ desiredSalary }}</p>
    </div>
    <div class="mb-4">
      <h2 class="text-xl font-semibold mb-2">Ключевые навыки</h2>
      <p class="text-gray-700">{{ skills }}</p>
    </div>
    <div>
      <h2 class="text-xl font-semibold mb-2">О себе</h2>
      <p class="text-gray-700">{{ about }}</p>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  photoUrl: String,
  stateUnivesity: String,
  faculty: String,
  spec: String,
  year_finish: String,
  fullName: String,
  profession: String,
  city: String,
  phone: String,
  email: String,
  birthDate: String,
  educationLabel: String,
  education: String,
  desiredSalary: String,
  skills: String,
  about: String,
  additionalEducation: Array,
  university: String,
  educationList: Array
})
</script>

<style lang="scss" scoped></style>
