import { defineStore } from 'pinia'
import { ref, watch } from 'vue'

export const useSceneStore = defineStore('scene', () => {
  const candidates = ref([])
  const resume = ref({
    Новый: [],
    Принят: [],
    'Назначено собеседование': [],
    Отказ: []
  })
  const statusList = ref(['Новый', 'Принят', 'Назначено собеседование', 'Отказ'])
  const showStatus = ref('loading')

  const statusCount = ref({})

  async function fetchCandidates() {
    showStatus.value = 'loading'
    try {
      const response = await fetch('http://localhost:8080/api/cv')
      if (!response.ok) {
        throw new Error('Network response was not ok')
      }
      const data = await response.json()
      candidates.value = data

      // Filter data by status after loading

      resume.value['Новый'] = candidates.value.filter((item) => item.status === 'Новый')
      resume.value['Принят'] = candidates.value.filter((item) => item.status === 'Принят')
      resume.value['Назначено собеседование'] = candidates.value.filter(
        (item) => item.status === 'Назначено собеседование'
      )
      resume.value['Отказ'] = candidates.value.filter((item) => item.status === 'Отказ')

      showStatus.value = 'complete'
    } catch (error) {
      console.error('Ошибка загрузки данных:', error)
      showStatus.value = 'failed'
    }
  }

  function updateStatus(evt) {
    const { added } = evt

    if (added) {
      const movedCandidate = added.element // Get moved element
      const newStatus = statusList.value.find((status) =>
        resume.value[status].includes(movedCandidate)
      ) // Determine new status

      // Update candidate status
      movedCandidate.status = newStatus // Set new status

      // Send request to update status on the server
      fetch(`http://localhost:8080/api/cv/${movedCandidate.id}/status/update`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status: newStatus }) // Use new status
      })
        .then((response) => {
          if (!response.ok) {
            console.error('Ошибка при обновлении статуса')
          } else {
            console.log(`Статус кандидата '${movedCandidate.name}' обновлен на '${newStatus}'`)
          }
        })
        .catch((error) => {
          console.error('Ошибка при отправке запроса:', error)
        })
    }
  }

  watch(
    resume,
    (newValue) => {
      statusCount.value = {}
      for (const status of statusList.value) {
        statusCount.value[status] = newValue[status].length // Count candidates per status
      }
    },
    { deep: true }
  )

  return {
    candidates,
    resume,
    statusList,
    showStatus,
    statusCount,
    fetchCandidates,
    updateStatus
  }
})
