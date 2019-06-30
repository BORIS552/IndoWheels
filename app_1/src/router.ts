import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';
import utils from './utils';

Vue.use(Router);

export default new Router({
  mode: process.env.CORDOVA_PLATFORM ? 'hash' : 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      beforeEnter: utils.authGuard,
      component: Home,
    },
    {
      path: '/register',
      name: 'register',
      beforeEnter: utils.guestGuard,
      component: () => import(/* webpackChunkName: "login" */ './views/auth/Register.vue'),
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
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "login" */ './views/auth/Logout.vue'),
    },
    {
      path: '/profile',
      name: 'profile',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/Profile.vue'),
    },
    {
      path: '/participate/:lottery',
      name: 'participate',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/Participate.vue'),
    },
    {
      path: '/winners/:winner',
      name: 'winner.show',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/WinnerProfile.vue'),
    },
    {
      path: '/contact',
      name: 'contact.index',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/ContactDetails.vue'),
    },
    {
      path: '/contact/form',
      name: 'contact.form',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "profile" */ './views/Contact.vue'),
    },
    {
      path: '/about',
      name: 'about',
      beforeEnter: utils.authGuard,
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "about" */ './views/About.vue'),
    },
    {
      path: '/terms',
      name: 'terms',
      beforeEnter: utils.authGuard,
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "about" */ './views/Terms.vue'),
    },
    {
      path: '/reviews',
      name: 'reviews',
      beforeEnter: utils.authGuard,
      // route level code-splitting
      // this generates a separate chunk (reviews.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "reviews" */ './views/reviews/ReviewsIndex.vue'),
    },
    {
      path: '/reviews/create',
      name: 'reviews.create',
      beforeEnter: utils.authGuard,
      // route level code-splitting
      // this generates a separate chunk (reviews.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "reviews" */ './views/reviews/ReviewsCreate.vue'),
    },
    {
      path: '/videos',
      name: 'videos',
      beforeEnter: utils.authGuard,
      // route level code-splitting
      // this generates a separate chunk (reviews.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "reviews" */ './views/Videos.vue'),
    },
    {
      path: '/camera',
      name: 'camera',
      beforeEnter: utils.authGuard,
      component: () => import(/* webpackChunkName: "about" */ './views/CameraView.vue'),
},
  ],
});
