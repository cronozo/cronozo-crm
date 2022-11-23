import { isNonEmptyString } from './primitiveChecks';

const THEME_TYPE_ASYNC_KEY = 'themeType';
const USER_TOKEN_ASYNC_KEY = 'userToken';

const saveValue = async (key, value) => {
  try {
    if (isNonEmptyString(value)) {
      await localStorage.setItem(key, value);
    } else {
      await localStorage.removeItem(key);
    }
    return true;
  } catch (e) {
    // saving error
    return false;
  }
};

export const loadValue = key => {
  try {
    return localStorage.getItem(key);
  } catch (e) {
    // error reading value
    return null;
  }
};

export const saveUserToken = async token =>
  saveValue(USER_TOKEN_ASYNC_KEY, token);

export const loadUserToken = async () =>
  loadValue(USER_TOKEN_ASYNC_KEY);

export const saveThemeType = async themeType =>
  saveValue(THEME_TYPE_ASYNC_KEY, themeType);

export const loadThemeType = async () => loadValue(THEME_TYPE_ASYNC_KEY);
