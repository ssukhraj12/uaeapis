<template>
    <v-app>
        <v-navigation-drawer rail expand-on-hover permanent app>
            <v-list nav density="compact" active-class="primary" class="d-flex flex-column fill-height overflow-y-scroll">
                <v-list-item base-color="dark" prepend-avatar="/images/favicon.png">
                    <v-list-item-title>Your Resume Writer</v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item link to="/" color="primary" prepend-icon="mdi-view-dashboard-outline" class="mt-3">
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item>
                <v-list-item link to="/blogs" color="primary" prepend-icon="mdi-post-outline">
                    <v-list-item-title>YRW Blogs</v-list-item-title>
                </v-list-item>
                <v-list-item link to="/gallery" color="primary" prepend-icon="mdi-view-gallery-outline">
                    <v-list-item-title>Gallery</v-list-item-title>
                </v-list-item>
                <v-list-item link to="/rblogs" color="red" prepend-icon="mdi-account-tie-woman">
                    <v-list-item-title>RM Blogs</v-list-item-title>
                </v-list-item>
                <v-list-item link to="/photos" color="primary" prepend-icon="mdi-image-multiple">
                    <v-list-item-title>Photos</v-list-item-title>
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
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    router.push({ name: 'login' })
    await store.dispatch('logout')
}

</script>

<style>
.ql-toolbar.ql-snow {
    border: 1px solid #ccc;
    box-sizing: border-box;
    font-family: 'Helvetica','Arial',sans-serif;
    padding: 8px;
    border-radius: 6px 6px 0 0;
    background: #fafafa;
}
.ql-editor {
    min-height: 175px;
}
</style>
