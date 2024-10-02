import axios from "axios";
const base_url = "/api/";

export const post = async (Url, data, headers = {}) => {
    const url = base_url + Url;

    console.log("--START SENDING POST REQUEST--");
    console.log("URL => ", url);
    console.log("DATA => ", JSON.stringify(data));
    console.log("HEADERS => ", headers);

    return await axios
        .post(url, data, headers)
        .then((response) => {
            console.log("RESPONSE => ", response.data);
            return response.data;
        })
        .catch((error) => {
            console.error("HTTPS Request Error => ", JSON.stringify(error));
            return error;
        })
        .finally(() => {
            console.log("--END SENDING POST REQUEST--");
        });
};

export const get = async (Url) => {
    const url = base_url + Url;
    return await axios
        .get(url)
        .then((response) => {
            return response.data;
        })
        .catch((error) => {
            console.error("HTTPS Request Error => ", JSON.stringify(error));
            return error.response.data;
        });
};

export default { post, get };
