import * as ApiManager from './_manager';

export const task = {
  create: payload => {
    return ApiManager.callApi ('/member/todo/create', payload);
  },
};
