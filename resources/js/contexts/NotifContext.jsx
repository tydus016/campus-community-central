import React, { createContext, useState } from "react";

export const NotifContext = createContext();

export const NotifProdiver = ({ children }) => {
    const [notifState, setState] = useState({
        show: false,
        data: [],
    });

    const showNotifBar = () => {
        setState((prevState) => ({ ...prevState, show: true }));
    };

    const hideNotifBar = () => {
        setState((prevState) => ({ ...prevState, show: false }));
    };

    const setNotifShowState = (state) => {
        setState((prevState) => ({ ...prevState, show: state }));
    };

    const setNotifData = (data = []) => {
        setState((prevState) => ({ ...prevState, data: data }));
    };

    const exports = {
        notifState,
        setState,
        showNotifBar,
        hideNotifBar,
        setNotifData,
        setNotifShowState,
    };

    return (
        <NotifContext.Provider value={exports}>
            {children}
        </NotifContext.Provider>
    );
};
