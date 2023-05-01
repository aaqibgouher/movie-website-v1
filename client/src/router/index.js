import { createRouter, createWebHistory } from "vue-router";

import HomeLayout from "@/layouts/HomeLayout";
import AuthLayout from "@/layouts/AuthLayout";
import HomePage from "@/pages/HomePage";
import LoginComponent from "@/components/LoginComponent";
import RegisterComponent from "@/components/RegisterComponent";
import DetailPage from "@/pages/DetailPage";
import store from "@/store";
import router from "@/router";
import FavouritePage from "@/pages/FavouritePage";

// Define your routes
const routes = [
  {
    path: "/",
    name: "home-layout",
    component: HomeLayout,
    children: [
      {
        path: "",
        name: "home-page",
        component: HomePage,
      },
      {
        path: "favourites",
        name: "favourite-page",
        component: FavouritePage,
        beforeEnter: (to, from, next) => {
          let isLogin = store.state.common.isLogin;

          if (isLogin) {
            next();
          } else {
            router.push("/login");
          }
        },
      },
      {
        path: ":imdbId",
        name: "detail-page",
        component: DetailPage,
      },
    ],
  },
  {
    path: "/",
    name: "auth-layout",
    component: AuthLayout,
    children: [
      {
        path: "login",
        name: "login",
        component: LoginComponent,
      },
      {
        path: "register",
        name: "register",
        component: RegisterComponent,
      },
    ],
  },
];

let myRouter = createRouter({
  history: createWebHistory(),
  routes,
});

//  add beforeEach method to router
myRouter.beforeEach((to, from, next) => {
  const user = JSON.parse(localStorage.getItem("user"));

  if (user) {
    store.commit("common/SET_USER", user);
    store.commit("common/SET_IS_LOGIN", true);
  }

  next();
});

export default myRouter;
