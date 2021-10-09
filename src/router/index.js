import VueRouter from "vue-router";

import Home from "../pages/Home.vue";
import Settings from "../pages/Settings.vue";
import Profile from "../pages/Profile.vue";
import Create from "../pages/Create.vue";
import Edit from "../pages/Edit.vue";

const routes = [
  { path: "/", component: Home },
  { path: "/settings", component: Settings },
  { path: "/users/:id", component: Profile },
  { path: "/create", component: Create },
  { path: "/edit/:id", component: Edit },
];

const router = new VueRouter({
  routes,
});

export default router;
