class User {
  constructor(redirect) {
    let url = "../php/main.php";
    this.params = [];
    this.params.push({ name: "request", value: "validateuser" });
    this.redirect = redirect;
    this.request = "validateuser";
    ajax_post(url, toGetParamsString(this.params), this);
  }

  onLogout(response) {
    if (this.request === "logout") {
      window.location.replace('/');
    }
  }
  onValidate(response) {
    if (this.request !== "validateuser") {
      return false;
    }

    const result = JSON.parse(response);
    if (result.Content !== "") {
      this.user = JSON.parse(result.Content);
    }

    if (this.redirect) {
      this.redirect();
    }
  }

  Handler(response) {
    this.onValidate(response);
    this.onLogout(response);
  }

  Send() {
    return false;
  }

  logout() {
    let url = "../php/main.php";
    this.params = [];
    this.request = "logout";
    this.params.push({ name: "request", value: "logout" });
    ajax_post(url, toGetParamsString(this.params), this);
  }
}