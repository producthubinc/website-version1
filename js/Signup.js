class Signup {
    constructor() {
        this.fname = document.getElementById("first-name");
        this.lname = document.getElementById("last-name");
        this.email = document.getElementById("email");
        this.password = document.getElementById("password");
        this.contact = document.getElementById("contact");
        this.info_msg = document.getElementById("signup-info");

        this.confPassword = document.getElementById("conf-password");
        this.UserType = document.getElementsByName("UserType")[0];
        this.params = [];

        this.defaultBorderColor = this.password.style.borderColor;
    }

    ResetBorderColors() {
        this.contact.style.borderColor = this.defaultBorderColor;
        this.email.style.borderColor = this.defaultBorderColor;
        this.password.style.borderColor = this.defaultBorderColor;
        this.confPassword.style.borderColor = this.defaultBorderColor;
        this.info_msg.style.visibility = "collapse";
    }

    Handler(response) {
        let responseObj = JSON.parse(response);
        if (responseObj.RCode == ResponseTypes.SUCCESS) {
            window.location.replace('/');
        }
        else {
            if (responseObj.Info = "Already Registered") {
                this.email.style.borderColor = "red";
                this.contact.style.borderColor = "red";
            }
            this.info_msg.innerHTML = responseObj.Info;
            this.info_msg.style.visibility = "visible";
        }
    }

    NotifyError(element, message) {
        if (message) {
            this.info_msg.innerHTML = message;
            this.info_msg.style.visibility = "visible";
        }
        element.style.borderColor = "red";
    }

    Validate() {
        this.ResetBorderColors();
        if (!this.password.value)
            return false;

        if (this.password.value != this.confPassword.value) {
            this.NotifyError(this.password, null);
            this.NotifyError(this.confPassword, "Passwords do not match.");
            return false;
        }

        //TBD: Validate Contact

        //TBD: Validate Password Strength

        return true;
    }

    Send() {
        let url = "../php/main.php";
        const isValid = this.Validate();
        if (isValid === false)
            return false;
        if (!this.UserType.checked)
            this.UserType = document.getElementsByName("UserType")[1];
        this.params.push({ name: "request", value: "signup" });
        this.params.push({ name: this.UserType.name, value: this.UserType.id });
        this.params.push({ name: this.fname.name, value: this.fname.value });
        this.params.push({ name: this.lname.name, value: this.lname.value });
        this.params.push({ name: this.email.name, value: this.email.value });
        this.params.push({ name: this.contact.name, value: this.contact.value });
        this.params.push({ name: this.password.name, value: this.password.value });

        console.log(this.params);
        ajax_post(url, toGetParamsString(this.params), this);
        return false;
    }
}