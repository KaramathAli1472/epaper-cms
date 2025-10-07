<template>
  <div class="epaper">
    <h2>📰 E-Paper Management</h2>

    <p>Yahan aap apne E-Paper PDF upload kar sakte hain.</p>

    <div class="upload-box">
      <input type="file" @change="uploadFile" accept="application/pdf" />
      <p v-if="uploading">Uploading... {{ progress }}%</p>
      <p v-if="url">✅ Uploaded successfully: <a :href="url" target="_blank">View PDF</a></p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { storage } from '../firebase'
import { ref as sRef, uploadBytesResumable, getDownloadURL } from 'firebase/storage'

const uploading = ref(false)
const progress = ref(0)
const url = ref('')

const uploadFile = (e) => {
  const file = e.target.files[0]
  if (!file) return
  const fileRef = sRef(storage, `epapers/${file.name}`)
  const task = uploadBytesResumable(fileRef, file)
  uploading.value = true

  task.on('state_changed',
    (snapshot) => {
      progress.value = Math.round((snapshot.bytesTransferred / snapshot.totalBytes) * 100)
    },
    (error) => {
      console.error(error)
      uploading.value = false
    },
    async () => {
      url.value = await getDownloadURL(task.snapshot.ref)
      uploading.value = false
    }
  )
}
</script>

<style scoped>
.epaper {
  text-align: center;
  padding: 20px;
}
.upload-box {
  margin-top: 20px;
  background: #f4f4f4;
  padding: 20px;
  border-radius: 12px;
}
input[type="file"] {
  padding: 10px;
}
</style>

