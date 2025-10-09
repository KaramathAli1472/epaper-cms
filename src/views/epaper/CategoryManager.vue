<template>
  <div>
    <div style="font-size:22px; font-weight:600; margin-bottom:22px;">Category Manager</div>

    <button @click="onNewCategory" 
      style="background:#5867d8; color:#fff; border:none; font-size:15px; border-radius:3px; padding:7px 22px; font-weight:600;">
      New Category
    </button>

    <div v-if="categories.length === 0" style="margin-top:20px; font-size:14px; color:#777;">
      No categories found.
    </div>

    <div style="background:#fff; border-radius:6px; box-shadow:0 2px 10px rgba(44,62,80,0.04); padding:20px 14px; margin-top:20px;">
      <div
        v-for="cat in categories"
        :key="cat.id"
        style="margin-bottom:18px; border:1px solid #bbc7e1; border-radius:3px; overflow:hidden; display:flex; align-items:center; justify-content: space-between;">
        
        <div style="padding:6px 12px;">
          {{ cat.title }}
        </div>

        <div style="padding:6px 12px; display:flex; gap:7px;">
          <button @click="onEdit(cat.id)" style="background:#3fa55a; color:#fff; border:none; padding:4px 8px; border-radius:3px;">
            <i class="fa fa-pencil"></i>
          </button>
          <button @click="onDelete(cat.id)" style="background:#fa4655; color:#fff; border:none; padding:4px 8px; border-radius:3px;">
            <i class="fa fa-trash"></i>
          </button>
          <button @click="togglePlus(cat.id)"
            :style="'background:#fff; color:#222; border:none; padding:4px 12px; border-radius:3px; font-size:20px; font-weight:700;'">
            {{ plusState[cat.id] ? '−' : '+' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { db } from '../../firebase.js'
import { collection, getDocs, deleteDoc, doc } from 'firebase/firestore'

const router = useRouter()
const categories = ref([])
const plusState = ref({})

// Fetch categories from Firestore
async function fetchCategories() {
  const querySnapshot = await getDocs(collection(db, "categories"))
  categories.value = querySnapshot.docs.map(docSnap => ({ id: docSnap.id, ...docSnap.data() }))
  // Initialize plus/minus state for new list
  plusState.value = {}
  categories.value.forEach(cat => {
    plusState.value[cat.id] = false
  })
}

// Navigate to new category form
function onNewCategory() {
  router.push({ name: 'CategoryCreate' })
}

// Edit category
function onEdit(catId) {
  router.push({ name: 'CategoryCreate', query: { id: catId } })
}

// Delete category
async function onDelete(catId) {
  if(confirm("Are you sure you want to delete this category?")) {
    await deleteDoc(doc(db, "categories", catId))
    fetchCategories() // Refresh list after delete
  }
}

// Toggle plus/minus for a category
function togglePlus(catId) {
  plusState.value[catId] = !plusState.value[catId]
  // You can put custom logic here for [+] and [−] if needed e.g. open/close children etc.
}

onMounted(() => {
  fetchCategories()
})
</script>

<style>
body, html { background: #f0f1f9; }
</style>

