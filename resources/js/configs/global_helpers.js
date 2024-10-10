import Swal from "sweetalert2";

export const swal = (text = "Something went wrong!", status) => {
    Swal.fire({
        icon: status ? "success" : "error",
        text: text,
    });
};

export const swal_confirm = async (
    text = "Do you want to save the changes?"
) => {
    return await Swal.fire({
        title: text,
        showCancelButton: true,
        confirmButtonText: "Continue",
        cancelButtonColor: "#ff0000",
        confirmButtonColor: "#007dff",
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            return true;
        }
    });
};

export const validateObj = (obj) => {
    for (const key in obj) {
        if (obj[key] === null || obj[key] === "") {
            delete obj[key];
        }
    }

    return obj;
};

export const clearObj = (obj) => {
    for (const key in obj) {
        obj[key] = null;
    }

    return obj;
};

export const getCurrentMonth = () => {
    const date = new Date();
    return date.getMonth() + 1;
};

export const getCurrentYear = () => {
    const date = new Date();
    return date.getFullYear();
};

export const getCurrentDay = () => {
    const date = new Date();
    return date.getDate();
};

export const getBase64 = (file, callback) => {
    const reader = new FileReader();

    reader.onload = function (event) {
        const base64String = event.target.result;
        callback(base64String);
    };

    reader.readAsDataURL(file);
};

export const truncateText = (text, maxLength = 100) => {
    if (text.length <= maxLength) {
        return text;
    }
    return text.substring(0, maxLength) + "...";
};

/**
 *
 * @description delay a function execution
 * @param callback callback callable function
 * @param int ms delay in milliseconds - default is 3 secs
 * @returns void
 */
export const delay = (callback, ms = 3000) => {
    const time = setTimeout(() => {
        callback();

        clearTimeout(time);
    }, ms);
};

export const objectToArrayOfObjects = (obj = null) => {
    if (!obj) {
        return [];
    }

    return Object.entries(obj).map(([key, value]) => {
        return { key, value };
    });
};

export const toFormData = (obj) => {
    const formData = new FormData();
    const keys = Object.keys(obj);
    const values = Object.values(obj);

    for (let i = 0; i <= keys.length; i++) {
        if ((keys[i] && values[i]) !== undefined) {
            formData.append(keys[i], values[i]);
        }
    }

    return formData;
};

export default {
    swal,
    swal_confirm,
    validateObj,
    clearObj,
    getCurrentMonth,
    getCurrentYear,
    getCurrentDay,
    getBase64,
    truncateText,
    delay,
    objectToArrayOfObjects,
    toFormData,
};
