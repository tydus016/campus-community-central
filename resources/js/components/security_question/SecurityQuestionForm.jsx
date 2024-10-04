import React, { useState } from "react";
import { TextField, Button, Checkbox, InputAdornment } from "@mui/material";
import { styled } from "@mui/material/styles";
import { Link } from "@inertiajs/inertia-react";

import Icon from "../Icon";

import departments from "../../../static/department_choices.json";

function SecurityQuestionForm(props) {
    const [eyeState, setEyeState] = useState({
        password: false,
        confirm_password: false,
    });

    const onShowPassword = (input) => {
        setEyeState((prevState) => ({
            ...prevState,
            [input]: !eyeState[input],
        }));
    };

    const onFormSubmit = () => {
        // console.log("form submitted", selectedCourses);
        // Link.visit("/new-password");
        location.href = "/new-password";
    };

    return (
        <form action="">
            <div className="auth-form-group">
                <label className="form-group-label">
                    What was your childhood nickname?
                </label>
                <div className="form-group-inputs">
                    <TextField
                        variant="outlined"
                        className="auth-input"
                        placeholder="Answer"
                    />
                </div>
            </div>

            <div className="auth-form-group">
                <label className="form-group-label">
                    What was the name of your bestfriend?
                </label>
                <div className="form-group-inputs">
                    <TextField
                        variant="outlined"
                        className="auth-input"
                        placeholder="Answer"
                    />
                </div>
            </div>

            <div className="auth-form-group">
                <label className="form-group-label">
                    What was your first pets name?
                </label>
                <div className="form-group-inputs">
                    <TextField
                        variant="outlined"
                        className="auth-input"
                        placeholder="Answer"
                    />
                </div>
            </div>

            <div className="auth-form-actions">
                <Button
                    className="auth-form-btn light-blue"
                    onClick={onFormSubmit}
                >
                    Submit
                </Button>
            </div>
        </form>
    );
}

export default SecurityQuestionForm;
