<template>
  <div style="padding:25px 18px;">
    <div style="font-size:22px; font-weight:700; margin-bottom:22px;">
      Edit Category
    </div>
    <form @submit.prevent="onSave" style="display:flex; gap:28px; align-items:flex-start; flex-wrap:wrap;">
      <!-- LEFT COLUMN -->
      <div style="flex:2; min-width:410px;">
        <label style="display:block; font-weight:600; margin-bottom:6px;">Category Title</label>
        <input v-model="form.title" type="text" required style="width:100%;padding:9px 8px;border-radius:3px;border:1px solid #bbb;margin-bottom:13px;"/>

        <label style="display:block; font-weight:600; margin-bottom:6px;">Alias</label>
        <div style="display:flex;gap:6px;align-items:center;">
          <input v-model="form.alias" type="text" required style="width:100%;padding:9px 8px;border-radius:3px;border:1px solid #bbb;"/>
          <button type="button" @click="generateAlias" style="background:#5867d8;border:none;color:#fff;padding:0 12px;font-size:17px;border-radius:3px;">
            <i class="fa fa-refresh"></i>
          </button>
        </div>

        <label style="display:block; font-weight:600; margin:16px 0 6px;">Description</label>
        <textarea v-model="form.desc" style="width:100%;min-height:42px;padding:9px 8px;border-radius:3px;border:1px solid #bbb;margin-bottom:13px;"></textarea>

        <label style="display:block; font-weight:600; margin-bottom:6px;">Parent Category</label>
        <select v-model="form.parent" style="width:100%;padding:8px 7px;border-radius:3px;border:1px solid #bbb;">
          <option value="">--None--</option>
          <option value="1">Category A</option>
          <option value="2">Category B</option>
        </select>

        <!-- IMAGE UPLOAD + DELETE -->
        <div style="margin-top:22px; display:flex; gap:22px; align-items:flex-start; flex-direction:row;">
          <div style="display:flex; flex-direction:column; gap:8px;">
            <div style="font-weight:600; margin-bottom:3px;">Image</div>
            <label style="display:block; cursor:pointer;">
              <img 
                :src="previewUrl || placeHolder" 
                @click="triggerFileInput" 
                style="width:140px; height:130px; object-fit:cover; border:1px solid #bbb; border-radius:4px; background:#f5f4f5; display:block; cursor:pointer;" 
              />
              <input ref="fileInput" type="file" @change="onImgUpload" accept="image/*" style="display:none;">
            </label>
            <button 
              type="button" 
              @click="triggerFileInput" 
              style="background:#5867d8; color:#fff; padding:4px 18px; border:none; border-radius:3px; margin-top:4px;"
            >
              Upload Image
            </button>
            <div>
              <input type="checkbox" v-model="deleteImage" id="deleteImage"/>
              <label for="deleteImage" style="margin-left:7px; font-weight:400; font-size:14px;">Delete Image</label>
            </div>
          </div>
        </div>

        <button type="button" @click="onBack"
          style="margin-top:38px;background:#8794a1;color:#fff;border:none;font-size:15px;padding:9px 33px;border-radius:3px;display:inline-flex;align-items:center;gap:8px;font-weight:600;">
          <i class="fa fa-arrow-left"></i> Back
        </button>
      </div>

      <!-- RIGHT COLUMN: SEO -->
      <div style="flex:2; min-width:450px;">
        <div style="background:#f6fbff;border:2px solid #1784e0; border-radius:4px;">
          <div style="background:#1784e0;color:#fff;padding:8px 11px;font-weight:600;">Search Engine Optimization</div>
          <div style="padding:13px 16px;">
            <div v-if="activeTab==='Basic'">
              <label style="font-weight:600;margin-bottom:4px;">Custom Title</label>
              <input v-model="seo.title" type="text" style="width:100%;padding:8px;border-radius:3px;border:1px solid #bbb;margin-bottom:7px;">
              <div style="font-size:12px;font-style:italic;margin-bottom:7px;color:#777;">
                This title will be used in &lt;title&gt; tag
              </div>
              <label style="font-weight:600;margin-bottom:4px;">Meta Description</label>
              <textarea v-model="seo.desc" style="width:100%;min-height:32px;resize:vertical;padding:6px 8px;border-radius:3px;border:1px solid #bbb;margin-bottom:7px;"></textarea>
              <label style="font-weight:600;margin-bottom:4px;">Meta Keywords</label>
              <textarea v-model="seo.keywords" style="width:100%;min-height:32px;resize:vertical;padding:6px 8px;border-radius:3px;border:1px solid #bbb;margin-bottom:7px;"></textarea>
              <label style="font-weight:600;margin-bottom:4px;">Robots</label>
              <input v-model="seo.robots" style="width:100%;padding:8px;border-radius:3px;border:1px solid #bbb;margin-bottom:7px;">
            </div>
          </div>
        </div>
      </div>
    </form>

    <div style="margin-top:28px;text-align:right;">
      <button type="submit" @click="onSave"
        style="background:#5867d8;color:#fff;border:none;font-size:17px;border-radius:3px;font-weight:600;padding:9px 44px;">
        Save
      </button>
    </div>

    <div v-if="msg" style="color:green;font-weight:bold;margin-top:30px;">{{ msg }}</div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { db, storage } from '../../firebase.js'
