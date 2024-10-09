import React from "react";

import { TextField } from "@mui/material";

import Icon from "../Icon";

function CreatePostCard({ onPost = () => {} }) {
    return (
        <div className="create-post-card">
            <div className="create-post-card-content">
                <div className="create-post-card-header">
                    <h1>create post</h1>
                </div>

                <div className="create-post-card-body">
                    <div className="input-text-area">
                        <div className="create-post-input title">
                            <TextField
                                variant="outlined"
                                className="auth-input"
                                placeholder="Title"
                            />
                        </div>

                        <Icon type="ImageOutlined" />
                    </div>

                    <div className="input-text-area">
                        <div className="create-post-input definition">
                            <TextField
                                variant="outlined"
                                className="auth-input definition"
                                placeholder="Definition"
                            />
                        </div>

                        <div className="create-post-btn" onClick={onPost}>
                            <span>post</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default CreatePostCard;
