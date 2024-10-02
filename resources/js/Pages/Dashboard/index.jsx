import React from "react";

import MainLayout from "../../Layouts/MainLayout";

// - components
import { Card, CardTitle, CardBody } from "../../components/Card";

const Lists = () => {
    return (
        <MainLayout>
            <Card>
                <CardTitle>Dashboard</CardTitle>
                <CardBody>
                    <p>Welcome to the dashboard</p>
                </CardBody>
            </Card>
        </MainLayout>
    );
};

export default Lists;
