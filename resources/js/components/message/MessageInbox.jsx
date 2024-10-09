import React from "react";

function MessageInbox({ className = "" }) {
    return (
        <div className={`message-inbox ${className}`}>
            <div className="message-list">
                <div className="message-item">
                    <div className="message-leftside">
                        <div className="message-icon-placeholder">
                            <img
                                src="/assets/icons/category_icon.png"
                                alt="category icon"
                                draggable="false"
                            />
                        </div>

                        <div className="message-item-content">
                            <p className="message-item-title">Name</p>
                            <div className="message-item-msg">
                                Supporting line text lorem ipsum dolor sit amet,
                                consectetur.
                            </div>
                        </div>
                    </div>

                    <div className="message-rightside">
                        <div className="message-time">12 min</div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default MessageInbox;
