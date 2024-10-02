import React, { useState, useEffect } from "react";
import { Inertia } from "@inertiajs/inertia";

import accTypes from "../../static/accountTypes.json";
import accStatus from "../../static/accountStatus.json";

import { swal, swal_confirm } from "../configs/global_helpers";
import { addNewUser } from "../api/users_api";

// - components
import { TextField, MenuItem, Button } from "@mui/material";

function AddNewUserForm(props) {
    const [loading, setLoading] = useState(false);
    const [name, setName] = useState("");
    const [username, setUsername] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [accountTypeInt, setAccountTypeInt] = useState(1);
    const [accountStatusInt, setAccountStatusInt] = useState(1);

    const onInputChange = (e) => {
        const target = e.target;
        const el = target.id;
        const value = target.value;

        switch (el) {
            case "name":
                setName(value);
                break;
            case "username":
                setUsername(value);
                break;
            case "email":
                setEmail(value);
                break;
            case "password":
                setPassword(value);
                break;
            case "confirm_password":
                setConfirmPassword(value);
                break;

            default:
                break;
        }
    };

    const onAccountTypeChange = (e) => {
        const target = e.target;
        const el = target.id;
        const value = target.value;

        setAccountTypeInt(value);
    };

    const onAccountStatusChange = (e) => {
        const target = e.target;
        const el = target.id;
        const value = target.value;

        setAccountStatusInt(value);
    };

    const onSubmit = async () => {
        const objData = {
            name,
            username,
            email,
            password,
            confirm_password: confirmPassword,
            account_type: accountTypeInt,
            account_status: accountStatusInt,
        };

        const conf = await swal_confirm("Do you want to save the changes?");
        if (!conf) {
            return;
        }

        setLoading(true);
        addNewUser(objData)
            .then((res) => {
                const { message, status } = res;

                swal(message, status);
            })
            .catch((err) => {})
            .finally(() => {
                setName("");
                setUsername("");
                setEmail("");
                setAccountTypeInt(1);
                setAccountStatusInt(1);
                setPassword("");
                setConfirmPassword("");

                setLoading(false);
            });
    };

    const onCancel = async () => {
        const conf = await swal_confirm("Do you want to cancel?");
        if (!conf) return;

        Inertia.visit("/users/lists");
    };

    return (
        <form className="detailsForm">
            <TextField
                className="details-input"
                label="Fullname"
                variant="standard"
                value={name}
                id="name"
                onChange={onInputChange}
            />

            <TextField
                className="details-input"
                label="Username"
                variant="standard"
                value={username}
                id="username"
                onChange={onInputChange}
            />

            <TextField
                className="details-input"
                label="Email"
                variant="standard"
                value={email}
                id="email"
                onChange={onInputChange}
            />

            <div className="field-row">
                <div className="field-col">
                    <TextField
                        className="details-input"
                        label="Password"
                        variant="standard"
                        value={password}
                        id="password"
                        type="password"
                        onChange={onInputChange}
                    />
                </div>
                <div className="field-col">
                    <TextField
                        className="details-input"
                        label="Confirm Password"
                        variant="standard"
                        value={confirmPassword}
                        id="confirm_password"
                        type="password"
                        onChange={onInputChange}
                    />
                </div>
            </div>

            <TextField
                className="details-input"
                label="Account Type"
                select
                variant="standard"
                defaultValue={accountStatusInt}
                value={accountTypeInt}
                id="accountType"
                onChange={onAccountTypeChange}
            >
                {accTypes.map((option) => (
                    <MenuItem key={option.value} value={option.value}>
                        {option.label}
                    </MenuItem>
                ))}
            </TextField>

            <TextField
                className="details-input"
                label="Account Status"
                select
                variant="standard"
                defaultValue={accountStatusInt}
                value={accountStatusInt}
                id="accountStatus"
                onChange={onAccountStatusChange}
            >
                {accStatus.map((option) => (
                    <MenuItem key={option.value} value={option.value}>
                        {option.label}
                    </MenuItem>
                ))}
            </TextField>

            <div className="form-actions">
                <Button variant="contained" color="error" onClick={onCancel}>
                    cancel
                </Button>
                <Button variant="contained" color="primary" onClick={onSubmit}>
                    Save Changes
                </Button>
            </div>
        </form>
    );
}

export default AddNewUserForm;
