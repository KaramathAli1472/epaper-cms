<template>
  <div id="app">
    <header style="display:flex;align-items:center;justify-content:space-between;background:#1bd2ff;padding:5px 18px;">
      <div style="display:flex;align-items:center;">
        <img src="@/assets/sadaehussaini.png" alt="Logo" style="height:32px; margin-right:10px; border-radius:5px;" />
        <span style="font-size:22px;font-weight:bold;color:#404040;">
          Epaper CMS Cloud
          <span style="font-size:16px;color:#404040;">/ Admin Panel</span>
        </span>
      </div>

      <div style="display:flex; align-items:center;">
        <button style="background:#1bd2ff;color:#404040;font-weight:600;border:none;padding:7px 16px;border-radius:4px;margin-right:8px;">
          <i class="fa fa-comments"></i> Submit Feedback
        </button>
        <!-- Only change this part for Welcome! user dropdown -->
        <div v-if="loggedIn" style="position:relative;display:flex;align-items:center;">
          <div @click="showDropdown = !showDropdown" style="position:relative;">
            <button style="background:#198be1;color:#fff;font-weight:600;border:none;padding:7px 18px 7px 14px;border-radius:4px;margin-right:8px;display:flex;align-items:center;gap:7px;font-size:15px;min-width:112px;">
              <i class="fa fa-user"></i>
              Welcome!
              <i class="fa fa-caret-down" style="font-size:13px;margin-left:6px;"></i>
            </button>
            <!-- Dropdown Menu -->
            <div v-show="showDropdown"
                 style="position:absolute;top:38px;right:0;background:#fff;border:1px solid #e0e6ed;box-shadow:0 8px 30px rgba(0,0,0,0.08);border-radius:4px;z-index:999;min-width:168px;">
              <div style="padding:10px 16px;border-bottom:1px solid #f3f3f3; font-weight:600;color:#198be1;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;">
                {{ username }}
              </div>
              <a href="/" target="_blank" style="display:block;padding:8px 16px; color:#222; text-decoration:none;">View Site</a>
              <a href="/sitemap.xml" target="_blank" style="display:block;padding:8px 16px; color:#222; text-decoration:none;">Sitemap</a>
              <a href="#" style="display:block;padding:8px 16px; color:#222; text-decoration:none;" @click.prevent="openChangePassword">
                Change Password
              </a>
              <a href="#" style="display:block;padding:8px 16px; color:#da2222; text-decoration:none;" @click.prevent="logout">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </header>

    <main>
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { onAuthStateChanged, signOut } from 'firebase/auth';
import { auth } from './firebase';

const router = useRouter();
const loggedIn = ref(false);
const username = ref('');
const showDropdown = ref(false);

onMounted(() => {
  onAuthStateChanged(auth, (user) => {
    if (user) {
      loggedIn.value = true;
      username.value = user.displayName || user.email;
      if (router.currentRoute.value.path === '/admin') {
        router.push('/admin/app/dashboard');
      }
    } else {
      loggedIn.value = false;
      username.value = '';
      if (router.currentRoute.value.path.startsWith('/admin/app')) {
        router.push('/admin');
      }
    }
  });
  // Hide on click out
  document.addEventListener('click', (e) => {
    const drop = document.querySelector('[data-user-dropdown]');
    if (showDropdown.value && drop && !drop.contains(e.target)) {
      showDropdown.value = false;
    }
  });
});

async function logout() {
  try {
    await signOut(auth);
    loggedIn.value = false;
    username.value = '';
    router.push('/admin');
  } catch (error) {
    alert('Logout failed: ' + error.message);
  }
}

// Only this function changed: opens change-password page
function openChangePassword() {
  router.push('/admin/app/change-password');
}
</script>

