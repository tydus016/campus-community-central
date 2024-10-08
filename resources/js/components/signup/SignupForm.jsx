import React, { useState } from "react";
import { TextField, Button, Checkbox, InputAdornment } from "@mui/material";
import { styled } from "@mui/material/styles";
import { Inertia } from "@inertiajs/inertia";

import Icon from "../Icon";
import MessageDialog from "../MessageDialog";

import departments from "../../../static/department_choices.json";

import { registerUser } from "../../api/users_api";

function SignupForm({ onSubmit = () => {} }) {
    const [eyeState, setEyeState] = useState({
        password: false,
        confirm_password: false,
    });
    const [selectedCourses, setSelectedCourses] = useState([]);

    const [firstname, setFirstname] = useState("");
    const [lastname, setLastname] = useState("");
    const [schoolId, setSchoolId] = useState("");
    const [department, setDepartment] = useState("");
    const [childhoodNickname, setChildhoodNickname] = useState("");
    const [bestfriendName, setBestfriendName] = useState("");
    const [firstPetName, setFirstPetName] = useState("");
    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [dialogState, setDialogState] = useState(false);
    const [dialogMessage, setDialogMessage] = useState("");

    const onShowPassword = (input) => {
        setEyeState((prevState) => ({
            ...prevState,
            [input]: !eyeState[input],
        }));
    };

    const CustomCheckbox = styled(Checkbox)(({ theme }) => ({
        color: "#26648e",
        "&.Mui-checked": {
            color: "#26648e",
            "& .MuiSvgIcon-root": {
                backgroundColor: "#26648e",
                borderRadius: "2px",
            },
        },
    }));

    const onDepartmentChange = (data) => {
        setSelectedCourses((prevState) => {
            if (prevState.includes(data)) {
                return prevState.filter((course) => course !== data);
            }

            return [data];
        });
    };

    const onFormSubmit = () => {
        const objData = {
            first_name: firstname,
            last_name: lastname,
            school_id: schoolId,
            childhood_nickname: childhoodNickname,
            bestfriend_name: bestfriendName,
            first_pet_name: firstPetName,
            password,
            confirm_password: confirmPassword,
            department_id: selectedCourses[0].id,
        };

        console.log("form submitted", objData);

        registerUser(objData)
            .then((res) => {
                const { message, status } = res;

                setDialogState(true);
                setDialogMessage(message);
            })
            .catch((err) => {})
            .finally(() => {});
    };

    const closeDialog = () => {
        setDialogState(false);

        Inertia.visit("/sign-in");
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
                    <label className="form-group-label">Full Name</label>
                    <div className="form-group-inputs-row">
                        <TextField
                            variant="outlined"
                            placeholder="firstname"
                            className="auth-input"
                            onChange={(e) => setFirstname(e.target.value)}
                            value={firstname}
                            name="firstname"
                        />
                        <TextField
                            variant="outlined"
                            placeholder="lastname"
                            className="auth-input"
                            onChange={(e) => setLastname(e.target.value)}
                            value={lastname}
                            name="lastname"
                        />
                    </div>
                </div>

                <div className="auth-form-group">
                    <label className="form-group-label">Student ID No.</label>
                    <div className="form-group-inputs">
                        <TextField
                            variant="outlined"
                            className="auth-input"
                            onChange={(e) => setSchoolId(e.target.value)}
                            value={schoolId}
                            name="school_id"
                        />
                    </div>
                </div>

                <div className="auth-form-checkboxes">
                    <label className="form-group-label">Department</label>
                    <div className="auth-department-choices">
                        {departments.map((department, index) => (
                            <div className="auth-checkbox-group" key={index}>
                                <span className="checkbox-label">
                                    {department.name}
                                </span>

                                {department.has_chckbx && (
                                    <CustomCheckbox
                                        onChange={() =>
                                            onDepartmentChange(department)
                                        }
                                        checked={selectedCourses.includes(
                                            department
                                        )}
                                    />
                                )}
                            </div>
                        ))}
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
                            onChange={(e) => setBestfriendName(e.target.value)}
                            value={bestfriendName}
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
                            onChange={(e) => setFirstPetName(e.target.value)}
                            value={firstPetName}
                            name="first_pet_name"
                        />
                    </div>
                </div>

                <div className="auth-form-group">
                    <label className="form-group-label">Create Password</label>
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
                            name="password"
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
                            name="confirm_password"
                        />
                    </div>
                </div>

                <div className="auth-form-actions">
                    <Button
                        className="auth-form-btn black"
                        onClick={onFormSubmit}
                    >
                        Submit
                    </Button>
                </div>
            </form>
        </>
    );
}

export default SignupForm;
