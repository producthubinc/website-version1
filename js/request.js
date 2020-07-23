const ResponseTypes =
{
    DEFAULT: -1,
    ERROR: 0,
    WARNING: 1,
    SUCCESS: 2
}

function ajax_get(url, hInstance) {
    let xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            hInstance.Handler(this.responseText);
        }
    }

    xmlHttp.open("GET", url, true);
    xmlHttp.send();
}


function ajax_post(url, content, hInstance) {
    let xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            hInstance.Handler(this.responseText);
        }
    }

    xmlHttp.open("POST", url, true);
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttp.send(content);
}

function toGetParamsString(params) {
    let string ="";
    for (var i = 0; i < params.length; i++) {
        string += params[i].name +"="+params[i].value;
        if(params.length - 1 != i)
            string+="&";
    }
    return string;
}
