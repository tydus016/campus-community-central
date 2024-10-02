import React, { useState, useEffect } from "react";
import { DataGrid } from "@mui/x-data-grid";
import Paper from "@mui/material/Paper";
import { Skeleton } from "@mui/material";

import { Link } from "@inertiajs/inertia-react";

import { usersLists } from "../api/users_api";

const RenderLink = ({ params, value }) => {
    return (
        <Link
            className="usersRenderLink"
            href={`/users/details/${params.user_id}`}
        >
            {value}
        </Link>
    );
};

const columns = [
    {
        field: "user_id",
        headerName: "UID",
        width: 70,
        renderCell: (params) => {
            return <RenderLink value={params.value} params={params.row} />;
        },
    },
    {
        field: "name",
        headerName: "Fullname",
        width: 130,
        renderCell: (params) => {
            return <RenderLink value={params.value} params={params.row} />;
        },
    },
    { field: "username", headerName: "Username", width: 100 },
    { field: "email", headerName: "Email", width: 200 },
    { field: "account_type", headerName: "Account Type", width: 150 },
    { field: "account_status", headerName: "Account Status", width: 150 },
    {
        field: "created_at",
        headerName: "Date Created",
        width: 250,
    },
    { field: "updated_at", headerName: "Date Updated", width: 250 },
];

const UsersListsTable = (props) => {
    const [loading, setLoading] = useState(false);
    const [rows, setRows] = useState([]);
    const [totalCount, setTotalCount] = useState(0);
    const [page, setPage] = useState(1);
    const [limit, setLimit] = useState(10);

    const [paginationModel, setPaginationModel] = useState({
        page: 0,
        pageSize: 10,
    });

    useEffect(() => {
        fetchUsersLists();
    }, []);

    const fetchUsersLists = async (obj = {}, callback = null) => {
        const objData = {
            page: page,
            limit: limit,
            ...obj,
        };

        setLoading(true);
        usersLists(objData)
            .then((res) => {
                const { status } = res;
                if (!status) {
                    alert(res.message);
                }

                setRows(res.data);
                setTotalCount(res.total_count);
            })
            .then((err) => {})
            .finally(() => {
                setLoading(false);

                if (callback && typeof callback === "function") {
                    callback();
                }
            });
    };

    const onPaginate = (model, details) => {
        const { page, pageSize } = model;
        const objData = {
            page: page + 1,
            limit: pageSize,
        };

        fetchUsersLists(objData, () => {
            setPaginationModel((prev) => ({ ...prev, ...model }));

            setPage(page);
            setLimit(pageSize);
        });
    };

    if (loading) {
        return (
            <>
                <Skeleton height={40} width="100%" animation="wave" />
                <Skeleton height={40} width="100%" animation="wave" />
                <Skeleton height={40} width="100%" animation="wave" />
                <Skeleton height={40} width="100%" animation="wave" />
                <Skeleton height={40} width="100%" animation="wave" />
            </>
        );
    }

    return (
        <Paper sx={{ height: 650, width: "100%" }}>
            <DataGrid
                paginationMode="server"
                rowCount={totalCount}
                rows={rows}
                columns={columns}
                page={paginationModel.page}
                pageSize={paginationModel.pageSize}
                initialState={{
                    pagination: {
                        paginationModel: paginationModel,
                    },
                }}
                onPaginationModelChange={onPaginate}
                pageSizeOptions={[5, 10, 20]}
                sx={{ border: 0 }}
            />
            ;
        </Paper>
    );
};

export default UsersListsTable;
