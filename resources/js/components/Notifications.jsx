import React from "react";

import Icon from "./Icon";

export const NotifWrapper = ({ children }) => {
    return (
        <div className="notifs-wrapper">
            <div className="notifs-list">{children}</div>
        </div>
    );
};

export const AdminNotifWrapper = ({ children }) => {
    return (
        <div className="admin-notifs-wrapper">
            <div className="notifs-list">{children}</div>
        </div>
    );
};

export const NotifItem = ({ children }) => {
    return <div className="notifs-item">{children}</div>;
};

export const NotifContent = ({ title, msg, className = "" }) => {
    return (
        <div className="notifs-item-left">
            <div className="notifs-icon-wrapper">
                <Icon type="Category" className="notifs-icon" />
            </div>
            <div className={`notif-content ${className}`}>
                <p className="notif-content-title">{title}</p>
                <p className="notif-content-msg">{msg}</p>
            </div>
        </div>
    );
};

export const NotifMoreOptions = ({ onClick = () => {} }) => {
    return (
        <div className="notifs-item-right">
            <Icon
                type="MoreVert"
                className="notifs-more-icon"
                onClick={onClick}
            />
        </div>
    );
};

function Notifications({ children }) {
    return (
        <div className="notifs-wrapper">
            <div className="notifs-list">
                <div className="notifs-item">
                    <div className="notifs-item-left">
                        <div className="notifs-icon-wrapper">
                            <Icon type="Category" className="notifs-icon" />
                        </div>
                        <div className="notif-content">
                            <p className="notif-content-title">List item</p>
                            <p className="notif-content-msg">
                                Supporting line text lorem ipsum dolor sit amet,
                                consectetur.
                            </p>
                        </div>
                    </div>

                    <div className="notifs-item-right">
                        <Icon type="MoreVert" className="notifs-more-icon" />
                    </div>
                </div>
            </div>
        </div>
    );
}

export default {
    NotifWrapper,
    NotifItem,
    NotifContent,
    NotifMoreOptions,
    AdminNotifWrapper,
};
