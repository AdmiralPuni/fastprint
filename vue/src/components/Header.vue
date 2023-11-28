<script setup>
import { ref } from 'vue'

var show = ref(true)
var isMobile = ref(false)

//if mobile show is false
if (window.innerWidth < 768) {
    show.value = false
    isMobile.value = true
}
</script>
<template>
    <Transition>
        <div class="bg-dark fixed-top shadow-lg w-sidebar" style="height: 100vh;z-index: 19;" v-if="show">
            <div class="d-flex flex-column">
                <div class="py-3 pb-2 text-center border-bottom border-tblue">
                    <img src="/logo.png" style="height: 96px;" >
                    <div class="text-tblue fs-4 mt-1">
                        {{ $APPNAME }}
                    </div>
                </div>
                <RouterLink class="btn btn-nav" to="/data/produk" @click="show = (isMobile) ? false : true" exact>
                    <i class="bi bi-box-seam"></i>
                    <div>
                        PRODUK
                    </div>
                </RouterLink>
                <RouterLink class="btn btn-nav" to="/data/kategori" @click="show = (isMobile) ? false : true" exact>
                    <i class="bi bi-palette2"></i>
                    <div>
                        KATEGORI
                    </div>
                </RouterLink>
                <RouterLink class="btn btn-nav" to="/data/status" @click="show = (isMobile) ? false : true" exact>
                    <i class="bi bi-check2-square"></i>
                    <div>
                        STATUS
                    </div>
                </RouterLink>
            </div>
        </div>
    </Transition>
    <Transition name="fade">
        <div class="fixed-top bg-dark-50 d-block d-md-none" style="height: 100vh;width: 100vw;z-index: 11;" v-if="show" @click="show = !show">

        </div>
    </Transition>
    <div class="fixed-top" style="z-index: 10;">
        <div class="d-flex">
            <div class="w-side"></div>
            <div class="flex-fill bg-white  border-bottom">
                <div class="d-flex justify-content-between align-items-center p-2 px-md-4">
                    <div class="hstack gap-2">
                        <button class="btn btn-outline-dark rounded-0 d-inline d-md-none" @click="show = !show">
                            <i class="bi bi-list"></i>
                        </button>
                        <div class="fs-4 fw-normal text-dark">
                            {{ title }}
                        </div>
                    </div>
                    <button class="btn btn-outline-dark rounded-0" @click="logout">
                        <i class="bi bi-power"></i> Log Out
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            title: 'Hello',
            currentAnim: null
        }
    },
    methods: {
        logout() {
            this.$cookies.remove('isAuth')
            this.$router.push('/')
        },
        animateText(text) {
            this.title = '';
            this.currentAnim = null;
            //explode to array
            text = text.split('');
            //add each char to title by 30ms delay
            this.currentAnim = text.forEach((char, index) => {
                setTimeout(() => {
                    this.title += char;
                }, 20 * index);
            });
        },
        showTrueSwitch(){
            if (isMobile.value) {
                show.value = false
            }
        }
    },
    //listen to route change
    watch: {
        $route(to, from) {
            //set document title
            document.title = to.meta.title + ' | ' + this.$APPNAME

            this.animateText(to.meta.title)
        }
    },
    //on mounted set document title
    mounted() {
        document.title = this.$route.meta.title + ' | ' + this.$APPNAME
        this.animateText(this.$route.meta.title)
    }
}
</script>
<style scoped>
.bg-dark-50 {
    background-color: rgba(0, 0, 0, .5) !important;
}

.btn-nav {
    display: flex;
    align-items: center;
    color: var(--bs-light);
    font-size: 12pt;
    border-top: 0 !important;
    border-bottom: 0 !important;
    border-left: 10px solid transparent;
}

.btn-nav:focus {

    color: var(--bs-light);
}

.btn-nav:hover {
    border-left: 10px solid var(--tblue);
    color: var(--tblue);
}

.router-link-active {
    border: 0;
    border-left: 10px solid var(--tblue);
}

.router-link-active .bi {
    color: var(--tblue);
}


.btn-nav .bi {
    font-size: 22pt;
    margin-right: 10pt;
}


.v-enter-active {
    transition: all 0.25s ease-out;
}

.v-leave-active {
    transition: all 0.25s cubic-bezier(1, 0.5, 0.8, 1);
}

.v-enter-from,
.v-leave-to {
    transform: translateX(-180px);
    opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.25s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>