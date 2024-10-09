import React, { useRef, useEffect } from "react";

import { delay } from "../../configs/global_helpers";

function MessageThread({ data = [] }) {
    const threadListRef = useRef(null);
    const user_id = 101;

    useEffect(() => {
        if (threadListRef.current) {
            delay(() => {
                threadListRef.current.scrollTop =
                    threadListRef.current.scrollHeight;
            }, 500);
        }
    }, []);

    const BubbleSender = ({ thread }) => {
        return (
            <div className="thread-item sender">
                <img
                    src="/assets/icons/category_icon.png"
                    alt="sender profile pic"
                    className="sender-profile-image"
                />

                <div className="thread-message-bubble sender">
                    <p>{thread.message}</p>
                </div>
            </div>
        );
    };

    const BubbleReceiver = ({ thread }) => {
        return (
            <div className="thread-item receiver">
                <div className="thread-message-bubble receiver">
                    <p>{thread.message}</p>
                </div>
            </div>
        );
    };

    return (
        <div className="message-thread-container">
            <div className="message-thread-list" ref={threadListRef}>
                {data.map((item, index) => {
                    if (item.user_id == user_id) {
                        return <BubbleReceiver thread={item} key={index} />;
                    }

                    return <BubbleSender thread={item} key={index} />;
                })}
            </div>
        </div>
    );
}

export default MessageThread;
