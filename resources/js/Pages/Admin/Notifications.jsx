import React, { useContext, useEffect } from "react";

import MainLayout from "../../Layouts/MainLayout";
import MainWrapper from "../../components/MainWrapper";
import ProfileDetails from "../../components/organization/ProfileDetails";

import { NotifContext } from "../../contexts/NotifContext";

import {
    AdminNotifWrapper,
    NotifItem,
    NotifContent,
    NotifMoreOptions,
} from "../../components/Notifications";

import sampleNotifs from "../../../static/sample_notifs.json";

function Notifications(props) {
    const { notifState, setNotifData } = useContext(NotifContext);

    useEffect(() => {
        if (notifState.data.length === 0) {
            setNotifData(sampleNotifs);
        }
    }, []);

    return (
        <MainLayout>
            <MainWrapper className="org-profile-wrapper">
                <ProfileDetails showStats={true} />

                <div className="admin-notif-content">
                    <AdminNotifWrapper>
                        {notifState.data.map((notif, index) => (
                            <NotifItem key={index}>
                                <NotifContent
                                    className="admin-notif-content"
                                    title={notif.title}
                                    msg={notif.message}
                                />

                                <NotifMoreOptions
                                    onClick={() => console.log("oten")}
                                />
                            </NotifItem>
                        ))}
                    </AdminNotifWrapper>
                </div>
            </MainWrapper>
        </MainLayout>
    );
}

export default Notifications;
