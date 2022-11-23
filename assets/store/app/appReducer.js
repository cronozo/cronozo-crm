import { APP } from '../../constants';
import Status from '../../api/Status';

const INITIAL_STATE = {
    storeConfigStatus: Status.DEFAULT,
};

export default (state = INITIAL_STATE, { type, payload }) => {
    switch (type) {
        case APP.INIT_APP_LOADING:
            return {
                ...state,
                storeConfigStatus: Status.LOADING,
            };
        case APP.INIT_APP_SUCCESS:
            return {
                ...state,
                storeConfigStatus: Status.SUCCESS,
            };
        case APP.INIT_APP_FAILURE:
            return {
                ...state,
                storeConfigStatus: Status.ERROR,
                errorMessage: payload.errorMessage,
            };
        default:
            return state;
    }
};