import { collection, addDoc } from 'firebase/firestore'
import { ref as storageRef, uploadBytes, getDownloadURL } from 'firebase/storage'

const router = useRouter()

const form = ref({ title:"", alias:"", desc:"", parent:"" })
const fileInput = ref(null)
const previewUrl = ref("")
const placeHolder = "https://placehold.co/140x130/cccccc/888888.png?text=%E2%80%93"
const deleteImage = ref(false)
const activeTab = ref('Basic')
const seo = ref({ title:'', desc:'', keywords:'', robots:'' })
const msg = ref("")

let manualAlias = false
watch(() => form.value.title, (newVal) => {
  if (!manualAlias) {
    form.value.alias = newVal.trim().toLowerCase().replace(/\s+/g,'-').replace(/[^a-z0-9-]/g,'')
  }
})

function generateAlias() {
  form.value.alias = form.value.title.trim().toLowerCase().replace(/\s+/g,'-').replace(/[^a-z0-9-]/g,'')
  manualAlias = true
}

function triggerFileInput() { if(fileInput.value) fileInput.value.click() }

function onImgUpload(e){
  const file = e.target.files[0]
  if(file){
    previewUrl.value = URL.createObjectURL(file)
    form.value.imageFile = file
  }
}

function onBack(){
  router.push({ name: 'CategoryManager' }) // Correct back navigation
}

async function onSave() {
  if(!form.value.title || !form.value.alias){
    msg.value = "Required fields missing"
    return
  }

  let imageUrl = ""
  if(form.value.imageFile){
    const imgRef = storageRef(storage, `categories/${Date.now()}_${form.value.imageFile.name}`)
    await uploadBytes(imgRef, form.value.imageFile)
    imageUrl = await getDownloadURL(imgRef)
  }

  const categoryData = {
    title: form.value.title,
    alias: form.value.alias,
    desc: form.value.desc,
    parent: form.value.parent,
    seo: { ...seo.value },
    image: imageUrl
  }

  // Firebase Firestore save
  try {
    await addDoc(collection(db, "categories"), categoryData)
    msg.value = "Category saved successfully!"
    setTimeout(() => {
      msg.value = ""
      router.push({ name: 'CategoryManager' }) // Redirect after save
    }, 1000)
  } catch(err){
    console.error(err)
    msg.value = "Error saving category"
  }

  // Reset form
  form.value = { title:"", alias:"", desc:"", parent:"" }
  previewUrl.value = ""
  deleteImage.value = false
  seo.value = { title:'', desc:'', keywords:'', robots:'' }
  manualAlias = false
}
</script>

<style>
body, html { background: #f0f1f9; }
</style>

