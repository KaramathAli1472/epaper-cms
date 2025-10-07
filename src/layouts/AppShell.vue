<template>
  <div style="display:flex; min-height:100vh; font-family:'Arial',sans-serif;">
    <!-- Sidebar -->
    <aside style="width:240px; background:#2f3e56; color:#fff; padding:0; font-size:16px;">
      <nav>
        <ul style="list-style:none; padding:18px 12px 0 12px; margin:0; display:flex; flex-direction:column; gap:9px;">
          <li v-for="item in menu" :key="item.text">
            <router-link
              :to="item.link"
              style="display:flex;align-items:center;gap:12px; color:#fff; text-decoration:none; padding:14px 18px; font-weight:600;
                     background:#32435a; border-radius:7px; box-shadow:0 2px 8px rgba(0,0,0,0.013); border:1px solid #3a4b62; transition:background 0.15s;">
              <span style="font-size:19px; width:22px; display:inline-flex; align-items:center; justify-content:center;">
                <i :class="item.icon"></i>
              </span>
              {{ item.text }}
              <span v-if="item.hasDropdown" style="margin-left:auto; font-size:12px;"><i class="fa fa-angle-down"></i></span>
            </router-link>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Main content -->
    <main style="flex:1; background:#edf0f9;">
      <header style="background:#5568be; color:#fff; padding:20px 30px; font-size:22px; font-weight:bold; display:flex; justify-content:space-between; align-items:center;">
        <span>Welcome to Admin Dashboard</span>
        <div>
          <button style="margin-right:15px;" class="btn btn-info">Submit Feedback</button>
          <button class="btn btn-light">Welcome!</button>
        </div>
      </header>

      <section style="padding:30px;">
        <router-view />
      </section>
    </main>
  </div>
</template>

<script setup>
const menu = [
  { text: 'Dashboard', icon: 'fa fa-home', link: '/admin/app/dashboard' },
  { text: 'Epaper', icon: 'fa fa-edit', link: '/admin/app/epaper', hasDropdown: true },
  { text: 'Page', icon: 'fa fa-file', link: '#' },
  { text: 'Slider', icon: 'fa fa-film', link: '#' },
  { text: 'Media', icon: 'fa fa-picture-o', link: '#' },
  { text: 'Users', icon: 'fa fa-users', link: '#' },
  { text: 'System', icon: 'fa fa-cog', link: '#', hasDropdown: true },
  { text: 'Super Admin', icon: 'fa fa-fire', link: '#', hasDropdown: true },
]
</script>

<style>
/* Card/tile hover effect */
aside ul li router-link:hover,
aside ul li router-link:focus {
  background: #354764 !important;
  box-shadow: 0 4px 16px rgba(0,0,0,0.05);
}
</style>

