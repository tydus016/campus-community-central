import React, { useState, useEffect, useRef, useContext } from "react";

import MainLayout from "../../Layouts/MainLayout";
import { Link } from "@inertiajs/inertia-react";
import { TextField, MenuItem, Button } from "@mui/material";
import { objectToArrayOfObjects } from "../../configs/global_helpers";

// - components
import { Card, CardTitle, CardBody } from "../../components/Card";
import UsersListsTable from "../../components/UsersListsTable";
import Icon from "../../components/Icon";
import FilterBox from "./components/FilterBox";

import { AppContext } from "../../contexts/AppContext";

const Lists = () => {
    const { state, updateUsersListsFilters } = useContext(AppContext);
    const [filters, setFilters] = useState(state.usersListsFilters);

    const filterBox = useRef(null);

    useEffect(() => {
        setFilters(objectToArrayOfObjects(state.usersListsFilters));
    }, [state.usersListsFilters]);

    const onShowFilter = () => {
        filterBox.current.classList.toggle("hidden");
    };

    const removeFilterItem = (key) => {
        const updateObj = {
            ...state.usersListsFilters,
        };
        updateObj[key] = "";

        updateUsersListsFilters(updateObj);
    };

    return (
        <MainLayout>
            <Card>
                <CardTitle className="custom-header-title">
                    <span>Users lists</span>
                    <div className="filter-list-container">
                        <div className="filter-list">
                            <TextField
                                size="small"
                                className="details-input"
                                label="Search list"
                                variant="standard"
                                id="name"
                                // value={name}
                                // onChange={onInputChange}
                            />

                            <span
                                className="filter-list-btn"
                                onClick={onShowFilter}
                            >
                                <Icon
                                    type="FilterList"
                                    style={{ fontSize: 25 }}
                                />
                            </span>
                        </div>
                        <div className="slctd-filters">
                            {filters.length > 0 &&
                                filters.map(
                                    (item, index) =>
                                        item.value !== "" && (
                                            <span
                                                className="slctd-filter-item"
                                                key={index}
                                                onClick={() =>
                                                    removeFilterItem(item.key)
                                                }
                                            >
                                                {item.value} &times;
                                            </span>
                                        )
                                )}
                        </div>

                        <FilterBox reference={filterBox} />
                    </div>
                </CardTitle>
                <CardBody>
                    <UsersListsTable />
                </CardBody>
            </Card>
        </MainLayout>
    );
};

export default Lists;
