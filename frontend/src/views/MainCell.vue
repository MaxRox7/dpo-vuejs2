<template>
  <div class="flex justify-center items-center min-h-screen">
    <!-- Loading Animation -->
    <div v-if="sceneStore.showStatus === 'loading'" class="flex items-center justify-center mt-32 loading-container" role="status">
      <div class="dot-container">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
      </div>
      <span class="sr-only">Загрузка...</span>
    </div>

    <!-- Main Content -->
    <div class="flex flex-wrap gap-6 mt-6" v-else-if="sceneStore.showStatus === 'complete'">
      <div v-for="(status, index) in sceneStore.statusList" :key="index" class="flex-1">
        <div :class="['status-card', getStatusClass(status), 'status-card']">
          <h3 class="text-lg font-semibold">{{ status }} ({{ sceneStore.statusCount[status] || 0 }})</h3>
          <draggable
            class="list-group"
            v-model="sceneStore.resume[status]"
            group="people"
            @change="sceneStore.updateStatus"
            itemKey="id"
          >
            <template #item="{ element }">
              <div class="list-group-item cursor-pointer">
                <div><strong>Имя:</strong> {{ element.name }}</div>
                <div><strong>Профессия:</strong> {{ element.profession }}</div>
                <div><strong>Кол-во лет:</strong> {{ element.age }}</div>
                <div class="flex items-center">
                  <strong>Фото:</strong>
                  <img :src="element.photo" class="ml-2 h-12 w-12 rounded-full" />
                </div>
                <button @click="$router.push(`/edit/${element.id}`)" class="edit-button">Редактировать</button>
              </div>
            </template>
          </draggable>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useSceneStore } from '@/stores/sceneStore'
import draggable from 'vuedraggable'

export default {
  name: 'two-lists',
  components: {
    draggable
  },
  setup() {
    const sceneStore = useSceneStore()
    onMounted(() => {
      sceneStore.fetchCandidates()
    })
    return {
      sceneStore
    }
  },
  methods: {
    getStatusClass(status) {
      const statusClasses = {
        'new': 'new',
        'accepted': 'accepted',
        'rejected': 'rejected',
        'in-progress': 'in-progress',
      }
      return statusClasses[status] || 'default';
    }
  }
}
</script>

<style scoped>
/* Flex container for page */
.flex {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  flex-wrap: wrap;
  padding: 20px;
}

/* Loading animation */
.dot-container {
  display: flex;
  justify-content: space-between;
  width: 60px;
}

.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: #9053c9a9;
  animation: dot-blink 1.5s infinite ease-in-out;
}

.dot:nth-child(1) {
  animation-delay: 0s;
}

.dot:nth-child(2) {
  animation-delay: 0.3s;
}

.dot:nth-child(3) {
  animation-delay: 0.6s;
}

@keyframes dot-blink {
  0%, 100% {
    opacity: 0;
  }
  50% {
    opacity: 1;
  }
}

/* Card container */
.status-card {
  background-color: #ffffff;
  border-radius: px;
  border: none;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin: 10px;
  transition: all 0.3s ease;
  min-width: 250px;
  max-width: 300px;
}

.status-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

/* Status-specific styles */
.status-card.new {
  background-color: #e0f7fa;
  border-left: 5px solid #00bcd4;
}

.status-card.accepted {
  background-color: #e8f5e9;
  border-left: 5px solid #4caf50;
}

.status-card.rejected {
  background-color: #ffebee;
  border-left: 5px solid #f44336;
}

.status-card.in-progress {
  background-color: #fff3e0;
  border-left: 5px solid #ff9800;
}

.status-card.default {
  background-color: #f0f0f0;
}

/* List group */
.list-group {
  border: 1px solid #ccc;
  border:none;
  padding: 10px;
  min-width: 250px;
  max-width: 300px;
  background-color: #f9f9f91c;
  border-radius: 8px;
}

/* List item */
.list-group-item {
  padding: 12px;
  border: 2px solid #6a5acd;
  margin: 8px 0;
  border-radius: 10px;
  background-color: #f8f9fa;
  transition: background-color 0.3s ease;
}

.list-group-item:hover {
  background-color: #e6f7ff;
}

/* Image styles */
img {
  object-fit: cover;
  border-radius: 50%;
}

/* Edit button */
.edit-button {
  background-color: #6a5acd;
  color: #fff;
  font-weight: bold;
  padding: 8px 16px;
  margin-top: 10px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
  cursor: pointer;
}

.edit-button:hover {
  background-color: #0056b3;
}
</style>
