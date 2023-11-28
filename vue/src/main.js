import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import 'bootstrap-icons/font/bootstrap-icons.css'
import 'tabulator-tables/dist/css/tabulator_materialize.min.css'
import './assets/main.css'
import './assets/styles.scss'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import axios from 'axios'
import VueAxios from 'vue-axios'
import VueCookies from 'vue-cookies'

const app = createApp(App)

app.use(router)

app.use(VueCookies, { expires: '7d' })
app.use(VueAxios, axios)
app.use(router)

function checkAuthApi() {
    return true
    if (VueCookies.get('isAuth') == null) {
        return false
    }
    else {
        return true
    }
}

router.beforeEach((to, from, next) => {
    const isAuthenticated = checkAuthApi()
    if (!isAuthenticated && to.meta.requiresAuth) {
        next('/')
    }
    else if (isAuthenticated && to.meta.title == 'Auth') {
        next('/data/produk')
    }
    else {
        next()
    }
})

app.config.globalProperties.$APPNAME = 'Inventory'
app.config.globalProperties.$VERSION = '1.0.0'
app.config.globalProperties.$SERVER = 'http://127.0.0.1:8000/'

app.mount('#app')
