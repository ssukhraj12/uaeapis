import { createStore } from "vuex";
import axios from "axios";

export default createStore({
    state: {
        token: localStorage.getItem('token') || null,
        user: JSON.parse(localStorage.getItem('user')) || null,
    },
    mutations: {
        SET_TOKEN(state, token) {
            state.token = token
            localStorage.setItem('token', token)
        },
        SET_USER(state, user) {
            state.user = user
            localStorage.setItem('user', JSON.stringify(user))
        },
        LOGOUT(state) {
            state.token = null
            state.user = null
            localStorage.removeItem('token')
            localStorage.removeItem('user')
        },
    },
    actions: {
        async login({ commit }, credentials) {
            const { data } = await axios.post('/api/login', credentials)
            commit('SET_TOKEN', data.token)
            commit('SET_USER', data.user)
        },
        async logout({ commit }) {
            try {
                await axios.post('/api/logout')
            } catch (e){
                alert('not logged out')
            }
            commit('LOGOUT')
        },
        async refreshToken({ commit, state }) {
            try {
                const res = await axios.post('/api/refresh', null, {
                    headers: { Authorization: `Bearer ${state.token}` },
                })
                commit('SET_TOKEN', res.data.token)
                commit('SET_USER', res.data.user)
                localStorage.setItem('token', res.data.token)
            } catch (error) {
                commit('LOGOUT')
                router.push({ name: 'login' })
            }
        },
    },
    getters:{
        isAuthenticated: state => !!state.token,
    }

})
