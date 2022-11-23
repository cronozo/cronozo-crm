import './styles/main.scss';
import React from "react";
import ReactDOM from "react-dom";
import { Provider as StoreProvider } from 'react-redux';
import {I18nextProvider} from "react-i18next";
import {BrowserRouter, createBrowserRouter, Route, RouterProvider, Routes} from "react-router-dom";
import i18n from "./i18n";
import store from './store';
import {createRoot} from "react-dom/client";

const router = createBrowserRouter([
    {
        path: '/',
        element: <div>Test</div>,
    }
])

const container = document.getElementById("root");
const root = createRoot(container);

root.render(
    <StoreProvider store={store}>
        <I18nextProvider i18n={i18n}>
            <RouterProvider router={router} />
        </I18nextProvider>
    </StoreProvider>
);
