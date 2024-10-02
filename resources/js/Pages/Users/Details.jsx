import React, { useState, useEffect, useRef } from "react";
import { Inertia } from "@inertiajs/inertia";

import MainLayout from "../../Layouts/MainLayout";
import { Link, usePage } from "@inertiajs/inertia-react";

import { deleteUserAccount } from "../../api/users_api";

import { swal, swal_confirm, delay } from "../../configs/global_helpers";
import { DELETED } from "../../configs/constants";

// - components
import { Card, CardTitle, CardBody } from "../../components/Card";
import { TextField, MenuItem, Button } from "@mui/material";
import UpdateUserDetailsForm from "../../components/UpdateUserDetailsForm";

const Lists = () => {
    const { user_id } = usePage().props;
    const [loading, setLoading] = useState(false);

    const onDeleteUser = async () => {
        const conf = await swal_confirm("Confirm user account deletion?");
        if (!conf) return;

        const objData = {
            user_id: user_id,
            value: DELETED,
        };

        setLoading(true);
        deleteUserAccount(objData)
            .then((res) => {
                const { status, message } = res;

                swal(message, status);

                if (status) {
                    delay(() => Inertia.visit("/users/lists"));
                }
            })
            .catch((error) => {})
            .finally(() => {
                setLoading(false);
            });
    };

    if (loading) {
        return null;
    }

    return (
        <MainLayout>
            <Card>
                <CardTitle className="detailsCardTitle">
                    <span>User's details</span>
                    <Button
                        className="detailsDelBtn"
                        variant="outlined"
                        color="error"
                        onClick={onDeleteUser}
                    >
                        delete user
                    </Button>
                </CardTitle>
                <CardBody>
                    <UpdateUserDetailsForm user_id={user_id} />
                </CardBody>
            </Card>
        </MainLayout>
    );
};

export default Lists;
