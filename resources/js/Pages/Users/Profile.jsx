import React from "react";

import MainLayout from "../../Layouts/MainLayout";

import { TextField, Button, Checkbox, InputAdornment } from "@mui/material";
import Icon from "../../components/Icon";

import MainWrapper from "../../components/MainWrapper";

function Profile(props) {
    return (
        <MainLayout>
            <MainWrapper className="profile-wrapper">
                <div className="userprofile-form-box">
                    <div className="userprofile-form-content">
                        <div className="profile-input-group">
                            <div className="auth-form-group">
                                <label className="form-group-label">
                                    Full Name
                                </label>
                                <div className="form-group-inputs-row">
                                    <TextField
                                        variant="outlined"
                                        placeholder="firstname"
                                        className="auth-input"
                                    />
                                    <TextField
                                        variant="outlined"
                                        placeholder="lastname"
                                        className="auth-input"
                                    />
                                </div>
                            </div>

                            <div className="profile-btn-group">
                                <div className="custom-btn-group left">
                                    <Icon type="Check" />
                                    <span>Apply</span>
                                </div>

                                <div className="custom-btn-group right">
                                    <span>Changed</span>
                                </div>
                            </div>
                        </div>

                        <div className="profile-input-group">
                            <div className="auth-form-group">
                                <label className="form-group-label">
                                    Student ID No.
                                </label>
                                <div className="form-group-inputs">
                                    <TextField
                                        variant="outlined"
                                        className="auth-input"
                                    />
                                </div>
                            </div>

                            <div className="auth-form-group">
                                <label className="form-group-label">
                                    Department
                                </label>
                                <div className="form-group-inputs">
                                    <TextField
                                        variant="outlined"
                                        className="auth-input"
                                    />
                                </div>
                            </div>

                            <div className="profile-btn-group">
                                <div className="custom-btn-group left">
                                    <Icon type="Check" />
                                    <span>Apply</span>
                                </div>

                                <div className="custom-btn-group right">
                                    <span>Changed</span>
                                </div>
                            </div>
                        </div>

                        <div className="auth-form-actions">
                            <Button
                                className="auth-form-btn black"
                                // onClick={onFormSubmit}
                            >
                                Save Changes
                            </Button>
                        </div>
                    </div>
                </div>
            </MainWrapper>
        </MainLayout>
    );
}

export default Profile;
