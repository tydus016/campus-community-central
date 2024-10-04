import React from "react";

import { Button } from "@mui/material";

function MessageDialog({ children, onConfirm = () => {}, onClose = () => {} }) {
    return (
        <div className="message-dialog-container">
            <div className="dialog-header">
                <span className="dialog-icon">
                    <img
                        src="/assets/icons/info-icon.png"
                        alt="info icon"
                        className="dialog-info-icon"
                        draggable="false"
                    />
                </span>

                <div className="close-dialog" onClick={onClose}>
                    <img
                        src="/assets/icons/close-icon.png"
                        alt="close icon"
                        className="dialog-close-icon"
                        draggable="false"
                    />
                </div>
            </div>

            <div className="dialog-body">
                <div className="dialog-message">{children}</div>
            </div>

            <div className="dialog-actions">
                <Button className="dialog-btn" onClick={onConfirm}>
                    Confirm
                </Button>
            </div>
        </div>
    );
}

export default MessageDialog;
