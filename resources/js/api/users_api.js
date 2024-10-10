import { post } from "../http/axios";
const prefix = "/users/";
import { toFormData } from "../configs/global_helpers";

export const registerUser = async (obj = {}) => {
    const objData = {
        ...obj,
    };

    const url = prefix + "create-user";
    const data = objData;

    return post(url, data)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.error("HTTPS Request Error [create-user]", error);
            return error;
        });
};

export const securityQuestions = async (obj = {}) => {
    const objData = {
        ...obj,
    };

    const url = prefix + "security-questions";
    const data = objData;

    return post(url, data)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.error("HTTPS Request Error [security-questions]", error);
            return error;
        });
};

export const changePassword = async (obj = {}) => {
    const objData = {
        ...obj,
    };

    const url = prefix + "change-password";
    const data = objData;

    return post(url, data)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.error("HTTPS Request Error [change-password]", error);
            return error;
        });
};

export const createAdminAccount = async (obj = {}) => {
    const objData = {
        ...obj,
    };

    const url = prefix + "create-admin-account";
    const data = toFormData(objData);

    return post(url, data)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.error("HTTPS Request Error [create-admin-account]", error);
            return error;
        });
};
