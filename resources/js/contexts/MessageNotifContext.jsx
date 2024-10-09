import React, { createContext, useState } from "react";

export const MsgNotifContext = createContext();

export const MessageNotifProdiver = ({ children }) => {
    const [msgNotifState, setState] = useState({
        show: false,
        data: [],
    });

    const showMsgNotifBar = () => {
        setState((prevState) => ({ ...prevState, show: true }));
    };

    const hideMsgNotifBar = () => {
        setState((prevState) => ({ ...prevState, show: false }));
    };

    const setMsgNotifShowState = (state) => {
        setState((prevState) => ({ ...prevState, show: state }));
    };

    const setMsgNotifData = (data = []) => {
        setState((prevState) => ({ ...prevState, data: data }));
    };

    const exports = {
        msgNotifState,
        setState,
        showMsgNotifBar,
        hideMsgNotifBar,
        setMsgNotifData,
        setMsgNotifShowState,
    };

    return (
        <MsgNotifContext.Provider value={exports}>
            {children}
        </MsgNotifContext.Provider>
    );
};
