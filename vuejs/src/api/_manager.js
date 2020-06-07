import axios from 'axios';
import store from '../store';
import DEFINES from '@/defines';

const HASH_ALGO = 'sha256';
const BASE_API_URL = DEFINES.BASE_API_URL;
const BUILD_MODE = DEFINES.BUILD_MODE;

async function callApi(url, payload) {
  store.dispatch('app/showLoader');
  return axios
    .post(BASE_API_URL + url, payload, buildHeaders())
    .then((response) => {
      return parseResponse(response);
    })
    .catch((error) => {
      throw error;
    })
    .finally(() => {
      store.dispatch('app/hideLoader');
    });
}

const buildHeaders = () => ({
  headers: {
    Authorization: 'Bearer ' + getAuthHash(),
  },
});

const getAuthHash = () => {
  let nonce = require('nonce')();
  let timestamp = '1' + nonce();
  let key = store.state.auth.key;
  let secret = store.state.auth.secret;

  let hash = null;
  if (key && secret) {
    let signature = key + secret + timestamp;
    hash = doHash(signature);
  }

  let payload = {
    key: key,
    timestamp: timestamp,
    hash: hash,
    build_mode: BUILD_MODE,
  };

  return JSON.stringify(payload);
};

const doHash = (req) => {
  let shajs = require('sha.js');
  return shajs(HASH_ALGO)
    .update(req)
    .digest('hex');
};

const parseResponse = (response) => {
  if (response.data.error) {
    return handleError(response.data.error);
  }
  if (response.status == 200) {
    return response.data.data;
  }
  throw {title: 'Unknown API response'};
};

const handleError = (error) => {
  throw error;
};
export {callApi, getAuthHash};
