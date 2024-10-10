import React, { useState } from "react";
import { TextField, Button, Checkbox, InputAdornment } from "@mui/material";

import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/inertia-react";

import Icon from "../Icon";
import MessageDialog from "../MessageDialog";

import { changePassword } from "../../api/users_api";
import { delay } from "../../configs/global_helpers";

function NewPasswordForm(props) {
    const { user_id } = usePage().props;

    const [eyeState, setEyeState] = useState({
        password: false,
        confirm_password: false,
    });

    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [dialogMessage, setDialogMessage] = useState("");
    const [dialogState, setDialogState] = useState(false);

    const onShowPassword = (input) => {
        setEyeState((prevState) => ({
            ...prevState,
            [input]: !eyeState[input],
        }));
    };

    const onFormSubmit = () => {
        const objData = {
            password,
            confirm_password: confirmPassword,
            user_id,
        };

        changePassword(objData).then((res) => {
            const { message, status } = res;

            setDialogMessage(message);
            setDialogState(true);

            if (status) {
                delay(() => onClose);
            }
        });
    };

    const onClose = () => {
        setDialogState(false);

        Inertia.visit("/sign-in");
    };

    return (
        <>
            {dialogState && (
                <MessageDialog onClose={onClose} onConfirm={onClose}>
                    {dialogMessage}
                </MessageDialog>
            )}

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
                            onChange={(e) => setPassword(e.target.value)}
                            value={password}
                        />
                    </div>
                </div>

                <div className="auth-form-group">
                    <label className="form-group-label">Confirm Password</label>
                    <div className="form-group-inputs">
                        <TextField
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
                            onChange={(e) => setConfirmPassword(e.target.value)}
                            value={confirmPassword}
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
        </>
    );
}

export default NewPasswordForm;
