import { createRouter, createWebHistory } from 'vue-router';
import { getAuth } from 'firebase/auth';

// Components
import AdminLogin from './components/AdminLogin.vue';
import AdminDashboard from './components/AdminDashboard.vue';
import AppShell from './layouts/AppShell.vue';
import ReaderView from './components/ReaderView.vue';
import EpaperView from './views/EpaperView.vue'; // optional epaper page
import ChangePassword from './views/ChangePassword.vue'; // 👈 import karo

const routes = [
  {
    path: '/',
    name: 'reader',
    component: ReaderView
  },
  {
    path: '/admin',
    name: 'admin-login',
    component: AdminLogin
  },
  {
    path: '/admin/app',
    component: AppShell,
    meta: { requiresAuth: true }, // ✅ protect admin routes
    children: [
      {
        path: 'dashboard',
        name: 'admin-dashboard',
        component: AdminDashboard
      },
      {
        path: 'epaper',
        name: 'admin-epaper',
        component: EpaperView
      },
      {
        path: 'change-password', // 👈 yahan route add karo
        name: 'admin-change-password',
        component: ChangePassword,
        meta: { requiresAuth: true }
      },
      {
        path: '',
        redirect: { name: 'admin-dashboard' }
      }
    ]
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/admin'
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// ✅ Route Guard — prevent access without login
router.beforeEach((to, from, next) => {
  const auth = getAuth();
  const user = auth.currentUser;

  if (to.matched.some(record => record.meta.requiresAuth) && !user) {
    // If not logged in, redirect to login
    next({ name: 'admin-login' });
  } else {
    next();
  }
});

export default router;

