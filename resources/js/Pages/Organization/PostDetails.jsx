import React from "react";

import { TextField, InputAdornment } from "@mui/material";
import MainLayout from "../../Layouts/MainLayout";
import MainWrapper from "../../components/MainWrapper";
import { Link } from "@inertiajs/inertia-react";

import PostDetailCard from "../../components/organization/PostDetailCard";

import Icon from "../../components/Icon";

function PostDetails(props) {
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
        <MainLayout>
            <MainWrapper className="post-details-wrapper">
                <PostDetailCard showCommentBtn={false} />

                <div className="post-comments-wrapper">
                    <div className="post-comment-list">
                        <div className="post-comment-item">
                            <div className="comment-header">
                                <p className="commenter-name">Juan Dela Cruz</p>

                                <div className="post-detail-card-head">
                                    <div className="div-post-datetime-detail">
                                        <span>Jun 10, 2024</span>
                                    </div>

                                    <div className="div-post-datetime-detail">
                                        <span>9:41 AM</span>
                                    </div>
                                </div>
                            </div>

                            <div className="comment-body">
                                <div className="post-definition-body">
                                    <div className="post-definition">
                                        Lorem, ipsum dolor sit amet consectetur
                                        adipisicing elit. Quam magnam recusandae
                                        minima alias maxime, ab accusamus error
                                        laborum voluptas dolorum, illum
                                        distinctio voluptatem perferendis enim
                                        excepturi aut, quasi ad nobis.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="comment-box">
                        <TextField
                            variant="outlined"
                            className="chat-box-input"
                            placeholder="Tt"
                            sx={searchBarStyle}
                            InputProps={{
                                endAdornment: (
                                    <InputAdornment position="end">
                                        <div className="eye-password">
                                            <Icon type="SendOutlined" />
                                        </div>
                                    </InputAdornment>
                                ),
                            }}
                        />
                    </div>
                </div>
            </MainWrapper>
        </MainLayout>
    );
}

export default PostDetails;
