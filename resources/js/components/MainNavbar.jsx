import React, { useContext, useEffect } from "react";

import { TextField, InputAdornment } from "@mui/material";
import { Link, Inertia } from "@inertiajs/inertia-react";

import Icon from "./Icon";

import navLists from "../../static/main_nav_items_lists.json";

import {
    NotifWrapper,
    NotifItem,
    NotifContent,
    NotifMoreOptions,
} from "./Notifications";

import { NotifContext } from "../contexts/NotifContext";
import { MsgNotifContext } from "../contexts/MessageNotifContext";

import sampleNotifs from "../../static/sample_notifs.json";
import sampleMsgNotifs from "../../static/sample_msg_notifs.json";

function MainNavbar(props) {
    const { notifState, setNotifShowState, setNotifData } =
        useContext(NotifContext);

    const { msgNotifState, setMsgNotifShowState, setMsgNotifData } =
        useContext(MsgNotifContext);

    const searchBarStyle = {
        "& .MuiOutlinedInput-root": {
            borderRadius: "28px",
            border: "none",
            "& fieldset": {
                border: "none",
            },
            "&:hover fieldset": {
                border: "none",
            },
            "&.Mui-focused fieldset": {
                border: "none",
            },
        },
    };

    const searchBarProps = {
        endAdornment: (
            <InputAdornment position="end">
                <Icon className="search-icon" type="Search" />
            </InputAdornment>
        ),
    };

    const onNavigateClick = (navItem) => (e) => {
        if (!navItem.is_link) {
            e.preventDefault();
        }

        switch (navItem.name) {
            case "notification":
                onNotifClick();
                break;
            case "message":
                onMessageClick();
                break;

            default:
                break;
        }
    };

    const onNotifClick = () => {
        setNotifShowState(!notifState.show);
        setMsgNotifShowState(false);
    };

    const onMessageClick = () => {
        setMsgNotifShowState(!msgNotifState.show);
        setNotifShowState(false);
    };

    useEffect(() => {
        if (notifState.show && notifState.data.length === 0) {
            setNotifData(sampleNotifs);
        }
    }, [notifState.show]);

    useEffect(() => {
        if (msgNotifState.show && msgNotifState.data.length === 0) {
            setMsgNotifData(sampleMsgNotifs);
        }
    }, [msgNotifState.show]);

    return (
        <div className="main-navbar">
            <div className="main-top-navbar">
                <div className="navbar-branding">
                    <img
                        src="/assets/logos/ccc-log-alternate.png"
                        alt="ccc-logo"
                    />
                    <span className="branding-text">
                        CAMPUS COMMUNITY CENTRAL
                    </span>
                </div>

                <div className="navbar-searchbar">
                    <TextField
                        variant="outlined"
                        type="text"
                        className="navbar-search-input"
                        placeholder="Search"
                        sx={searchBarStyle}
                        InputProps={searchBarProps}
                    />
                </div>

                <div className="navbar-links main-nav">
                    {navLists.map((navItem, index) => (
                        <Link
                            key={index}
                            className="nav-link"
                            href={navItem.link}
                            onClick={onNavigateClick(navItem)}
                        >
                            <img
                                src={navItem.icon}
                                alt={navItem.title}
                                className="nav-link-icon"
                                draggable="false"
                            />
                        </Link>
                    ))}

                    <Link className="nav-link logout">
                        <img
                            src="/assets/icons/logout_icon.png"
                            alt="logout icon"
                            className="nav-link-icon"
                            draggable="false"
                        />
                    </Link>
                </div>
            </div>

            {notifState.show && (
                <NotifWrapper>
                    {notifState.data.map((notif, index) => (
                        <NotifItem key={index}>
                            <NotifContent
                                title={notif.title}
                                msg={notif.message}
                            />

                            <NotifMoreOptions
                                onClick={() => console.log("oten")}
                            />
                        </NotifItem>
                    ))}
                </NotifWrapper>
            )}

            {msgNotifState.show && (
                <NotifWrapper>
                    {msgNotifState.data.map((notif, index) => (
                        <NotifItem key={index}>
                            <NotifContent
                                title={notif.title}
                                msg={notif.message}
                            />

                            <NotifMoreOptions
                                onClick={() => console.log("oten")}
                            />
                        </NotifItem>
                    ))}
                </NotifWrapper>
            )}
        </div>
    );
}

export default MainNavbar;
