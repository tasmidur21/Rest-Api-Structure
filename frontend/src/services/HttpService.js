import axios from "axios";
import AuthService from "./AuthService";

const HttpMethods = {
    GET: 'GET',
    POST: 'POST',
    PUT: 'PUT',
    PATCH: 'PATCH',
    DELETE: 'DELETE',
};

const _axios = axios.create();

const configure = () => {
    _axios.interceptors.request.use((config) => {
        if (AuthService.isLoggedIn()) {
            const cb = () => {
                config.headers.Authorization = `Bearer ${AuthService.getToken()}`;
                return Promise.resolve(config);
            };
            return AuthService.updateToken(cb);
        }
    });
};

const getAxiosClient = () => _axios;

const HttpService = {
    HttpMethods,
    configure,
    getAxiosClient,
};

export default HttpService;
