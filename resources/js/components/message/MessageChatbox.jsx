import React from "react";

import { TextField, InputAdornment } from "@mui/material";
import Icon from "../Icon";

function MessageChatbox(props) {
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

    return (
        <div className="message-chat-box">
            <div className="chat-box-left">
                <span className="chat-box-option">
                    <Icon type="AddCircle" />
                </span>

                <span className="chat-box-option">
                    <Icon type="Mood" />
                </span>
            </div>

            <div className="chat-box-right">
                <TextField
                    variant="outlined"
                    className="chat-box-input"
                    placeholder="Tt"
                    sx={searchBarStyle}
                    InputProps={{
                        endAdornment: (
                            <InputAdornment position="end">
                                <div className="eye-password">
                                    <Icon type="Mic" />
                                </div>
                            </InputAdornment>
                        ),
                    }}
                />
            </div>
        </div>
    );
}

export default MessageChatbox;
