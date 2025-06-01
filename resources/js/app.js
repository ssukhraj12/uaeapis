/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue';
import App from "./App.vue";
import {QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css"
import vuetify from "./vuetify.js";
import router from './router'
import store from "./store"

import axios from "axios";
window.axios = axios;

const token = localStorage.getItem('token');
if (token) {
    store.commit('SET_TOKEN', token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

axios.interceptors.request.use(config=>{
    const token = store.state.token;
    if(token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config
},(error)=>{
    return Promise.reject(error)
})

let isRefreshing = false;
let failedQueue = [];

function processQueue(error, token = null) {
    failedQueue.forEach(prom => {
        if (error) {
            prom.reject(error)
        } else {
            prom.resolve(token)
        }
    })
    failedQueue = []
}

axios.interceptors.response.use(
    response => response,
    async error => {
        const originalRequest = error.config

        if (error.response?.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true

            if (isRefreshing) {
                return new Promise((resolve, reject)=> {
                    failedQueue.push({ resolve, reject })
                })
                    .then(token => {
                        originalRequest.headers.Authorization = `Bearer ${token}`
                        return axios(originalRequest)
                    })
                    .catch(err => Promise.reject(err))
            }
            isRefreshing = true
            try {
                const { data } = await axios.post('/api/refresh',null,{
                    headers: {
                        Authorization: `Bearer ${store.state.token}`
                    }
                })
                store.commit('SET_TOKEN', data.token)
                axios.defaults.headers.common.Authorization = `Bearer ${data.token}`
                processQueue(null, data.token)
                return axios(originalRequest)
            } catch (err) {
                processQueue(err, null)
                await store.dispatch('logout')
                await router.push({name:'login'})
                return Promise.reject(err)
            } finally {
                isRefreshing = false
            }
        }
        return Promise.reject(error)
    }
)

if (store.state.token) {
    axios.defaults.headers.common.Authorization = `Bearer ${store.state.token}`
}

const app = createApp(App);
app.component('QuillEditor',QuillEditor)
app.use(store)
app.use(router)
app.use(vuetify)
app.mount('#app');

