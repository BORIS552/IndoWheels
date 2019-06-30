import Vue from 'vue';
import Vuex from 'vuex';
import mutations from './mutations';
import * as actions from './actions';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    auth: {
      user: {},
      isBusy: false,
      errors: {},
      isError: false,
    },
    outlets: {
      data: [],
      isBusy: false,
      errors: {},
      isError: false,
    },
    lotteries: {
      data: [],
      isBusy: false,
      errors: {},
      isError: false,
    },
    prizes: {
      data: [],
      isBusy: false,
      errors: {},
      isError: false,
    },
    users: {
      data: [],
      isBusy: false,
      errors: {},
      isError: false,
    },
    reviews: {
      data: [],
      isBusy: false,
      errors: {},
      isError: false,
    },
    banners: {
      data: [],
      isBusy: false,
      errors: {},
      isError: false,
    },
    images: {
      data: [],
      isBusy: false,
      errors: {},
      isError: false,
    },
    ads: {
      data: [],
      isBusy: false,
      errors: {},
      isError: false,
    },
  },
  mutations,
  actions,
});
