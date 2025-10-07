import { createRouter, createWebHistory } from 'vue-router';
import { auth } from '../firebase';  // import auth instance

import AppShell from '@/layouts/AppShell.vue';
import Dashboard from '@/views/Dashboard.vue';

const routes = [
  { path: '/', component: AppShell, children: [
    { path: '', name: 'dashboard', component: Dashboard, meta: { requiresAuth: true } },
    { path: 'epaper', component: () => import('@/views/Epaper.vue'), meta: { requiresAuth: true } },
    { path: 'media', component: () => import('@/views/Media.vue'), meta: { requiresAuth: true } },
    { path: 'users', component: () => import('@/views/Users.vue'), meta: { requiresAuth: true } },
  ]},
  { path: '/login', component: () => import('@/views/Login.vue') },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Global navigation guard
router.beforeEach((to, from, next) => {
  const user = auth.currentUser;
  if (to.meta.requiresAuth && !user) {
    next('/login'); // redirect to login if not authenticated
  } else if (to.path === '/login' && user) {
    next('/'); // if logged in and going to login, redirect to dashboard
  } else {
    next();
  }
});

export default router;

