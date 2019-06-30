import Vue from 'vue';
import * as types from './mutation-types';

interface Payload {
    id: number;
    index: number;
    data: object | object[];
}

interface Model {
    id: number,
}

export default {

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
        Vue.set(state, 'auth', { isBusy: false, user: {} });
    },

    [types.AUTH_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.auth, 'isError', true);
        Vue.set(state.auth, 'errors', payload.data);
    },

    [types.AUTH_IS_ERROR_FREE](state: any): void {
        Vue.set(state.auth, 'isError', false);
        Vue.set(state.auth, 'errors', {});
    },

    // USERS

    [types.USERS_IS_BUSY](state: any): void {
        Vue.set(state.users, 'isBusy', true);
    },

    [types.USERS_IS_FREE](state: any): void {
        Vue.set(state.users, 'isBusy', false);
    },

    [types.USERS_INDEX](state: any, payload: Payload): void {
        Vue.set(state.users, 'data', payload.data);
    },

    [types.USERS_STORE](state: any, payload: Payload): void {
        state.users.data.push(payload.data);
    },

    [types.USERS_UPDATE](state: any, payload: Payload): void {
        const index = state.users.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            Vue.set(state.users.data, index, payload.data);
        }
    },

    [types.USERS_DESTROY](state: any, payload: Payload): void {
        const index = state.users.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            state.users.data.splice(index, 1);
        }
    },

    [types.USERS_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.users, 'isError', true);
        Vue.set(state.users, 'errors', payload.data);
    },

    [types.USERS_IS_ERROR_FREE](state: any): void {
        Vue.set(state.users, 'isError', false);
        Vue.set(state.users, 'errors', {});
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

    [types.OUTLETS_STORE](state: any, payload: Payload): void {
        state.outlets.data.push(payload.data);
    },

    [types.OUTLETS_UPDATE](state: any, payload: Payload): void {
        const index = state.outlets.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            Vue.set(state.outlets.data, index, payload.data);
        }
    },

    [types.OUTLETS_DESTROY](state: any, payload: Payload): void {
        const index = state.outlets.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            state.outlets.data.splice(index, 1);
        }
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

    [types.LOTTERIES_STORE](state: any, payload: Payload): void {
        state.lotteries.data.push(payload.data);
    },

    [types.LOTTERIES_UPDATE](state: any, payload: Payload): void {
        const index = state.lotteries.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            Vue.set(state.lotteries.data, index, payload.data);
        }
    },

    [types.LOTTERIES_DESTROY](state: any, payload: Payload): void {
        const index = state.lotteries.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            state.lotteries.data.splice(index, 1);
        }
    },

    [types.LOTTERIES_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.lotteries, 'isError', true);
        Vue.set(state.lotteries, 'errors', payload.data);
    },

    [types.LOTTERIES_IS_ERROR_FREE](state: any): void {
        Vue.set(state.lotteries, 'isError', false);
        Vue.set(state.lotteries, 'errors', {});
    },

    // PRIZES

    [types.PRIZES_IS_BUSY](state: any): void {
        Vue.set(state.prizes, 'isBusy', true);
    },

    [types.PRIZES_IS_FREE](state: any): void {
        Vue.set(state.prizes, 'isBusy', false);
    },

    [types.PRIZES_INDEX](state: any, payload: Payload): void {
        Vue.set(state.prizes, 'data', payload.data);
    },

    [types.PRIZES_DESTROY](state: any, payload: Payload): void {
        const index = state.prizes.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            state.prizes.data.splice(index, 1);
        }
    },

    [types.PRIZES_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.prizes, 'isError', true);
        Vue.set(state.prizes, 'errors', payload.data);
    },

    [types.PRIZES_IS_ERROR_FREE](state: any): void {
        Vue.set(state.prizes, 'isError', false);
        Vue.set(state.prizes, 'errors', {});
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

    [types.REVIEWS_UPDATE](state: any, payload: Payload): void {
        const index = state.reviews.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            Vue.set(state.reviews.data, index, payload.data);
        }
    },

    [types.REVIEWS_DESTROY](state: any, payload: Payload): void {
        const index = state.reviews.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            state.reviews.data.splice(index, 1);
        }
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

    [types.BANNERS_STORE](state: any, payload: Payload): void {
        state.banners.data.push(payload.data);
    },

    [types.BANNERS_UPDATE](state: any, payload: Payload): void {
        const index = state.banners.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            Vue.set(state.banners.data, index, payload.data);
        }
    },

    [types.BANNERS_DESTROY](state: any, payload: Payload): void {
        const index = state.banners.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            state.banners.data.splice(index, 1);
        }
    },

    [types.BANNERS_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.banners, 'isError', true);
        Vue.set(state.banners, 'errors', payload.data);
    },

    [types.BANNERS_IS_ERROR_FREE](state: any): void {
        Vue.set(state.banners, 'isError', false);
        Vue.set(state.banners, 'errors', {});
    },

    // IMAGES

    [types.IMAGES_IS_BUSY](state: any): void {
        Vue.set(state.images, 'isBusy', true);
    },

    [types.IMAGES_IS_FREE](state: any): void {
        Vue.set(state.images, 'isBusy', false);
    },

    [types.IMAGES_INDEX](state: any, payload: Payload): void {
        Vue.set(state.images, 'data', payload.data);
    },

    [types.IMAGES_STORE](state: any, payload: Payload): void {
        state.images.data.push(payload.data);
    },

    [types.IMAGES_UPDATE](state: any, payload: Payload): void {
        const index = state.images.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            Vue.set(state.images.data, index, payload.data);
        }
    },

    [types.IMAGES_DESTROY](state: any, payload: Payload): void {
        const index = state.images.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            state.images.data.splice(index, 1);
        }
    },

    [types.IMAGES_IS_ERROR](state: any, payload: Payload): void {
        Vue.set(state.images, 'isError', true);
        Vue.set(state.images, 'errors', payload.data);
    },

    [types.IMAGES_IS_ERROR_FREE](state: any): void {
        Vue.set(state.images, 'isError', false);
        Vue.set(state.images, 'errors', {});
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

    [types.ADS_STORE](state: any, payload: Payload): void {
        state.ads.data.push(payload.data);
    },

    [types.ADS_UPDATE](state: any, payload: Payload): void {
        const index = state.ads.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            Vue.set(state.ads.data, index, payload.data);
        }
    },

    [types.ADS_DESTROY](state: any, payload: Payload): void {
        const index = state.ads.data.findIndex((item: Model) => item.id == payload.id);
        if (0 <= index) {
            state.ads.data.splice(index, 1);
        }
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
