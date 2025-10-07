<template>
  <div style="display:flex; min-height:100vh; font-family:'Arial',sans-serif;">
    <!-- Sidebar -->
    <aside style="width:240px; background:#2f3e56; color:#fff; padding:0; font-size:16px;">
      <nav>
        <ul style="list-style:none; padding:18px 12px 0 12px; margin:0; display:flex; flex-direction:column; gap:2px;">
          <li v-for="item in menu" :key="item.text" style="position:relative;">
            <!-- Epaper sub-menu -->
            <div v-if="item.text === 'Epaper'">
              <button @click="epaperOpen = !epaperOpen"
                style="display:flex;align-items:center;gap:12px; color:#fff; text-decoration:none; padding:14px 18px; font-weight:600;
                  background:#32435a; border-radius:7px; box-shadow:0 2px 8px rgba(0,0,0,0.013); border:1px solid #3a4b62; width:100%;transition:background 0.15s; cursor:pointer;">
                <span style="font-size:19px; width:22px; display:inline-flex; align-items:center; justify-content:center;">
                  <i :class="item.icon"></i>
                </span>
                {{ item.text }}
                <span style="margin-left:auto; font-size:12px;">
                  <i class="fa fa-angle-down" :style="{transform: epaperOpen ? 'rotate(-180deg)' : ''}"></i>
                </span>
              </button>
              <ul v-show="epaperOpen"
                style="list-style:none; padding-left:0; margin:0; background:#465065; border-radius:0 0 7px 7px;">
                <li v-for="sub in epaperMenu" :key="sub.text">
                  <router-link :to="sub.link"
                    style="display:flex;align-items:center;gap:10px; color:#fff; text-decoration:none; padding:9px 32px 9px 36px; font-weight:600;">
                    <i :class="sub.icon"></i> {{ sub.text }}
                  </router-link>
                </li>
              </ul>
            </div>
            <!-- System dropdown -->
            <div v-else-if="item.text === 'System'">
              <button @click="systemOpen = !systemOpen"
                style="display:flex;align-items:center;gap:12px; color:#fff; text-decoration:none; padding:14px 18px; font-weight:600;
                  background:#32435a; border-radius:7px; box-shadow:0 2px 8px rgba(0,0,0,0.013); border:1px solid #3a4b62; width:100%;transition:background 0.15s; cursor:pointer;">
                <span style="font-size:19px; width:22px; display:inline-flex; align-items:center; justify-content:center;">
                  <i :class="item.icon"></i>
                </span>
                {{ item.text }}
                <span style="margin-left:auto; font-size:12px;">
                  <i class="fa fa-angle-down" :style="{transform: systemOpen ? 'rotate(-180deg)' : ''}"></i>
                </span>
              </button>
              <ul v-show="systemOpen"
                style="list-style:none; padding:6px 0 8px 0; margin:0; background:#495368; border-radius:0 0 7px 7px;">
                <li v-for="sub in systemMenu" :key="sub.text">
                  <router-link :to="sub.link"
                    style="display:flex;align-items:center;gap:10px; color:#fff; text-decoration:none; padding:9px 24px 9px 32px; font-size:15px;">
                    <i :class="sub.icon"></i> {{ sub.text }}
                  </router-link>
                </li>
              </ul>
            </div>
            <!-- Super Admin dropdown (like screenshot) -->
            <div v-else-if="item.text === 'Super Admin'">
              <button @click="superAdminOpen = !superAdminOpen"
                style="display:flex;align-items:center;gap:12px; color:#fff; text-decoration:none; padding:14px 18px; font-weight:600;
                  background:#32435a; border-radius:7px; box-shadow:0 2px 8px rgba(0,0,0,0.013); border:1px solid #3a4b62; width:100%;transition:background 0.15s; cursor:pointer;">
                <span style="font-size:19px; width:22px; display:inline-flex; align-items:center; justify-content:center;">
                  <i :class="item.icon"></i>
                </span>
                {{ item.text }}
                <span style="margin-left:auto; font-size:12px;">
                  <i class="fa fa-angle-down" :style="{transform: superAdminOpen ? 'rotate(-180deg)' : ''}"></i>
                </span>
              </button>
              <ul v-show="superAdminOpen"
                style="list-style:none; padding:6px 0 8px 0; margin:0; background:#495368; border-radius:0 0 7px 7px;">
                <li v-for="sub in superAdminMenu" :key="sub.text">
                  <router-link :to="sub.link"
                    style="display:flex;align-items:center;gap:10px; color:#fff; text-decoration:none; padding:9px 24px 9px 32px; font-size:15px;">
                    <i :class="sub.icon"></i> {{ sub.text }}
                  </router-link>
                </li>
              </ul>
            </div>
            <!-- Other direct link menu items -->
            <router-link
              v-else
              :to="item.link"
              style="display:flex;align-items:center;gap:12px; color:#fff; text-decoration:none; padding:14px 18px; font-weight:600;
                background:#32435a; border-radius:7px; box-shadow:0 2px 8px rgba(0,0,0,0.013); border:1px solid #3a4b62; transition:background 0.15s;">
                <span style="font-size:19px; width:22px; display:inline-flex; align-items:center; justify-content:center;">
                  <i :class="item.icon"></i>
                </span>
                {{ item.text }}
                <span v-if="item.hasDropdown && item.text !== 'Epaper' && item.text !== 'System' && item.text !== 'Super Admin'" style="margin-left:auto; font-size:12px;">
                  <i class="fa fa-angle-down"></i>
                </span>
            </router-link>
          </li>
        </ul>
      </nav>
    </aside>
    <main style="flex:1; background:#edf0f9;">
      <header style="background:#5568be; color:#fff; padding:20px 30px; font-size:22px; font-weight:bold; display:flex; justify-content:space-between; align-items:center;">
        <span>Welcome to Admin Dashboard</span>
        <div></div>
      </header>
      <section style="padding:30px;">
        <router-view />
      </section>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
