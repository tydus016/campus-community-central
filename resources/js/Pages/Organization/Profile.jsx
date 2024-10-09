import React from "react";

import MainLayout from "../../Layouts/MainLayout";
import MainWrapper from "../../components/MainWrapper";

import ProfileDetails from "../../components/organization/ProfileDetails";
import PostDetailCard from "../../components/organization/PostDetailCard";

function Profile(props) {
    return (
        <MainLayout>
            <MainWrapper className="org-profile-wrapper">
                <ProfileDetails />

                <div className="org-posts">
                    <PostDetailCard />
                </div>
            </MainWrapper>
        </MainLayout>
    );
}

export default Profile;
