import { takeLatest, put } from 'redux-saga/effects';
import { api } from '../../api';
import { APP, USER_LOGGED_IN_STATUS } from '../../constants';
import { appOptions } from '../../config/app';
import { loadUserToken } from '../../utils';
import i18n from '../../i18n';

function* initApp() {
    if (api.isConfigured()) {
        return;
    }

    try {
        yield put({ type: APP.INIT_APP_LOADING });
        api.init(appOptions);
        api.setCurrentLocale(i18n.language);
        yield put({ type: APP.INIT_APP_SUCCESS });
        const userToken = yield loadUserToken();
        api.setUserToken(userToken);
        if (userToken) {
            yield put({ type: USER_LOGGED_IN_STATUS, payload: { loggedIn: true } });
        }
    } catch (error) {
        console.error(error);
        yield put({
            type: APP.INIT_APP_FAILURE,
            payload: {
                errorCode: error.name,
                errorMessage: error.message,
            },
        });
    }
}

export default function* watcherSaga() {
    yield takeLatest(APP.INIT_APP_REQUEST, initApp);
}
