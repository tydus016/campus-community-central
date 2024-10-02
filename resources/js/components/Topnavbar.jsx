import React, { useState, useContext } from "react";
import { AppContext } from "../contexts/AppContext";

import Icon from "./Icon";
import { Link } from "@inertiajs/inertia-react";

function Topnavbar(props) {
    const { state, updateTheme, updateMenuState } = useContext(AppContext);

    const [menuState, setMenuState] = useState(state.menuState);
    const [theme, setTheme] = useState(state.theme);

    const onMenuToggle = (state) => {
        updateMenuState(state);
        setMenuState(state);
    };

    const onThemeChange = (theme) => {
        updateTheme(theme);
        setTheme(theme);
    };

    const MenuIcon = () => {
        return (
            <Icon
                className="navbar-icon"
                type={menuState ? "MenuOpen" : "Menu"}
                style={{ fontSize: 40 }}
                onClick={() => onMenuToggle(!menuState)}
            />
        );
    };

    const ThemeModeIcon = () => {
        return (
            <Icon
                type={theme === "light" ? "DarkMode" : "LightMode"}
                className="navbar-icon"
                style={{ fontSize: 30 }}
                onClick={() =>
                    onThemeChange(theme === "light" ? "dark" : "light")
                }
            />
        );
    };

    return (
        <div className="topNavbar">
            <div className="topNav-leftside">
                <Link className="topNavbar-tagline" href="/dashboard">
                    <p className="tagline-text">
                        <span className="tagline-title">EdsTech</span> <br />
                        <span className="tagline-subtitle">
                            POS - Admin Dashboard
                        </span>
                    </p>
                </Link>
                <MenuIcon />
            </div>

            <div className="topNav-rightside">
                <ThemeModeIcon />
            </div>
        </div>
    );
}

export default Topnavbar;
