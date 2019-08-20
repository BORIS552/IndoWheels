import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import push from './PushNotificationsImpl';
Vue.config.productionTip = false;

require('./sass/app.scss');
console.log("In main");
push.notification();
new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount('#app');
