<template>
    <v-app>
        <v-main>
            <v-progress-linear
                v-if="loading" indeterminate color="primary" height="4"
                style="position:absolute;top: 0;left: 0;right: 0;z-index: 9999;width: 100%">
            </v-progress-linear>
            <router-view />
        </v-main>
    </v-app>
</template>
<script setup>
import {ref, onMounted} from "vue";
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
const loading = ref(false);
const store = useStore()
const router = useRouter()

onMounted(()=>{
    router.beforeEach((to,from,next)=>{
        loading.value = true
        next()
    })

    router.afterEach(()=>{
        setTimeout(()=>{
            loading.value = false
        },300)
    })
})

let timeout

const resetTimer = () => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
        store.dispatch('logout')
        router.push({ name: 'login' })
        window.$toast?.info('Logged out due to inactivity') // ← toast
    }, 15 * 60 * 1000) // 15 minutes of inactivity
}

// Reset timer on any interaction
['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(event => {
    window.addEventListener(event, resetTimer)
})

setInterval(() => {
    if (store.getters.isAuthenticated) {
        store.dispatch('refreshToken')
    }
}, 10 * 60 * 1000) // refresh every 10 mins

</script>

<style scoped>

</style>
