
class Subscribe{
    constructor()
    {
        this.email = document.getElementsByName("Email")[0];
        this.info_msg = document.getElementById("subscribe-info");
    }

    Handler(response)
    {
        let responseObj = JSON.parse(response);
        this.info_msg.innerHTML = responseObj.Info;
        this.info_msg.style.visibility = "visible";
        this.email.value="";
    }    

    Send()
    {
        let url =  "../php/main.php?request=subscribe&email="+this.email.value;
        this.info_msg.style.visibility = "hidden";
        ajax_get(url,this);
        return false;
    }
}