import React, { useState } from "react";

import SigninForm from "../../components/signin/SigninForm";
import AuthLayout from "../../Layouts/AuthLayout";

function Signin(props) {
    return (
        <AuthLayout formTitle="sign in" customClass="login-form-box">
            <SigninForm />
        </AuthLayout>
    );
}

export default Signin;
