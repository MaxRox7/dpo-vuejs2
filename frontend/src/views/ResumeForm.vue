<template>
  <div class="min-h-screen p-8">
    <!-- Форма для заполнения данных -->
    <div class="max-w-3xl mx-auto mb-10">
      <div class="flex justify-between">
        <h2 class="text-2xl font-semibold mb-6">Введите данные для резюме</h2>
      </div>
      <ResumeComponent @submit="handleFormSubmit" />
    </div>
    <!-- Шаблон резюме -->
    <ResumeForm
      v-if="isSubmitted"
      :university="resumeData.university"
      :isApply="resumeData.isApply"
      :photoUrl="resumeData.photoUrl"
      :phone="resumeData.phone"
      :profession="resumeData.profession"
      :city="resumeData.city"
      :fullName="resumeData.fullName"
      :email="resumeData.email"
      :birthDate="resumeData.birthDate"
      :education="resumeData.education"
      :desiredSalary="resumeData.desiredSalary"
      :skills="resumeData.skills"
      :about="resumeData.about"
      :stateUnivesity="resumeData.selectedUniversity"
      :faculty="resumeData.faculty"
      :spec="resumeData.spec"
      :year_finish="resumeData.year_finish"
      :isUniversity="resumeData.isUniversity"
      :educationLabel="resumeData.educationLabel"
      :additionalEducation="resumeData.additionalEducation"
      :educationList="resumeData.educationList"
      class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md"
    />
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import Button from '@/components/ui/button/Button.vue'

import { useRouter, useRoute } from 'vue-router'
import ResumeForm from '../components/FormStudy.vue'

import ResumeComponent from '@/components/ResumeComponent.vue'

// логика для отправки формы
const isSubmitted = ref(false)
const resumeData = ref({})
const isApply = ref(false)
const handleFormSubmit = (formData) => {
  resumeData.value = { ...formData }
  isSubmitted.value = true
}

const transformResumeData = (data) => {
  return {
    name: data.fullName,
    profession: data.profession,
    age: Number(data.age), // Заполните возраст, если он есть, иначе оставьте пустым
    status: data.status, // Задайте статус, если необходимо
    photo: data.photoUrl,
    city: data.city,
    phone: data.phone,
    email: data.email,
    birthDate: data.birthDate,
    education: '',
    desiredSalary: Number(data.desiredSalary),
    skills: data.additionalEducation,
    about: data.about,
    additionalEducation: [],
    educationList: data.educationList
  }
}

// Роутинг

// по кнопке применить отправляем данные на сервер
watch(isSubmitted, async (newValue) => {
  console.log(newValue)

  const transformedData = transformResumeData(resumeData.value)

  const response = await fetch('http://localhost:8080/api/cv/add', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(transformedData)
  })

  const data = await response.json()

  console.log(data)
})

console.log(isSubmitted.value)

const router = useRouter()

const goToMain = () => {
  router.push('/')
}
</script>

<style lang="scss" scoped></style>
