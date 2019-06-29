import axios from 'axios';
import * as types from './mutation-types';
import utils from './utils';

interface Action {
    commit: any;
    state: any;
}

interface Payload {
    id: number;
    index: number;
    data: object | object[];
    userId: number;
}

function errorHandler(error: any, commit: any, type: string): Promise<any> {
    let data = {};
    if (error.response && error.response.data && error.response.data.errors) {
        data = error.response.data.errors;
    }
    alert(error.response.data);
    return commit(type, { data });
}

function finalHandler(commit: any, type: string) {
    commit(type);
}

// auth

export const authUser = async (action: Action): Promise<any> => {
    action.commit(types.AUTH_IS_BUSY);
    return axios.get(utils.apiUrl('auth/user'))
        .then((response: any) => {
            action.commit(types.AUTH_STORE, { data: response.data });
        })
        .catch((error: any) => errorHandler(error, action.commit, types.AUTH_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.AUTH_IS_FREE));
};

export const authLogin = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.AUTH_IS_BUSY);
    return axios.post(utils.apiUrl('auth/login'), payload.data)
        .then((response: any) => {
            action.commit(types.AUTH_STORE, { data: response.data });
            action.commit(types.AUTH_IS_ERROR_FREE);
        })
        .catch((error: any) => errorHandler(error, action.commit, types.AUTH_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.AUTH_IS_FREE));
};

export const authRegister = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.AUTH_IS_BUSY);
    return axios.post(utils.apiUrl('auth/signup'), payload.data)
        .then((response: any) => {
            // action.commit(types.AUTH_STORE, { data: response.data });
            action.commit(types.AUTH_OTP_IS_SEND);
            action.commit(types.AUTH_IS_ERROR_FREE);
        })
        .catch((error: any) => errorHandler(error, action.commit, types.AUTH_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.AUTH_IS_FREE));
};

export const authGetOtp = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.AUTH_IS_BUSY);
    return axios.get(utils.apiUrl('auth/otp'), { params: payload.data })
        .then((response: any) => {
            action.commit(types.AUTH_OTP_IS_SEND);
            action.commit(types.AUTH_IS_ERROR_FREE);
        })
        .catch((error: any) => errorHandler(error, action.commit, types.AUTH_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.AUTH_IS_FREE));
};

export const authCheckOtp = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.AUTH_IS_BUSY);
    return axios.post(utils.apiUrl('auth/otp'), payload.data)
        .then((response: any) => {
            action.commit(types.AUTH_OTP_IS_VERIFIED);
        })
        .catch((error: any) => errorHandler(error, action.commit, types.AUTH_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.AUTH_IS_FREE));
};

export const authLogout = (action: Action, payload: Payload): void => {
    action.commit(types.AUTH_DESTROY);
};

// profile

export const updateProfile = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.AUTH_IS_BUSY);
    return axios.post(utils.apiUrl('profile'), payload.data)
        .then((response: any) => {
            action.commit(types.AUTH_UPDATE, { data: response.data });
            action.commit(types.AUTH_IS_ERROR_FREE);
        })
        .catch((error: any) => errorHandler(error, action.commit, types.AUTH_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.AUTH_IS_FREE));
};

// outlets

export const outletsIndex = async (action: Action): Promise<any> => {
    action.commit(types.OUTLETS_IS_BUSY);
    return axios.get(utils.apiUrl('outlets'))
        .then((response: any) => {
            action.commit(types.OUTLETS_INDEX, { data: response.data });
        })
        .catch((error: any) => errorHandler(error, action.commit, types.OUTLETS_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.OUTLETS_IS_FREE));
};

// lotteries

export const lotteriesIndex = async (action: Action): Promise<any> => {
    action.commit(types.LOTTERIES_IS_BUSY);
    return axios.get(utils.apiUrl('lotteries'))
        .then((response: any) => {
            action.commit(types.LOTTERIES_INDEX, { data: response.data });
        })
        .catch((error: any) => errorHandler(error, action.commit, types.OUTLETS_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.LOTTERIES_IS_FREE));
};

// reviews

export const reviewsIndex = async (action: Action): Promise<any> => {
    action.commit(types.REVIEWS_IS_BUSY);
    return axios.get(utils.apiUrl('reviews'))
        .then((response: any) => {
            action.commit(types.REVIEWS_INDEX, { data: response.data });
        })
        .catch((error: any) => errorHandler(error, action.commit, types.REVIEWS_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.REVIEWS_IS_FREE));
};

export const reviewsStore = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.REVIEWS_IS_BUSY);
    return axios.post(utils.apiUrl('reviews'), payload.data)
        .then((response: any) => {
            action.commit(types.REVIEWS_STORE, { data: response.data });
            action.commit(types.REVIEWS_IS_ERROR_FREE);
        })
        .catch((error: any) => errorHandler(error, action.commit, types.REVIEWS_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.REVIEWS_IS_FREE));
};

// banners

export const bannersIndex = async (action: Action): Promise<any> => {
    action.commit(types.BANNERS_IS_BUSY);
    return axios.get(utils.apiUrl('banners'))
        .then((response: any) => {
            action.commit(types.BANNERS_INDEX, { data: response.data });
        })
        .catch((error: any) => errorHandler(error, action.commit, types.BANNERS_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.BANNERS_IS_FREE));
};

// ads

export const adsIndex = async (action: Action): Promise<any> => {
    action.commit(types.ADS_IS_BUSY);
    return axios.get(utils.apiUrl('ads'))
        .then((response: any) => {
            action.commit(types.ADS_INDEX, { data: response.data });
        })
        .catch((error: any) => errorHandler(error, action.commit, types.ADS_IS_ERROR))
        .finally(() => finalHandler(action.commit, types.ADS_IS_FREE));
};
