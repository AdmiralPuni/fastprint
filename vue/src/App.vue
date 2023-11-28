<script setup>
import { RouterView } from 'vue-router'
import Header from './components/Header.vue'
</script>

<template>
    <Header v-if="$route.meta.requiresAuth" />
    <div class="d-flex" v-if="$route.meta.requiresAuth">
        <div class="w-side"></div>
        <div class="flex-fill">
            <div class="d-flex p-2">
                <button class="btn btn-outline-light">
                    X
                </button>
            </div>
            <div class="p-md-3 px-md-4 p-0 p-2">
                <RouterView v-slot="{ Component }">
                    <Transition name="fade" mode="out-in">
                        <component :is="Component" />
                    </Transition>
                </RouterView>
            </div>
        </div>
    </div>
    <RouterView v-if="!$route.meta.requiresAuth" />
</template>
<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.25s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
