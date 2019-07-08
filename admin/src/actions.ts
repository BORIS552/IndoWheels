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
    if (error.response.data && error.response.data.errors) {
        data = error.response.data.errors;
    }
    return commit(type, { data });
}

function finalHandler(commit: any, type: string) {
    commit(type);
}

// auth

export const authUser = async (action: Action): Promise<any> => {
    action.commit(types.AUTH_IS_BUSY);
    return axios.get(utils.apiUrl('auth/user'))
    .then((response) => {
        action.commit(types.AUTH_STORE, { data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.AUTH_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.AUTH_IS_FREE));
};

export const authLogin = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.AUTH_IS_BUSY);
    return axios.post(utils.apiUrl('auth/admin/login'), payload.data)
    .then((response) => {
        action.commit(types.AUTH_STORE, { data: response.data });
        action.commit(types.AUTH_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.AUTH_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.AUTH_IS_FREE));
};

export const authLogout = (action: Action, payload: Payload): void => {
    action.commit(types.AUTH_DESTROY);
};

// profile

export const updateProfile = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.AUTH_IS_BUSY);
    return axios.post(utils.apiUrl('profile'), payload.data)
    .then((response) => {
        action.commit(types.AUTH_UPDATE, { data: response.data });
        action.commit(types.AUTH_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.AUTH_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.AUTH_IS_FREE));
};

// users

