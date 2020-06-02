import Vue from "vue";
import VueRouter from 'vue-router'
import Welcome from "../views/Welcome.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/login",
    name: "Welcome",
    component: Welcome
  },
  {
    path: "/",
    name: "CBBLe",
    component: () => import("../views/CBBLe.vue")
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
