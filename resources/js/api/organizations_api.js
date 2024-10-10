import { post } from "../http/axios";
const prefix = "/organization/";

export const getOrganizationsLists = async (obj = {}) => {
    const objData = {
        ...obj,
    };

    const url = prefix + "organizations-lists";
    const data = objData;

    return post(url, data)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.error("HTTPS Request Error [organizations-lists]", error);
            return error;
        });
};
