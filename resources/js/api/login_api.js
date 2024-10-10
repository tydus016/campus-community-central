import { post } from "../http/axios";
const prefix = "login/";

export const authenticate = async (obj = {}) => {
    const objData = {
        ...obj,
    };

    const url = prefix + "authenticate";
    const data = objData;

    return post(url, data)
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.error("HTTPS Request Error [authenticate]", error);
            return error;
        });
};
