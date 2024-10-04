import React, { useState } from "react";
import { TextField, Button, Checkbox, InputAdornment } from "@mui/material";
import { styled } from "@mui/material/styles";
import { Link } from "@inertiajs/inertia-react";

import Icon from "../Icon";

import departments from "../../../static/department_choices.json";

function NewPasswordForm(props) {
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
        console.log("form submitted", selectedCourses);
    };

    return (
        <form action="">
            <div className="auth-form-group">
                <label className="form-group-label">Password</label>
                <div className="form-group-inputs">
                    <TextField
                        variant="outlined"
                        type={eyeState.password ? "text" : "password"}
                        className="auth-input"
                        InputProps={{
                            endAdornment: (
                                <InputAdornment position="end">
                                    <div
                                        className="eye-password"
                                        onClick={() =>
                                            onShowPassword("password")
                                        }
                                    >
                                        {eyeState.password ? (
                                            <Icon type="Visibility" />
                                        ) : (
                                            <Icon type="VisibilityOff" />
                                        )}
                                    </div>
                                </InputAdornment>
                            ),
                        }}
                    />
                </div>
            </div>

            <div className="auth-form-group">
                <label className="form-group-label">Confirm Password</label>
                <div className="form-group-inputs">
                    <TextField
                        variant="outlined"
                        type={eyeState.confirm_password ? "text" : "password"}
                        className="auth-input"
                        InputProps={{
                            endAdornment: (
                                <InputAdornment position="end">
                                    <div
                                        className="eye-password"
                                        onClick={() =>
                                            onShowPassword("confirm_password")
                                        }
                                    >
                                        {eyeState.confirm_password ? (
                                            <Icon type="Visibility" />
                                        ) : (
                                            <Icon type="VisibilityOff" />
                                        )}
                                    </div>
                                </InputAdornment>
                            ),
                        }}
                    />
                </div>
            </div>

            <div className="auth-form-actions">
                <Button
                    className="auth-form-btn custom-black"
                    onClick={onFormSubmit}
                >
                    Submit
                </Button>
            </div>
        </form>
    );
}

export default NewPasswordForm;
