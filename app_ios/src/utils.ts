const storeJs = require('store');

import axios from 'axios';
import store from './store';

export default class Utils {

    //fetching api link from index.js meta.
    public static meta(name: string): string | null | void {
        const ele = document.head.querySelector(`meta[name="${name}"]`);
        if (ele) {
            return ele.getAttribute('content');
        }
    }

    public static apiUrl(url: string = ''): string {
        return this.meta('api-end-point') + '/' + url;
    }

    public static getAccessToken(): string {
        return storeJs.get('api_token');
        // return "$2y$10$QwXKTfmqFjtbdZ/Nd8PlHuyf2mDMYbesismM2WmIxSBh2AWmtQo3m";
    }

    public static setAccessToken(token: string): void {
        storeJs.set('api_token', token);
    }

    public static removeAccessToken(): void {
        storeJs.remove('api_token');
    }

    public static setAxiosAccessToken(token: string): void {
        axios.defaults.headers.common.Authorization = 'Bearer ' + token;
    }

    public static removeAxiosAccessToken(): void {
        delete(axios.defaults.headers.common.Authorization);
    }

    public static setAxiosBaseUrl(url: string): void {
        axios.defaults.baseURL = url;
    }

    public static async authGuard(to: any, from: any, next: any): Promise<any> {
        // no token found
        if (!Utils.getAccessToken()) {
            return next('login');
        }

        const auth = store.state.auth;

        // user is present in store
        if (auth.user && auth.user.id) {
            if (auth.user.is_terms_accepted) {
                return next();
            }
            if (to && 'terms' != to.name) {
                return next({ name: 'terms' });
            }
            return next();
        }

        // user is not present in store - get user
        Utils.setAxiosAccessToken(Utils.getAccessToken());
        await store.dispatch('authUser');

        if (!auth.user || !auth.user.id) {
            Utils.removeAccessToken();
            Utils.removeAxiosAccessToken();
            return next({ name: 'login' });
        }

        if (!auth.user.is_terms_accepted) {
            return next({ name: 'terms' });
        }

        return next();
    }

    public static async guestGuard(to: any, from: any, next: any) {
        // token not found
        if (!Utils.getAccessToken()) {
            return next();
        }

        const auth = store.state.auth;

        // user is present in store
        if (auth.user && auth.user.id) {
            return next({ name: 'home' });
        }

        // token found but user is not present in store
        // needs to check auto login before letting user in
        Utils.setAxiosAccessToken(Utils.getAccessToken());
        await store.dispatch('authUser');

        // user token was valid
        if (auth.user && auth.user.id) {
            return next({ name: 'home' });
        }

        Utils.removeAccessToken();
        Utils.removeAxiosAccessToken();

        return next();
    }

}
