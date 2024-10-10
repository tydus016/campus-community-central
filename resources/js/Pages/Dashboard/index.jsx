import React, { useEffect } from "react";

import { Inertia } from "@inertiajs/inertia";

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

import { getOrganizationsLists } from "../../api/organizations_api";

function Index(props) {
    const [data, setData] = React.useState([]);

    useEffect(() => {
        fetchOrganizations();
    }, []);

    const fetchOrganizations = async () => {
        const response = await getOrganizationsLists();

        if (response.status) {
            setData(response.data);
        }
    };

    const onCardClick = (org) => {
        Inertia.visit(`/organization/profile/${org.id}`);
    };

    return (
        <MainLayout>
            <MainContent>
                <MainHeader>
                    <MainTitle>Organizations</MainTitle>
                </MainHeader>

                <MainBody>
                    {data.length > 0 &&
                        data.map((org, index) => (
                            <OrgCard
                                key={index}
                                onClick={() => onCardClick(org)}
                            >
                                <OrgCardBanner>
                                    <img
                                        src={org.organization_image}
                                        alt={org.organization_name}
                                    />
                                </OrgCardBanner>
                                <OrgCardFooter>
                                    <OrgCardTitle>
                                        {org.organization_name}
                                    </OrgCardTitle>
                                </OrgCardFooter>
                            </OrgCard>
                        ))}
                </MainBody>
            </MainContent>
        </MainLayout>
    );
}

export default Index;
