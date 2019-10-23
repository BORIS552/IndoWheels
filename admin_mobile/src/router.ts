import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';
import utils from './utils';

Vue.use(Router);

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      beforeEnter: utils.authGuard,
      component: Home,
    },
    {
      path: '/login',
      name: 'login',
      beforeEnter: utils.guestGuard,
      component: () => import(/* webpackChunkName: "login" */ './views/auth/Login.vue'),
    },
    {
      path: '/logout',
      name: 'logout',
      component: () => import(/* webpackChunkName: "login" */ './views/auth/Logout.vue'),
    },
    {
      path: '/profile',
      name: 'profile',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/Profile.vue'),
    },
    {
      path: '/outlets',
      name: 'outlets',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/Outlets.vue'),
    },
    {
      path: '/lotteries',
      name: 'lotteries',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/Lotteries.vue'),
    },
    {
      path: '/prizes',
      name: 'prizes',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/Prizes.vue'),
    },
    {
      path: '/users',
      name: 'users',
      beforeEnter: utils.authGuard,
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "users" */ './views/Users.vue'),
    },
    {
      path: '/reviews',
      name: 'reviews',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/Reviews.vue'),
    },
    {
      path: '/banners',
      name: 'banners',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/Banners.vue'),
    },
    {
      path: '/ads',
      name: 'ads',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/Ads.vue'),
    },
    {
      path: '/users/:id/images',
      name: 'images',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/Images.vue'),
    },
    {
      path: '/upload',
      name: 'upload',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/UploadSelfie.vue'),
    },
  ],
});
