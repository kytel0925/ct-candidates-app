import React from "react";

export const useForm = (initialState = {}) => {
    const [values, setvalues] = React.useState(initialState);

    const reset = () => {
        setvalues(initialState);
    };

    const inputHandleChange = ({ target }) => {
        setvalues({ ...values, [target.name]: target.value });
    };

    return [values, inputHandleChange, reset];
};
