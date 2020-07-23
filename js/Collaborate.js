
class Collaborate {
    constructor() {
        this.email = document.getElementsByName("CollabEmail")[0];
        this.name = document.getElementsByName("Name")[0];
        this.contact = document.getElementsByName("Contact")[0];
        this.business = document.getElementsByName("BusinessType")[0];
        this.info_msg = document.getElementById("collaborate-info");
    }

    Handler(response) {
        let responseObj = JSON.parse(response);
        this.info_msg.innerHTML = responseObj.Info;
        this.info_msg.style.visibility = "visible";
        this.email.value = "";
        this.name.value = "";
        this.contact.value = "";
        this.business.value = "";
    }

    Send() {
        let requestParams = [this.email, this.name, this.contact, this.business];
        let url = "../php/main.php?request=collaborate&" + toGetParamsString(requestParams);
        this.info_msg.style.visibility = "hidden";
        ajax_get(url, this);
        return false;
    }
}