import Vue from 'vue';
import * as types from './mutation-types';

interface Payload {
    id: number;
    index: number;
    data: object | object[];
}

interface Model {
    id: number;
}

export default {

    // SIDEBAR

    [types.SIDEBAR_TOGGLE](state: any): void {
        Vue.set(state.sidebar, 'isOn', !state.sidebar.isOn);
    },

    [types.SIDEBAR_SHOW](state: any): void {
        Vue.set(state.sidebar, 'isOn', true);
    },

    [types.SIDEBAR_HIDE](state: any): void {
        Vue.set(state.sidebar, 'isOn', false);
    },

    // AUTH

    [types.AUTH_IS_BUSY](state: any): void {
        Vue.set(state.auth, 'isBusy', true);
    },

    [types.AUTH_IS_FREE](state: any): void {
        Vue.set(state.auth, 'isBusy', false);
    },

    [types.AUTH_STORE](state: any, payload: Payload): void {
        Vue.set(state.auth, 'user', payload.data);
    },

    [types.AUTH_UPDATE](state: any, payload: Payload): void {
        Vue.set(state.auth, 'user', payload.data);
    },

    [types.AUTH_DESTROY](state: any, payload: Payload): void {
        Vue.set(state, 'auth', {
            user: {},
            isBusy: false,
            errors: {},
            isError: false,
            otp: {
                isSend: false,
                isVerified: false,
            }
        });
    },

    [types.AUTH_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.auth, 'isError', true);
        Vue.set(state.auth, 'errors', payload.data);
    },

    [types.AUTH_IS_ERROR_FREE](state: any): void {
        Vue.set(state.auth, 'isError', false);
        Vue.set(state.auth, 'errors', {});
    },

    [types.AUTH_OTP_IS_SEND](state: any): void {
        Vue.set(state.auth.otp, 'isSend', true);
        Vue.set(state.auth, 'errors', {});
    },

    [types.AUTH_OTP_IS_VERIFIED](state: any): void {
        Vue.set(state.auth.otp, 'isVerified', true);
        Vue.set(state.auth, 'errors', {});
    },

    // OUTLETS

    [types.OUTLETS_IS_BUSY](state: any): void {
        Vue.set(state.outlets, 'isBusy', true);
    },

    [types.OUTLETS_IS_FREE](state: any): void {
        Vue.set(state.outlets, 'isBusy', false);
    },

    [types.OUTLETS_INDEX](state: any, payload: Payload): void {
        Vue.set(state.outlets, 'data', payload.data);
    },

    [types.OUTLETS_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.outlets, 'isError', true);
        Vue.set(state.outlets, 'errors', payload.data);
    },

    [types.OUTLETS_IS_ERROR_FREE](state: any): void {
        Vue.set(state.outlets, 'isError', false);
        Vue.set(state.outlets, 'errors', {});
    },

    // LOTTERIES

    [types.LOTTERIES_IS_BUSY](state: any): void {
        Vue.set(state.lotteries, 'isBusy', true);
    },

    [types.LOTTERIES_IS_FREE](state: any): void {
        Vue.set(state.lotteries, 'isBusy', false);
    },

    [types.LOTTERIES_INDEX](state: any, payload: Payload): void {
        Vue.set(state.lotteries, 'data', payload.data);
    },

    [types.LOTTERIES_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.lotteries, 'isError', true);
        Vue.set(state.lotteries, 'errors', payload.data);
    },

    [types.LOTTERIES_IS_ERROR_FREE](state: any): void {
        Vue.set(state.lotteries, 'isError', false);
        Vue.set(state.lotteries, 'errors', {});
    },

    // REVIEWS

    [types.REVIEWS_IS_BUSY](state: any): void {
        Vue.set(state.reviews, 'isBusy', true);
    },

    [types.REVIEWS_IS_FREE](state: any): void {
        Vue.set(state.reviews, 'isBusy', false);
    },

    [types.REVIEWS_INDEX](state: any, payload: Payload): void {
        Vue.set(state.reviews, 'data', payload.data);
    },

    [types.REVIEWS_STORE](state: any, payload: Payload): void {
        state.reviews.data.push(payload.data);
    },

    [types.REVIEWS_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.reviews, 'isError', true);
        Vue.set(state.reviews, 'errors', payload.data);
    },

    [types.REVIEWS_IS_ERROR_FREE](state: any): void {
        Vue.set(state.reviews, 'isError', false);
        Vue.set(state.reviews, 'errors', {});
    },

    // BANNERS

    [types.BANNERS_IS_BUSY](state: any): void {
        Vue.set(state.banners, 'isBusy', true);
    },

    [types.BANNERS_IS_FREE](state: any): void {
        Vue.set(state.banners, 'isBusy', false);
    },

    [types.BANNERS_INDEX](state: any, payload: Payload): void {
        Vue.set(state.banners, 'data', payload.data);
    },

    [types.BANNERS_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.banners, 'isError', true);
        Vue.set(state.banners, 'errors', payload.data);
    },

    [types.BANNERS_IS_ERROR_FREE](state: any): void {
        Vue.set(state.banners, 'isError', false);
        Vue.set(state.banners, 'errors', {});
    },

    // ADS

    [types.ADS_IS_BUSY](state: any): void {
        Vue.set(state.ads, 'isBusy', true);
    },

    [types.ADS_IS_FREE](state: any): void {
        Vue.set(state.ads, 'isBusy', false);
    },

    [types.ADS_INDEX](state: any, payload: Payload): void {
        Vue.set(state.ads, 'data', payload.data);
    },

    [types.ADS_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.ads, 'isError', true);
        Vue.set(state.ads, 'errors', payload.data);
    },

    [types.ADS_IS_ERROR_FREE](state: any): void {
        Vue.set(state.ads, 'isError', false);
        Vue.set(state.ads, 'errors', {});
    },


};
