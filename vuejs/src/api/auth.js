import * as ApiManager from './_manager';

export const auth = {
  login: (payload) => {
    return ApiManager.callApi('/guest/auth/login', payload);
  },
  verify: (payload) => {
    return ApiManager.callApi('/guest/auth/verify', payload);
  },
};
