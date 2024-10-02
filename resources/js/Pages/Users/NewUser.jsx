import React, { useState, useEffect } from "react";

import MainLayout from "../../Layouts/MainLayout";
import { Link } from "@inertiajs/inertia-react";

// - components
import { Card, CardTitle, CardBody } from "../../components/Card";
import AddNewUserForm from "../../components/AddNewUserForm";

const NewUser = () => {
    return (
        <MainLayout>
            <Card>
                <CardTitle>Add new user</CardTitle>
                <CardBody>
                    <AddNewUserForm />
                </CardBody>
            </Card>
        </MainLayout>
    );
};

export default NewUser;
