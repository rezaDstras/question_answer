import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Register from "../views/auth/Register";
import Login from "../views/auth/Login";
import SingleThread from "../views/thread/SingleThread";
import CreateThread from "../views/thread/CreateThread";

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
    //registration
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    //login
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    //show thread
    {
        path: '/thread/:slug',
        name: 'Single Thread',
        component: SingleThread
    },
    //create thread
    {
        path: '/create/thread',
        name: 'Create Thread',
        component: CreateThread
    },

  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  routes
})

export default router
