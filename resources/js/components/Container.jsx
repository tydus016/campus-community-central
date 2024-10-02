import React from "react";

function Container({ menuState, children }) {
    return (
        <div className={`Container ${menuState ? "margin" : ""}`}>
            {children}
        </div>
    );
}

export default Container;
