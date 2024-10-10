import React, { useContext, useEffect, useState } from "react";
import { TextField, Button, Checkbox, InputAdornment } from "@mui/material";
import { styled } from "@mui/material/styles";

import MainLayout from "../../Layouts/MainLayout";
import MainWrapper from "../../components/MainWrapper";
import ProfileDetails from "../../components/organization/ProfileDetails";

import Icon from "../../components/Icon";
import MessageDialog from "../../components/MessageDialog";

import { createAdminAccount } from "../../api/users_api";
import { delay } from "../../configs/global_helpers";

function AddOrganization(props) {
    const [firstName, setFirstName] = useState("");
    const [lastName, setLastName] = useState("");
    const [schoolId, setSchoolId] = useState("");
    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [organizationName, setOrganizationName] = useState("");
    const [organizationDescription, setOrganizationDescription] = useState("");
    const [coverPhoto, setCoverPhoto] = useState(null);
    const [childhoodNickname, setChildhoodNickname] = useState("");
    const [bestfriendName, setBestfriendName] = useState("");
    const [firstPetName, setFirstPetName] = useState("");

    const [dialogMessage, setDialogMessage] = useState("");
    const [dialogState, setDialogState] = useState(false);

    const VisuallyHiddenInput = styled("input")({
        clip: "rect(0 0 0 0)",
        clipPath: "inset(50%)",
        height: 1,
        overflow: "hidden",
        position: "absolute",
        bottom: 0,
        left: 0,
        whiteSpace: "nowrap",
        width: 1,
    });

    const onFormSubmit = () => {
        const objData = {
            first_name: firstName,
            last_name: lastName,
            school_id: schoolId,
            password: password,
            confirm_password: confirmPassword,
            organization_name: organizationName,
            organization_description: organizationDescription,
            organization_image: coverPhoto,
            childhood_nickname: childhoodNickname,
            bestfriend_name: bestfriendName,
            first_pet_name: firstPetName,
        };

        console.log(objData);

        createAdminAccount(objData).then((res) => {
            const { message, status } = res;

            setDialogMessage(message);
            setDialogState(true);

            if (status) {
                delay(() => closeDialog);
            }
        });
    };

    const closeDialog = () => {
        setDialogState(false);

        setFirstName("");
        setLastName("");
        setSchoolId("");
        setPassword("");
        setConfirmPassword("");
        setOrganizationName("");
        setOrganizationDescription("");
        setCoverPhoto(null);
        setChildhoodNickname("");
        setBestfriendName("");
        setFirstPetName("");
    };

    return (
        <MainLayout>
            {dialogState && (
                <MessageDialog onClose={closeDialog} onConfirm={closeDialog}>
                    {dialogMessage}
                </MessageDialog>
            )}

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
                                        onChange={(e) =>
                                            setFirstName(e.target.value)
                                        }
                                        value={firstName}
                                        name="first_name"
                                    />
                                    <TextField
                                        variant="outlined"
                                        placeholder="lastname"
                                        className="auth-input"
                                        onChange={(e) =>
                                            setLastName(e.target.value)
                                        }
                                        value={lastName}
                                        name="last_name"
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
                                        onChange={(e) =>
                                            setSchoolId(e.target.value)
                                        }
                                        value={schoolId}
                                        name="school_id"
                                    />
                                </div>
                            </div>
                        </div>

                        <div className="auth-form-group">
                            <label className="form-group-label">
                                What was your childhood nickname?
                            </label>
                            <div className="form-group-inputs">
                                <TextField
                                    variant="outlined"
                                    className="auth-input"
                                    placeholder="Answer"
                                    onChange={(e) =>
                                        setChildhoodNickname(e.target.value)
                                    }
                                    value={childhoodNickname}
                                    name="childhood_nickname"
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
                                    onChange={(e) =>
                                        setBestfriendName(e.target.value)
                                    }
                                    value={bestfriendName}
                                    name="bestfriend_name"
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
                                    onChange={(e) =>
                                        setFirstPetName(e.target.value)
                                    }
                                    value={firstPetName}
                                    name="first_pet_name"
                                />
                            </div>
                        </div>

                        <div className="profile-input-group">
                            <div className="auth-form-group">
                                <label className="form-group-label">
                                    Password
                                </label>
                                <div className="form-group-inputs-row">
                                    <TextField
                                        type="password"
                                        variant="outlined"
                                        placeholder="Password"
                                        className="auth-input"
                                        onChange={(e) =>
                                            setPassword(e.target.value)
                                        }
                                        value={password}
                                        name="password"
                                    />
                                    <TextField
                                        type="password"
                                        variant="outlined"
                                        placeholder="Confirm Password"
                                        className="auth-input"
                                        onChange={(e) =>
                                            setConfirmPassword(e.target.value)
                                        }
                                        value={confirmPassword}
                                        name="confirm_password"
                                    />
                                </div>
                            </div>
                        </div>

                        <div className="profile-input-group">
                            <div className="auth-form-group">
                                <label className="form-group-label">
                                    Organization Name
                                </label>
                                <div className="form-group-inputs">
                                    <TextField
                                        variant="outlined"
                                        className="auth-input"
                                        onChange={(e) =>
                                            setOrganizationName(e.target.value)
                                        }
                                        value={organizationName}
                                        name="organization_name"
                                    />
                                </div>
                            </div>
                        </div>

                        <div className="profile-input-group">
                            <div className="auth-form-group">
                                <label className="form-group-label">
                                    Organization Description
                                </label>
                                <div className="form-group-inputs">
                                    <TextField
                                        variant="outlined"
                                        className="auth-input"
                                        onChange={(e) =>
                                            setOrganizationDescription(
                                                e.target.value
                                            )
                                        }
                                        value={organizationDescription}
                                        name="organization_description"
                                    />
                                </div>
                            </div>
                        </div>

                        <Button
                            component="label"
                            role={undefined}
                            variant="contained"
                            tabIndex={-1}
                            startIcon={<Icon type="CloudUploadOutlined" />}
                        >
                            Upload Cover Photo
                            <VisuallyHiddenInput
                                type="file"
                                onChange={(event) =>
                                    setCoverPhoto(event.target.files[0])
                                }
                            />
                        </Button>

                        <div className="auth-form-actions">
                            <Button
                                className="auth-form-btn black"
                                onClick={onFormSubmit}
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

export default AddOrganization;
