import React, { createContext, useState } from "react";

export const AppContext = createContext();

export const AppProvider = ({ children }) => {
    const [state, setState] = useState({
        theme: "light",
        menuState: true,
        subMenuState: false,

        usersListsFilters: {
            account_type: "",
            account_status: "",
            delete_flg: "",
            from_date: "",
            to_date: "",
        },
    });

    const updateTheme = (theme) => {
        setState((prevState) => ({ ...prevState, theme }));
    };

    const updateMenuState = (menuState) => {
        setState((prevState) => ({ ...prevState, menuState }));
    };

    const updateUsersListsFilters = (usersListsFilters) => {
        setState((prevState) => ({ ...prevState, usersListsFilters }));
    };

    const exports = {
        state,
        setState,
        updateTheme,
        updateMenuState,
        updateUsersListsFilters,
    };

    return (
        <AppContext.Provider value={exports}>{children}</AppContext.Provider>
    );
};
