import axios from 'axios';
import user from './lib/user';
import Logger from './apiLogger';
import { USER_TYPE, GUEST_TYPE } from './types';
import i18n from '../i18n';

const defaultOptions = {
    url: null,
    userAgent: 'CRONOZO-CRM APP',
};

class API {
    configuration;

    baseUrl;

    userToken = null;

    user = undefined;

    currentLocale = undefined;

    configured = false;

    init(options) {
        this.configuration = { ...defaultOptions, ...options };
        this.baseUrl = this.configuration.url;
        this.user = user(this);
        this.configured = true;
    }

    setUserToken(token) {
        this.userToken = token;
    }

    setCurrentLocale(locale) {
        this.currentLocale = locale;
    }

    get(path, params, data, type = GUEST_TYPE) {
        return this.send(path, 'GET', params, data, type);
    }

    post(path, params, data, type = GUEST_TYPE) {
        return this.send(path, 'POST', params, data, type);
    }

    send(path, method, params, data, type) {
        const url = `${this.baseUrl}/api/${path}`;

        const headers = {
            'User-Agent': this.configuration.userAgent,
            'Content-Type': 'application/json',
        };

        if (this.userToken !== null && type === USER_TYPE) {
            headers.Authorization = `Bearer ${this.userToken}`;
        }

        return new Promise((resolve, reject) => {
            Logger.describeRequest({ url, method, headers, params, data });
            axios({
                url,
                method,
                headers,
                params,
                data,
            })
                .then(response => {
                    Logger.describeSuccessResponse(response);
                    resolve(response.data);
                })
                .catch(error => {
                    Logger.describeErrorResponse(error);
                    if (error.response) {
                        if (error.response.status === 404 && error.response.data == null) {
                            reject();
                            return;
                        }
                    } else if (error.request) {
                        // The request was made but no response was received
                        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                        // http.ClientRequest in node.js
                        const noResponseError = noResponseFromServerError();
                        reject(noResponseError);
                        return;
                    } else {
                        // Something happened in setting up the request that triggered an Error
                    }

                    let customError;
                    if (
                        typeof error.response.data === 'object' &&
                        error.response.data !== null
                    ) {
                        customError = API.extractErrorMessage(error.response.data);
                    } else {
                        customError = pageNotFoundError();
                    }
                    reject(customError);
                });
        });
    }

    static extractErrorMessage(data) {
        const { parameters } = data;
        let { message } = data;

        if (parameters && Array.isArray(parameters) && parameters.length > 0) {
            parameters.forEach((item, index) => {
                message = message.replace(`%${index + 1}`, item);
            });
        } else if (parameters && parameters instanceof Object) {
            Object.keys(parameters).forEach(parameter => {
                message = message.replace(`%${parameter}`, parameters[parameter]);
            });
        }

        return { message };
    }

    isConfigured() {
        return this.configured;
    }
}

function integrationTokenError() {
    const name = i18n.t('errors.integrationTokenRequired');
    const message = i18n.t('errors.integrationTokenRequiredMessage');
    return createError(name, message);
}

function noResponseFromServerError() {
    const name = i18n.t('errors.noResponseFromServer');
    const message = i18n.t('errors.noResponseFromServerMessage');
    return createError(name, message);
}

function pageNotFoundError() {
    const name = i18n.t('errors.404error');
    const message = i18n.t('errors.404errorMessage');
    return createError(name, message);
}

function createError(name, message) {
    const error = new Error();
    error.name = name;
    error.message = message;
    return error;
}

export const USER_TOKEN = 'userToken';

export const api = new API();
