class Login {
    constructor() {
        this.email = document.getElementById("Username");
        this.password = document.getElementById("Password");
        this.info_msg = document.getElementById("login-info");
        this.params = [];
        
        this.defaultBorderColor = this.password.style.borderColor;
    }

    ResetBorderColors()
    {
        this.email.style.borderColor = this.defaultBorderColor;
        this.password.style.borderColor = this.defaultBorderColor;
        this.info_msg.style.visibility = "collapse";
    }

    Handler(response) {
        let responseObj = JSON.parse(response);
        if (responseObj.RCode == ResponseTypes.SUCCESS) {
            window.location.replace('/');
        }
        else {
            this.info_msg.innerHTML = responseObj.Info;
            this.email.style.borderColor = "red";
            this.password.style.borderColor = "red";
            this.info_msg.style.visibility = "visible";
        }
    }

    Send() {
        this.ResetBorderColors();

        let url = "/php/main.php";

        this.params.push({ name: "request", value: "login" });
        this.params.push({ name: this.email.name, value: this.email.value });
        this.params.push({ name: this.password.name, value: this.password.value });

        ajax_post(url, toGetParamsString(this.params), this);
        return false;
    }
}