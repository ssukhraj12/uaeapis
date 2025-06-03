<template>
    <div class="login-page fill-height bg-grey-lighten-3">
        <v-container class="fill-height">
            <v-row justify="center">
                <v-col cols="12" md="4">
                    <v-card elevation="4" class="border-dashed rounded-lg">
                        <v-card-title class="flex flex-column">
                            <div>
                                <v-img src="/images/logo.png" width="150" height="75"/>
                            </div>
                            <div>Your Resume Writer</div>
                        </v-card-title>
                        <v-card-subtitle>Login</v-card-subtitle>
                        <v-card-text>
                            <v-text-field v-model="email" placeholder="email" density="compact" prepend-inner-icon="mdi-email"
                                          variant="outlined" label="Email" persistent-placeholder></v-text-field>
                            <v-text-field v-model="password" placeholder="password" density="compact"  type="password"
                                          variant="outlined" label="Password" prepend-inner-icon="mdi-lock" persistent-placeholder></v-text-field>
                            <v-btn @click="login" variant="elevated" block color="primary">Login</v-btn>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<script setup>
import {ref } from "vue";
import {useStore} from "vuex";
import {useRouter} from "vue-router";
const store = useStore()
const router = useRouter()
const email = ref('');
const password = ref('');
const login = async () => {
    try {
        await store.dispatch('login',{
            email:email.value,
            password:password.value
        })
        router.push('/')
    } catch (e) {
        alert('login failed')
    }
}
</script>

<style scoped>

</style>
