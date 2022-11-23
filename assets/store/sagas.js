import { fork } from 'redux-saga/effects';
import appSagas from './app/appSagas';

export default function* root() {
    yield fork(appSagas);
}
