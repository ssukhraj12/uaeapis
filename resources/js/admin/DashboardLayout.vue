<template>
    <v-app>
        <v-navigation-drawer rail expand-on-hover permanent>
            <v-list nav density="compact" active-class="primary" class="d-flex flex-column fill-height">
                <v-list-item>
                    <v-list-item-title>Your Resume Writer</v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item link to="/" color="primary" prepend-icon="mdi-view-dashboard-outline" class="mt-3">
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item>
                <v-list-item link to="/blogs" color="primary" prepend-icon="mdi-view-dashboard-outline">
                    <v-list-item-title>Blogs</v-list-item-title>
                </v-list-item>
                <v-spacer></v-spacer>
                <v-list-item prepend-icon="mdi-logout">
                    <v-list-item-title>
                        <v-btn @click="logout" variant="outlined" size="small" block title="Logout">Logout</v-btn>
                    </v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-main class="bg-grey-lighten-5">
            <v-container>
                <router-view />
            </v-container>
        </v-main>
    </v-app>
</template>
<script setup>
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'

const store = useStore()
const router = useRouter()
const logout = async () => {
    await store.dispatch('logout')
    router.push({ name: 'login' })
}

</script>

<style scoped>

</style>
