import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'auth',
            component: () => import('../views/AuthView.vue'),
            meta: {
                title: 'Auth',
                requiresAuth: false
            }
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: () => import('../views/DashboardView.vue'),
            meta: {
                title: 'Dashboard',
                requiresAuth: true
            }
        },
        {
            path: '/data/kategori',
            name: 'data-kategori',
            component: () => import('../views/tables/Kategori.vue'),
            meta: {
                title: 'Data Kategori',
                requiresAuth: true
            }
        },
        {
            path: '/data/produk',
            name: 'data-produk',
            component: () => import('../views/tables/Produk.vue'),
            meta: {
                title: 'Data Produk',
                requiresAuth: true
            }
        },
        {
            path: '/data/status',
            name: 'data-status',
            component: () => import('../views/tables/Status.vue'),
            meta: {
                title: 'Data Status',
                requiresAuth: true
            }
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'not-found',
            component: () => import('../views/404.vue'),
            meta: {
                title: 'Not Found',
                requiresAuth: false
            }
        },
    ]
})



export default router
