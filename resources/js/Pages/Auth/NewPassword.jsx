import React, { useState } from "react";

import NewPasswordForm from "../../components/new_password/NewPasswordForm";
import AuthLayout from "../../Layouts/AuthLayout";

function Signin(props) {
    return (
        <AuthLayout
            formTitle="create new password"
            customClass="login-form-box"
        >
            <NewPasswordForm />
        </AuthLayout>
    );
}

export default Signin;
