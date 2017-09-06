// Read cookie
function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for(let i=0;i < ca.length;i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1,c.length);
        }
        if (c.indexOf(nameEQ) === 0) {
            return c.substring(nameEQ.length,c.length);
        }
    }
    return null;
}

// Create Cookies
function createCookie(name,value,days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value.toString() + expires + "; path=/";
}

/* Get right ajax url depending on current application url*/
function getUrl() {
    let url = window.location.pathname;
    if(url.indexOf('search') === -1) {
        return moreNewsUrl;
    } else {
        let tagId = url.substr(url.lastIndexOf('/') + 1);
        return tagsUrl + tagId + '/';
    }
}