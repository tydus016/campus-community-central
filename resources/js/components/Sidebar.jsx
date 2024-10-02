import React from "react";
import { Link } from "@inertiajs/inertia-react";

import Icon from "../components/Icon";
import sidebarItems from "../../static/sidebarItems.json";

function Sidebar({ isVisible }) {
    const hideShowSubMenu = (e) => {
        const subMenu = e.currentTarget.nextElementSibling;

        if (subMenu.classList.contains("hidden")) {
            subMenu.classList.remove("hidden");
        } else {
            subMenu.classList.add("hidden");
        }
    };

    const RenderSubItem = ({ item }) => {
        const currentUrl = window.location.pathname;
        const isActive = currentUrl === item.url;

        return (
            <Link
                className={`sub-menu-item ${isActive ? "active" : ""}`}
                href={item.url}
            >
                {item.subtitle}
            </Link>
        );
    };

    return (
        <div className={`sidebar-container ${isVisible ? "show" : ""}`}>
            <div className="menu-lists">
                {sidebarItems.map((item, index) => (
                    <div className="menu-item" key={index}>
                        <div className="menu-label" onClick={hideShowSubMenu}>
                            <Icon
                                type={item.icon}
                                className="menu-icon"
                                style={{ fontSize: 25 }}
                            />

                            <span className="menu-title">{item.title}</span>
                        </div>

                        <div className="sub-menu">
                            {item.submenu.length > 0 &&
                                item.submenu.map((subItem, subIndex) => (
                                    <RenderSubItem
                                        key={subIndex}
                                        item={subItem}
                                    />
                                ))}
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}

export default Sidebar;
