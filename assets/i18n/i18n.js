import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';

const en = require('./locales/en.json');
const pl = require('./locales/pl.json');

i18n.use(initReactI18next).init({
  resources: {
    en,
    pl,
  },
  lng: 'pl',
  supportedLngs: ['pl', 'en', 'dev'],
  debug: __DEV__,
  interpolation: {
    escapeValue: false,
  },
});

export default i18n;
