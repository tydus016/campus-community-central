import React, { useState } from "react";

import SecurityQuestionForm from "../../components/security_question/SecurityQuestionForm";
import AuthLayout from "../../Layouts/AuthLayout";

function SecurityQuestion(props) {
    return (
        <AuthLayout formTitle="Security Question" customClass="login-form-box">
            <SecurityQuestionForm />
        </AuthLayout>
    );
}

export default SecurityQuestion;
