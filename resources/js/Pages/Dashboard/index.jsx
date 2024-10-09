import React from "react";

import MainLayout from "../../Layouts/MainLayout";
import {
    MainHeader,
    MainBody,
    MainContent,
    MainTitle,
} from "../../components/MainContent";

import {
    OrgCard,
    OrgCardBanner,
    OrgCardFooter,
    OrgCardTitle,
} from "../../components/OrgCard";

function Index(props) {
    return (
        <MainLayout>
            <MainContent>
                <MainHeader>
                    <MainTitle>Organizations</MainTitle>
                </MainHeader>

                <MainBody>
                    <OrgCard>
                        <OrgCardBanner>
                            <img
                                src="/assets/images/orgs/ap.png"
                                alt="org-banner"
                            />
                        </OrgCardBanner>
                        <OrgCardFooter>
                            <OrgCardTitle>
                                Campus Community Central
                            </OrgCardTitle>
                        </OrgCardFooter>
                    </OrgCard>
                </MainBody>
            </MainContent>
        </MainLayout>
    );
}

export default Index;
