import React, { useState } from "react";
import { TextField, Button, Checkbox, InputAdornment } from "@mui/material";
import { Inertia } from "@inertiajs/inertia";

import MessageDialog from "../MessageDialog";

import { securityQuestions } from "../../api/users_api";
import { delay } from "../../configs/global_helpers";

function SecurityQuestionForm(props) {
    const [schoolId, setSchoolId] = useState("");
    const [childhoodNickname, setChildhoodNickname] = useState("");
    const [bestfriendName, setBestfriendName] = useState("");
    const [firstPetName, setFirstPetName] = useState("");
    const [status, setStatus] = useState(false);

    const [dialogState, setDialogState] = useState(false);
    const [dialogMessage, setDialogMessage] = useState("");
    const [redirect, setRedirect] = useState("");

    const onFormSubmit = () => {
        const objData = {
            school_id: schoolId,
            childhood_nickname: childhoodNickname,
            bestfriend_name: bestfriendName,
            first_pet_name: firstPetName,
        };

        securityQuestions(objData).then((res) => {
            const { status, message } = res;

            setStatus(status);
            setDialogMessage(message);
            setDialogState(true);

            if (status) {
                setRedirect(res.redirect);

                delay(() => onClose());
            }
        });
    };

    const onClose = () => {
        setDialogState(false);

        if (status) {
            Inertia.visit(redirect);
        }
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
                    <label className="form-group-label">ID No.</label>
                    <div className="form-group-inputs">
                        <TextField
                            variant="outlined"
                            className="auth-input"
                            placeholder="Answer"
                            onChange={(e) => setSchoolId(e.target.value)}
                            value={schoolId}
                        />
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
        </>
    );
}

export default SecurityQuestionForm;
