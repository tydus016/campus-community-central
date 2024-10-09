import React, { useState } from "react";
import { TextField, Button, Checkbox, InputAdornment } from "@mui/material";
import { styled } from "@mui/material/styles";

import Icon from "../Icon";

import departments from "../../../static/department_choices.json";

function SignupForm({ onSubmit = () => {} }) {
    const [eyeState, setEyeState] = useState({
        password: false,
        confirm_password: false,
    });
    const [selectedCourses, setSelectedCourses] = useState([]);

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

            return [...prevState, data];
        });
    };

    const onFormSubmit = () => {
        console.log("form submitted", selectedCourses);

        onSubmit();
    };

    return (
        <form action="">
            <div className="auth-form-group">
                <label className="form-group-label">Full Name</label>
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

            <div className="auth-form-group">
                <label className="form-group-label">Student ID No.</label>
                <div className="form-group-inputs">
                    <TextField variant="outlined" className="auth-input" />
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
                <Button className="auth-form-btn black" onClick={onFormSubmit}>
                    Submit
                </Button>
            </div>
        </form>
    );
}

export default SignupForm;
