const REQUEST = 'REQUEST';
const LOADING = 'LOADING';
const SUCCESS = 'SUCCESS';
const FAILURE = 'FAILURE';

const suffixTypes = [REQUEST, LOADING, SUCCESS, FAILURE];

function createRequestTypes(prefix, bases, suffixes = suffixTypes) {
    const req = {};
    bases.forEach(base => {
        suffixes.forEach(suffix => {
            req[`${base}_${suffix}`] = `${prefix}_${base}_${suffix}`;
        });
    });
    return req;
}

// Events related to REST API
export const APP = createRequestTypes(
    'APP',
    [
        'INIT_APP',
        'HOME_DATA',
        /**
         * ==========================================
         * =================== @ ====================
         * ==========================================
         */
    ],
    suffixTypes,
);

export const USER_LOGGED_IN_STATUS = 'IS_USER_LOGGED_IN';
// ---
export const LOGIN_SUCCESS = 'LOGIN_SUCCESS';
export const ACTION_USER_LOGOUT = 'USER_LOGOUT';
