import { createRouter, createWebHistory } from "vue-router";
import Home from "@/admin/Home.vue";
import Login from "@/admin/Login.vue";
import DashboardLayout from "@/admin/DashboardLayout.vue";
import Blogs from "@/admin/Blogs.vue";
import BlogAdd from "@/admin/BlogAdd.vue";
import store from "../store";

function isAuthenticated(){
    return !!localStorage.getItem('user')
}

const routes = [
    {path:"/login",name:"login",component:Login},
    {path:"/",component: DashboardLayout, meta: { requiresAuth: true },
        children:[
            {path:"/",name:"home",component:Home},
            {path:"/blogs",name:"blogs",component:Blogs},
            {path:"/blog/add",name:"blogadd",component:BlogAdd},
        ]},
]

const router = createRouter({
    history:createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.getters.isAuthenticated) {
        return next({ name: 'login' })
    }
    next()
})

export default router;
