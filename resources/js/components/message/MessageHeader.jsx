import React from "react";

import Icon from "../Icon";

function MessageHeader(props) {
    return (
        <div className="message-chat-header">
            <div className="chat-header-left">
                <img
                    src="/assets/icons/profile_account_icon.png"
                    alt="convo profile image"
                    className="convo-profileimage"
                    draggable="false"
                />

                <div className="chat-sender-name">
                    <p>John Doe</p>
                </div>
            </div>

            <div className="chat-header-right">
                <span className="chat-option">
                    <Icon type="Notifications" />
                </span>

                <span className="chat-option">
                    <Icon type="Settings" />
                </span>
            </div>
        </div>
    );
}

export default MessageHeader;
