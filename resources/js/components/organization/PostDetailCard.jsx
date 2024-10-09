import React, { useState, useEffect } from "react";
import { Link } from "@inertiajs/inertia-react";

import Icon from "../Icon";

function PostDetailCard({ showCommentBtn = true, showJoinBtn = true }) {
    return (
        <div className="post-detail-card">
            <div className="post-detail-content">
                <div className="post-detail-card-head">
                    <div className="div-post-datetime-detail">
                        <span>Jun 10, 2024</span>
                    </div>

                    <div className="div-post-datetime-detail">
                        <span>9:41 AM</span>
                    </div>
                </div>

                <div className="post-detail-card-body">
                    <p className="post-title">Lorem Ipsum title</p>
                    <div className="post-definition-body">
                        <div className="post-definition">
                            Lorem, ipsum dolor sit amet consectetur adipisicing
                            elit. Quam magnam recusandae minima alias maxime, ab
                            accusamus error laborum voluptas dolorum, illum
                            distinctio voluptatem perferendis enim excepturi
                            aut, quasi ad nobis.
                        </div>
                    </div>
                    <div className="post-image-gallery">
                        <img
                            src="/assets/icons/profile_account_icon.png"
                            alt="profile_account_icon"
                        />
                        <img
                            src="/assets/icons/profile_account_icon.png"
                            alt="profile_account_icon"
                        />
                        <img
                            src="/assets/icons/profile_account_icon.png"
                            alt="profile_account_icon"
                        />
                    </div>
                </div>

                <div className="post-detail-footer">
                    <div className="like-dislike-buttons">
                        <Icon type="ThumbUpAltOutlined" className="like-icon" />
                        <Icon
                            type="ThumbDownAltOutlined"
                            className="dislike-icon"
                        />
                    </div>

                    <div className="post-comment-join-btns">
                        {showCommentBtn && (
                            <Link
                                className="post-btn comment"
                                href="/organization/post-details"
                            >
                                <span>Comment</span>
                            </Link>
                        )}
                        {showJoinBtn && (
                            <Link className="post-btn join">
                                <span>Join</span>
                            </Link>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}

export default PostDetailCard;
