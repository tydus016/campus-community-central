import React, { useState, useEffect, useRef, useContext } from "react";
import { TextField, MenuItem, Button } from "@mui/material";

import accTypes from "../../../../static/accountTypes.json";
import accStatus from "../../../../static/accountStatus.json";
import delStatus from "../../../../static/deleteStatus.json";

import { objectToArrayOfObjects } from "../../../configs/global_helpers";
import {
    ACCOUNT_TYPE,
    ACCOUNT_STATUS,
    DELETED,
    NOT_DELETED,
} from "../../../configs/constants";

import { AppContext } from "../../../contexts/AppContext";

function FilterBox({ reference }) {
    const { state, updateUsersListsFilters } = useContext(AppContext);

    const [filters, setFilters] = useState({});

    const [filterDisplay, setFilterDisplay] = useState(state.usersListsFilters);

    const [accountTypeInt, setAccountTypeInt] = useState("");
    const [accountStatusInt, setAccountStatusInt] = useState("");
    const [deleteStatusInt, setDeleteStatusInt] = useState("");
    const [fromDate, setFromDate] = useState("");
    const [toDate, setToDate] = useState("");

    useEffect(() => {
        const { account_type, account_status, delete_flg, from_date, to_date } =
            state.usersListsFilters;

        if (account_type === "") {
            setAccountTypeInt("");
        }

        if (account_status === "") {
            setAccountStatusInt("");
        }

        if (delete_flg === "") {
            setDeleteStatusInt("");
        }

        if (from_date === "") {
            setFromDate("");
        }

        if (to_date === "") {
            setToDate("");
        }
    }, [state.usersListsFilters]);

    useEffect(() => {
        setupDisplayFilters();
    }, [filters]);

    useEffect(() => {
        updateUsersListsFilters(filterDisplay);
    }, [filterDisplay]);

    const setFilter = (value, key) => {
        let obj = {};
        obj[key] = value;

        setFilters({ ...filters, ...obj });
    };

    const setupDisplayFilters = () => {
        const filtersArr = objectToArrayOfObjects(filters);

        filtersArr.forEach((item, index) => {
            const { key, value } = item;

            switch (key) {
                case "account_type":
                    let account_type = "";
                    if (value == ACCOUNT_TYPE.super_admin) {
                        account_type = "Super Admin";
                    } else if (value == ACCOUNT_TYPE.admin) {
                        account_type = "Admin";
                    } else if (value == ACCOUNT_TYPE.user) {
                        account_type = "User";
                    }

                    setFilterDisplay({
                        ...filterDisplay,
                        account_type: account_type,
                    });
                    break;
                case "account_status":
                    let account_status = "";
                    if (value == ACCOUNT_STATUS.active) {
                        account_status = "Active";
                    } else if (value == ACCOUNT_STATUS.inactive) {
                        account_status = "Inactive";
                    }

                    setFilterDisplay({
                        ...filterDisplay,
                        account_status: account_status,
                    });
                    break;
                case "delete_flg":
                    let delete_flg = "";
                    if (value == DELETED) {
                        delete_flg = "Deleted";
                    } else if (value == NOT_DELETED) {
                        delete_flg = "Not Deleted";
                    }

                    setFilterDisplay({
                        ...filterDisplay,
                        delete_flg: delete_flg,
                    });
                    break;
                case "from_date":
                    setFilterDisplay({ ...filterDisplay, from_date: value });
                    break;
                case "to_date":
                    setFilterDisplay({ ...filterDisplay, to_date: value });
                    break;
                default:
                    break;
            }
        });
    };

    const onInputChange = (e) => {
        const target = e.target;
        const el = target.id;
        const value = target.value;

        switch (el) {
            case "from_date":
                setFromDate(value);
                break;
            case "to_date":
                setToDate(value);
                break;

            default:
                break;
        }

        setFilter(value, el);
    };

    const onAccountTypeChange = (e) => {
        const target = e.target;
        const el = target.id;
        const value = target.value;

        setAccountTypeInt(value);
        setFilter(value, "account_type");
    };

    const onAccountStatusChange = (e) => {
        const target = e.target;
        const el = target.id;
        const value = target.value;

        setAccountStatusInt(value);
        setFilter(value, "account_status");
    };

    const onDeleteStatusChange = (e) => {
        const target = e.target;
        const el = target.id;
        const value = target.value;

        setDeleteStatusInt(value);
        setFilter(value, "delete_flg");
    };

    return (
        <div className="filter-box hidden" ref={reference}>
            <div className="input-row">
                <TextField
                    size="small"
                    className="filter-input date-filter-input"
                    label="Date Created From"
                    variant="standard"
                    value={fromDate}
                    id="from_date"
                    onChange={onInputChange}
                />

                <TextField
                    size="small"
                    className="filter-input date-filter-input"
                    label="Date Created To"
                    variant="standard"
                    value={toDate}
                    id="to_date"
                    onChange={onInputChange}
                />
            </div>

            <TextField
                size="small"
                className="filter-input"
                label="Account Type"
                select
                variant="standard"
                id="account_type"
                defaultValue={accountStatusInt}
                value={accountTypeInt}
                onChange={onAccountTypeChange}
                InputProps={{ style: { fontSize: "12px" } }}
            >
                {accTypes.map((option) => (
                    <MenuItem key={option.value} value={option.value}>
                        {option.label}
                    </MenuItem>
                ))}
            </TextField>

            <TextField
                size="small"
                className="filter-input"
                label="Account Status"
                select
                variant="standard"
                id="account_status"
                defaultValue={accountStatusInt}
                value={accountStatusInt}
                onChange={onAccountStatusChange}
                InputProps={{ style: { fontSize: "12px" } }}
            >
                {accStatus.map((option) => (
                    <MenuItem key={option.value} value={option.value}>
                        {option.label}
                    </MenuItem>
                ))}
            </TextField>

            <TextField
                size="small"
                className="filter-input"
                label="Delete Status"
                select
                variant="standard"
                id="delete_flg"
                defaultValue={deleteStatusInt}
                value={deleteStatusInt}
                onChange={onDeleteStatusChange}
                InputProps={{ style: { fontSize: "12px" } }}
            >
                {delStatus.map((option) => (
                    <MenuItem key={option.value} value={option.value}>
                        {option.label}
                    </MenuItem>
                ))}
            </TextField>
        </div>
    );
}

export default FilterBox;
