import React, { useState } from "react";
import { TextField, Button, Checkbox, InputAdornment } from "@mui/material";
import { Link } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";

import Icon from "../Icon";
import MessageDialog from "../MessageDialog";

import { authenticate } from "../../api/login_api";

function SigninForm(props) {
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

    const [schoolID, setSchoolID] = useState("");
    const [password, setPassword] = useState("");
    const [dialogMessage, setDialogMessage] = useState("");
    const [dialogState, setDialogState] = useState(false);

    const onInputChange = (e) => {
        const target = e.target;
        const el = target.id;
        const value = target.value;

        switch (el) {
            case "schoolID":
                setSchoolID(value);
                break;
            case "password":
                setPassword(value);
                break;

            default:
                break;
        }
    };

    const onFormSubmit = () => {
        const objData = {
            schoolID,
            password,
        };

        authenticate(objData)
            .then((res) => {
                const { message, status } = res;

                if (!status) {
                    setDialogMessage(message);
                    setDialogState(true);
                    return;
                }

                Inertia.visit(res.redirect);
            })
            .catch((err) => {})
            .finally(() => {});
    };

    const closeDialog = () => {
        setDialogState(false);
    };

    return (
        <>
            {dialogState && (
                <MessageDialog onClose={closeDialog} onConfirm={closeDialog}>
                    {dialogMessage}
                </MessageDialog>
            )}

            <form action="">
                <div className="auth-form-group">
                    <label className="form-group-label">ID No.</label>
                    <div className="form-group-inputs">
                        <TextField
                            id="schoolID"
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
                            onChange={onInputChange}
                            value={schoolID}
                        />
                    </div>
                </div>

                <div className="auth-form-group">
                    <label className="form-group-label">Password</label>
                    <div className="form-group-inputs">
                        <TextField
                            id="password"
                            variant="outlined"
                            type={
                                eyeState.confirm_password ? "text" : "password"
                            }
                            className="auth-input"
                            InputProps={{
                                endAdornment: (
                                    <InputAdornment position="end">
                                        <div
                                            className="eye-password"
                                            onClick={() =>
                                                onShowPassword(
                                                    "confirm_password"
                                                )
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
                            onChange={onInputChange}
                            value={password}
                        />
                    </div>
                </div>

                <div className="auth-form-actions">
                    <Button
                        className="auth-form-btn light-blue"
                        onClick={onFormSubmit}
                    >
                        Sign In
                    </Button>
                </div>

                <div className="forgot-pw">
                    <span className="forgot-pw-txt">
                        Forgot{" "}
                        <Link
                            className="forgot-pw-txt-style"
                            href="/forgot-password"
                        >
                            password?
                        </Link>
                    </span>
                </div>
            </form>
        </>
    );
}

export default SigninForm;
