import React from "react";

import MainLayout from "../../Layouts/MainLayout";

import MessageInbox from "../../components/message/MessageInbox";
import MessageHeader from "../../components/message/MessageHeader";
import MessageThread from "../../components/message/MessageThread";
import MessageChatbox from "../../components/message/MessageChatbox";

import messages from "../../../static/thread_sample.json";

function Index(props) {
    return (
        <MainLayout>
            <div className="message-container">
                <div className="message-header">
                    <h1>Conversation</h1>
                </div>

                <div className="message-body">
                    <MessageInbox />

                    <div className="message-chat">
                        <MessageHeader />

                        <MessageThread data={messages} />

                        <MessageChatbox />
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}

export default Index;
