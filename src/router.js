import { createRouter, createWebHistory } from 'vue-router';
import { getAuth } from 'firebase/auth';

// Components
import AdminLogin from './components/AdminLogin.vue';
import AdminDashboard from './components/AdminDashboard.vue';
import AppShell from './layouts/AppShell.vue';
import ReaderView from './components/ReaderView.vue';
import EpaperView from './views/EpaperView.vue';
import ChangePassword from './views/ChangePassword.vue';
import PageManager from './views/PageManager.vue';   
import SlideshowsManager from './views/SlideshowsManager.vue'; 
import MediaManager from './views/MediaManager.vue';

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
        path: 'page',
        name: 'admin-page',
        component: PageManager, // 👈 yahan add karo
        meta: { requiresAuth: true }
      },
      {
  path: 'slider',
  name: 'admin-slider',
  component: SlideshowsManager,
  meta: { requiresAuth: true }
},
{
  path: 'media',
  name: 'admin-media',
  component: MediaManager,
  meta: { requiresAuth: true }
},
{
  path: 'users',
  name: 'admin-users',
  component: () => import('@/views/UsersManager.vue'),
  meta: { requiresAuth: true }
},
      {
        path: 'change-password',
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

// Route Guard: prevent access without login
router.beforeEach((to, from, next) => {
  const auth = getAuth();
  const user = auth.currentUser;

  if (to.matched.some(record => record.meta.requiresAuth) && !user) {
    next({ name: 'admin-login' });
  } else {
    next();
  }
});

export default router;

