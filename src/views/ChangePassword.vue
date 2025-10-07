<template>
  <div style="padding:28px;">
    <div style="max-width:720px; margin:auto; background:#fff; border-radius:4px; box-shadow:0 8px 32px rgba(42,44,86,0.10); padding:36px 28px;">
      <h3 style="margin-bottom:30px;font-size:20px;font-weight:bold;color:#283758;">Change Password</h3>
      <div style="max-width:580px;margin:auto;">
        <div style="margin-bottom:13px;">
          <label style="color:#6f7b99; font-weight:600; font-size:14px;">Current Password</label>
          <input v-model="currentPassword" type="password"
                style="width:100%;padding:8px 12px;margin-top:4px;border:1px solid #ccd4e4;border-radius:2.5px;" />
        </div>
        <div style="margin-bottom:13px;">
          <label style="color:#6f7b99; font-weight:600; font-size:14px;">New Password</label>
          <input v-model="newPassword" type="password"
                style="width:100%;padding:8px 12px;margin-top:4px;border:1px solid #ccd4e4;border-radius:2.5px;" />
        </div>
        <div style="margin-bottom:18px;">
          <label style="color:#6f7b99; font-weight:600; font-size:14px;">New Password Confirm</label>
          <input v-model="confirmPassword" type="password"
                style="width:100%;padding:8px 12px;margin-top:4px;border:1px solid #ccd4e4;border-radius:2.5px;" />
        </div>
        <button @click="handlePasswordUpdate"
          style="background:#635ada;color:#fff;border:none;padding:8px 32px;border-radius:3px;font-weight:600;font-size:14px;">
          Update Password
        </button>
        <div v-if="msg" :style="{color: msgOk ? '#28a745' : '#da2222', marginTop:'14px', fontWeight:'600'}">{{ msg }}</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { updatePassword, EmailAuthProvider, reauthenticateWithCredential } from 'firebase/auth'
import { auth } from '../firebase'

const currentPassword = ref('');
const newPassword = ref('');
const confirmPassword = ref('');
const msg = ref('');
const msgOk = ref(false);
const router = useRouter();

async function handlePasswordUpdate() {
  msg.value = '';
  msgOk.value = false;
  if (!currentPassword.value || !newPassword.value || !confirmPassword.value) {
    msg.value = 'Please fill all fields';
    return;
  }
  if (newPassword.value !== confirmPassword.value) {
    msg.value = 'New passwords do not match';
    return;
  }
  if (!auth.currentUser) {
    msg.value = 'Not logged in';
    return;
  }
  try {
    const credential = EmailAuthProvider.credential(auth.currentUser.email, currentPassword.value);
    await reauthenticateWithCredential(auth.currentUser, credential);
    await updatePassword(auth.currentUser, newPassword.value);
    msg.value = 'Password changed successfully!';
    msgOk.value = true;
    setTimeout(() => router.push('/admin/app/dashboard'), 2000);
  } catch (e) {
    msg.value = e.message || 'Error updating password';
  }
}
</script>

