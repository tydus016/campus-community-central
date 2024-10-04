import React, { useState } from "react";

import SignupForm from "../../components/signup/SignupForm";
import AuthLayout from "../../Layouts/AuthLayout";

import MessageDialog from "../../components/MessageDialog";

function Signup(props) {
    const [dialogOpen, setDialogOpen] = useState(false);

    const onDialogClose = () => {
        setDialogOpen(false);
    };

    const onClose = () => {
        console.log("close");
        setDialogOpen(false);
    };

    const onSubmit = () => {
        setDialogOpen(true);
    };

    return (
        <>
            <AuthLayout formTitle="sign up">
                <SignupForm onSubmit={onSubmit} />
            </AuthLayout>

            {dialogOpen && (
                <MessageDialog onConfirm={onDialogClose} onClose={onClose}>
                    Account has been successfully created! Please sign-in to
                    access the website.
                </MessageDialog>
            )}
        </>
    );
}

export default Signup;
