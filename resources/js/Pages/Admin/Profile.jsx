import React, { useContext, useEffect } from "react";
import { TextField, Button, Checkbox, InputAdornment } from "@mui/material";

import MainLayout from "../../Layouts/MainLayout";
import MainWrapper from "../../components/MainWrapper";
import ProfileDetails from "../../components/organization/ProfileDetails";

import Icon from "../../components/Icon";

function Profile(props) {
    return (
        <MainLayout>
            <MainWrapper className="org-profile-wrapper">
                <ProfileDetails showStats={true} />

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
                        </div>

                        <div className="profile-input-group">
                            <div className="auth-form-group">
                                <label className="form-group-label">
                                    Teacher ID No.
                                </label>
                                <div className="form-group-inputs">
                                    <TextField
                                        variant="outlined"
                                        className="auth-input"
                                    />
                                </div>
                            </div>
                        </div>

                        <div className="profile-input-group">
                            <div className="auth-form-group">
                                <label className="form-group-label">
                                    Change Password
                                </label>
                                <div className="form-group-inputs-row">
                                    <TextField
                                        variant="outlined"
                                        placeholder="Password"
                                        className="auth-input"
                                    />
                                    <TextField
                                        variant="outlined"
                                        placeholder="Confirm Password"
                                        className="auth-input"
                                    />
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