export const usersIndex = async (action: Action): Promise<any> => {
    action.commit(types.USERS_IS_BUSY);
    return axios.get(utils.apiUrl('users'))
    .then((response) => {
        action.commit(types.USERS_INDEX, { data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.USERS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.USERS_IS_FREE));
};

export const usersStore = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.USERS_IS_BUSY);
    return axios.post(utils.apiUrl('users'), payload.data)
    .then((response) => {
        action.commit(types.USERS_IS_ERROR_FREE);
        action.commit(types.USERS_STORE, { data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.USERS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.USERS_IS_FREE));
};

export const usersUpdate = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.USERS_IS_BUSY);
    return axios.post(utils.apiUrl(`users/${payload.id}`), payload.data)
    .then((response) => {
        action.commit(types.USERS_IS_ERROR_FREE);
        action.commit(types.USERS_UPDATE, { id: payload.id, data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.USERS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.USERS_IS_FREE));
};

export const usersDestroy = async (action: Action, payload: Payload): Promise<any> => {
    axios.delete(utils.apiUrl(`users/${payload.id}`));
    action.commit(types.USERS_DESTROY, { id: payload.id });
    // action.commit(types.USERS_IS_BUSY);
    // return axios.delete('users', { data: { id: payload.id } })
    // .then((response) => {
    //     action.commit(types.USERS_DESTROY, { index: payload.index });
    // })
    // .catch((error) => errorHandler(error, action.commit, types.USERS_IS_ERROR))
    // .finally(() => finalHandler(action.commit, types.USERS_IS_FREE));
};

// outlets

export const outletsIndex = async (action: Action): Promise<any> => {
    action.commit(types.OUTLETS_IS_BUSY);
    return axios.get(utils.apiUrl('outlets'))
    .then((response) => {
        action.commit(types.OUTLETS_INDEX, { data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.OUTLETS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.OUTLETS_IS_FREE));
};

export const outletsStore = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.OUTLETS_IS_BUSY);
    return axios.post(utils.apiUrl('outlets'), payload.data)
    .then((response) => {
        action.commit(types.OUTLETS_STORE, { data: response.data });
        action.commit(types.OUTLETS_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.OUTLETS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.OUTLETS_IS_FREE));
};

export const outletsUpdate = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.OUTLETS_IS_BUSY);
    return axios.patch(utils.apiUrl(`outlets/${payload.id}`), payload.data)
    .then((response) => {
        action.commit(types.OUTLETS_UPDATE, { id: payload.id, data: response.data });
        action.commit(types.OUTLETS_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.OUTLETS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.OUTLETS_IS_FREE));
};

export const outletsDestroy = async (action: Action, payload: Payload): Promise<any> => {
    axios.delete(utils.apiUrl(`outlets/${payload.id}`));
    action.commit(types.OUTLETS_DESTROY, payload);
    // action.commit(types.OUTLETS_IS_BUSY);
    // return axios.delete(utils.apiUrl(`outlets/${payload.id}`), { data: { id: payload.id } })
    // .then((response) => {
    //     action.commit(types.OUTLETS_DESTROY, payload);
    // })
    // .catch((error) => errorHandler(error, action.commit, types.OUTLETS_IS_ERROR))
    // .finally(() => finalHandler(action.commit, types.OUTLETS_IS_FREE));
};

// lotteries

export const lotteriesIndex = async (action: Action): Promise<any> => {
    action.commit(types.LOTTERIES_IS_BUSY);
    return axios.get(utils.apiUrl('lotteries'))
    .then((response) => {
        action.commit(types.LOTTERIES_INDEX, { data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.OUTLETS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.LOTTERIES_IS_FREE));
};

export const lotteriesStore = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.LOTTERIES_IS_BUSY);
    return axios.post(utils.apiUrl('lotteries'), payload.data)
    .then((response) => {
        action.commit(types.LOTTERIES_STORE, { data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.LOTTERIES_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.LOTTERIES_IS_FREE));
};

export const lotteriesUpdate = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.LOTTERIES_IS_BUSY);
    return axios.patch(utils.apiUrl(`lotteries/${payload.id}`), payload.data)
    .then((response) => {
        action.commit(types.LOTTERIES_UPDATE, { id: payload.id, data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.LOTTERIES_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.LOTTERIES_IS_FREE));
};

export const lotteriesSendSms = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.LOTTERIES_IS_BUSY);
    return axios.patch(utils.apiUrl(`lotteries/${payload.id}`), payload.data)
    .then((response) => {
        action.commit(types.LOTTERIES_UPDATE, { id: payload.id, data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.LOTTERIES_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.LOTTERIES_IS_FREE));
};

export const lotteriesDestroy = async (action: Action, payload: Payload): Promise<any> => {
    axios.delete(utils.apiUrl(`lotteries/${payload.id}`));
    action.commit(types.LOTTERIES_DESTROY, payload);
    // action.commit(types.LOTTERIES_IS_BUSY);
    // return axios.delete('lottereis', { data: { id: payload.id } })
    // .then((response) => {
    //     action.commit(types.LOTTERIES_DESTROY, { index: payload.index });
    // })
    // .catch((error) => errorHandler(error, action.commit, types.LOTTERIES_IS_ERROR))
    // .finally(() => finalHandler(action.commit, types.LOTTERIES_IS_FREE));
};

// reviews

export const reviewsIndex = async (action: Action): Promise<any> => {
    action.commit(types.REVIEWS_IS_BUSY);
    return axios.get(utils.apiUrl('reviews'))
    .then((response) => {
        action.commit(types.REVIEWS_INDEX, { data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.REVIEWS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.REVIEWS_IS_FREE));
};

export const reviewsStore = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.REVIEWS_IS_BUSY);
    return axios.post(utils.apiUrl('reviews'), payload.data)
    .then((response) => {
        action.commit(types.REVIEWS_STORE, { data: response.data });
        action.commit(types.REVIEWS_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.REVIEWS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.REVIEWS_IS_FREE));
};

export const reviewsUpdate = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.REVIEWS_IS_BUSY);
    return axios.post(utils.apiUrl(`reviews/${payload.id}`), payload.data)
    .then((response) => {
        action.commit(types.REVIEWS_UPDATE, { id: payload.id, data: response.data });
        action.commit(types.REVIEWS_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.REVIEWS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.REVIEWS_IS_FREE));
};

export const reviewsDestroy = async (action: Action, payload: Payload): Promise<any> => {
    axios.delete(utils.apiUrl(`reviews/${payload.id}`));
    action.commit(types.REVIEWS_DESTROY, payload);
};

// banners

export const bannersIndex = async (action: Action): Promise<any> => {
    action.commit(types.BANNERS_IS_BUSY);
    return axios.get(utils.apiUrl('banners'))
    .then((response) => {
        action.commit(types.BANNERS_INDEX, { data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.BANNERS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.BANNERS_IS_FREE));
};

export const bannersStore = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.BANNERS_IS_BUSY);
    return axios.post(utils.apiUrl('banners'), payload.data)
    .then((response) => {
        action.commit(types.BANNERS_STORE, { data: response.data });
        action.commit(types.BANNERS_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.BANNERS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.BANNERS_IS_FREE));
};

export const bannersUpdate = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.BANNERS_IS_BUSY);
    return axios.post(utils.apiUrl(`banners/${payload.id}`), payload.data)
    .then((response) => {
        action.commit(types.BANNERS_UPDATE, { id: payload.id, data: response.data });
        action.commit(types.BANNERS_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.BANNERS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.BANNERS_IS_FREE));
};

export const bannersDestroy = async (action: Action, payload: Payload): Promise<any> => {
    axios.delete(utils.apiUrl(`banners/${payload.id}`));
    action.commit(types.BANNERS_DESTROY, payload);
};

// ads

export const adsIndex = async (action: Action): Promise<any> => {
    action.commit(types.ADS_IS_BUSY);
    return axios.get(utils.apiUrl('ads'))
    .then((response) => {
        action.commit(types.ADS_INDEX, { data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.ADS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.ADS_IS_FREE));
};

export const adsStore = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.ADS_IS_BUSY);
    return axios.post(utils.apiUrl('ads'), payload.data)
    .then((response) => {
        action.commit(types.ADS_STORE, { data: response.data });
        action.commit(types.ADS_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.ADS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.ADS_IS_FREE));
};

export const adsUpdate = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.ADS_IS_BUSY);
    return axios.post(utils.apiUrl(`ads/${payload.id}`), payload.data)
    .then((response) => {
        action.commit(types.ADS_UPDATE, { id: payload.id, data: response.data });
        action.commit(types.ADS_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.ADS_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.ADS_IS_FREE));
};

export const adsDestroy = async (action: Action, payload: Payload): Promise<any> => {
    axios.delete(utils.apiUrl(`ads/${payload.id}`));
    action.commit(types.ADS_DESTROY, payload);
};

// prizes

export const prizesIndex = async (action: Action): Promise<any> => {
    action.commit(types.PRIZES_IS_BUSY);
    return axios.get(utils.apiUrl('prizes'))
    .then((response) => {
        action.commit(types.PRIZES_INDEX, { data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.PRIZES_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.PRIZES_IS_FREE));
};

export const prizesDestroy = async (action: Action, payload: Payload): Promise<any> => {
    axios.delete(utils.apiUrl(`prizes/${payload.id}`));
    action.commit(types.PRIZES_DESTROY, payload);
};


// images

export const imagesIndex = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.IMAGES_IS_BUSY);
    return axios.get(utils.apiUrl(`users/${payload.userId}/images`))
    .then((response) => {
        action.commit(types.IMAGES_INDEX, { data: response.data });
    })
    .catch((error) => errorHandler(error, action.commit, types.IMAGES_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.IMAGES_IS_FREE));
};

export const imagesStore = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.IMAGES_IS_BUSY);
    return axios.post(utils.apiUrl(`users/${payload.userId}/images`), payload.data)
    .then((response) => {
        action.commit(types.IMAGES_STORE, { data: response.data });
        action.commit(types.IMAGES_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.IMAGES_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.IMAGES_IS_FREE));
};

export const imagesUpdate = async (action: Action, payload: Payload): Promise<any> => {
    action.commit(types.IMAGES_IS_BUSY);
    return axios.post(utils.apiUrl(`users/${payload.userId}/images/${payload.id}`), payload.data)
    .then((response) => {
        action.commit(types.IMAGES_UPDATE, { id: payload.id, data: response.data });
        action.commit(types.IMAGES_IS_ERROR_FREE);
    })
    .catch((error) => errorHandler(error, action.commit, types.IMAGES_IS_ERROR))
    .finally(() => finalHandler(action.commit, types.IMAGES_IS_FREE));
};

export const imagesDestroy = async (action: Action, payload: Payload): Promise<any> => {
    axios.delete(utils.apiUrl(`users/${payload.userId}/images/${payload.id}`));
    action.commit(types.IMAGES_DESTROY, payload);
};
