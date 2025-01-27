<template>
  <div>
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
</template>

<script setup>
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue
} from '@/components/ui/select'
import { ref, computed } from 'vue'

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
</script>

<style lang="scss" scoped></style>
