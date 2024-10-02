import { post } from "../http/axios";
const prefix = "users/";

export const usersLists = async (obj = {}) => {
    const objData = {
        ...obj,
    };

    const url = prefix + "users_lists";
    const data = objData;

    return post(url, data)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.error("HTTPS Request Error [users_lists]", error);
            return error;
        });
};

export const usersDetails = async (obj = {}) => {
    const objData = {
        ...obj,
    };

    const url = prefix + "users_details";
    const data = objData;

    return post(url, data)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.error("HTTPS Request Error [users_details]", error);
            return error;
        });
};

export const updateUserDetails = async (obj = {}) => {
    const objData = {
        ...obj,
    };

    const url = prefix + "update_user_details";
    const data = objData;

    return post(url, data)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.error("HTTPS Request Error [update_user_details]", error);
            return error;
        });
};

export const deleteUserAccount = async (obj = {}) => {
    const objData = {
        ...obj,
    };

    const url = prefix + "update_delete_flg";
    const data = objData;

    return post(url, data)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.error("HTTPS Request Error [update_delete_flg]", error);
            return error;
        });
};

export const addNewUser = async (obj = {}) => {
    const objData = {
        ...obj,
    };

    const url = prefix + "create_user";
    const data = objData;

    return post(url, data)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.error("HTTPS Request Error [create_user]", error);
            return error;
        });
};
