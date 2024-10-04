import React from "react";

function Footer(props) {
    return (
        <div className="footer">
            <div className="footer-content">
                <img
                    className="footer-logo"
                    src="/assets/logos/cec_logo.png"
                    alt="cec logo"
                />
                <p className="footer-text">
                    Campus Community Central | Cebu Eastern College | Leon Kilat
                    Street Cebu City, 6000 | Philippines{" "}
                </p>
            </div>
        </div>
    );
}

export default Footer;