const epaperOpen = ref(false);
const systemOpen = ref(false);
const superAdminOpen = ref(false);

const menu = [
  { text: 'Dashboard', icon: 'fa fa-home', link: '/admin/app/dashboard' },
  { text: 'Epaper', icon: 'fa fa-edit', link: '/admin/app/epaper', hasDropdown: true },
  { text: 'Page', icon: 'fa fa-file', link: '/admin/app/page' },
  { text: 'Slider', icon: 'fa fa-film', link: '/admin/app/slider' },
  { text: 'Media', icon: 'fa fa-picture-o', link: '/admin/app/media' },
  { text: 'Users', icon: 'fa fa-users', link: '/admin/app/users' },
  { text: 'System', icon: 'fa fa-cog', link: '#', hasDropdown: true },
  { text: 'Super Admin', icon: 'fa fa-fire', link: '#', hasDropdown: true },
]

const epaperMenu = [
  { text: 'Categories', icon: 'fa fa-sitemap', link: '/admin/app/epaper/categories' },
  { text: 'Edition', icon: 'fa fa-edit', link: '/admin/app/epaper/edition' },
  { text: 'Featured Categories', icon: 'fa fa-star', link: '/admin/app/epaper/featured-categories' },
  { text: 'Featured Editions', icon: 'fa fa-star', link: '/admin/app/epaper/featured-editions' },
  { text: 'Page Categories', icon: 'fa fa-sitemap', link: '/admin/app/epaper/page-categories' },
]
const systemMenu = [
  { text: 'Page Designer', icon: 'fa fa-pencil', link: '/admin/app/system/page-designer' },
  { text: 'Widget Shortcodes', icon: 'fa fa-code', link: '/admin/app/system/widget-shortcodes' },
  { text: 'Menus', icon: 'fa fa-list', link: '/admin/app/system/menus' },
  { text: 'Sitemap', icon: 'fa fa-sitemap', link: '/admin/app/system/sitemap' },
  { text: 'Settings', icon: 'fa fa-cog', link: '/admin/app/system/settings' },
]
const superAdminMenu = [
  { text: 'Settings', icon: 'fa fa-pencil', link: '/admin/app/super-admin/settings' },
  { text: 'Change Domain', icon: 'fa fa-globe', link: '/admin/app/super-admin/change-domain' },
]
</script>

<style>
aside ul li router-link:hover,
aside ul li router-link:focus {
  background: #354764 !important;
  box-shadow: 0 4px 16px rgba(0,0,0,0.05);
}
</style>

