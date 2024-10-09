import React from "react";

import MainLayout from "../../Layouts/MainLayout";
import MainWrapper from "../../components/MainWrapper";

import ProfileDetails from "../../components/organization/ProfileDetails";
import PostDetailCard from "../../components/organization/PostDetailCard";
import CreatePostCard from "../../components/organization/CreatePostCard";

function Index(props) {
    return (
        <MainLayout>
            <MainWrapper className="org-profile-wrapper">
                <ProfileDetails showStats={true} />

                <div className="org-posts">
                    <CreatePostCard />

                    {/* hide show btn for admins */}
                    <PostDetailCard showJoinBtn={false} />
                </div>
            </MainWrapper>
        </MainLayout>
    );
}

export default Index;
