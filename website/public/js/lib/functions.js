/* Read cookie */
let getCookie = (name) => {
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
};

/* Create Cookies */
let setCookie = (name,value,days) => {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value.toString() + expires + "; path=/";
};

/* Get right ajax url depending on current application url*/
let getTagUrl = () => {
    return moreTagsUrl + getTagId() + '/';
};

/* Get TagId from URL */
let getTagId = () => {
    let url = window.location.pathname;
    return url.substr(url.lastIndexOf('/') + 1);
};

let isTagUrl = () => {
    let url = window.location.pathname;
    return url.indexOf('tag') !== -1;
};

/* Check localStorage available */
let checkLocalStorageAvailable = () => {
    if (typeof(Storage) === "undefined") {
        alert("Website need localStorage support for best performance.");
        return false;
    }
};

/* Return url depending on page */
let getAjaxUrl = (initByScroll = false) => {
    if (!isTagUrl()) {
        // First run on main page
        if (!initByScroll) {
            return getCookie(OFFSET_NEWS_COOKIE_NAME) ? moreNewsUrl + '0/'  + getCookie(OFFSET_NEWS_COOKIE_NAME) : moreNewsUrl;
        } else {
            return moreNewsUrl + getCookieOffsetNewsValue();
        }
    } else {
        if (!initByScroll) {
            return getCookie(OFFSET_NEWS_COOKIE_NAME) ? getTagUrl() + '0/'  + getCookie(OFFSET_NEWS_COOKIE_NAME) : getTagUrl();
        } else {
            return getTagUrl()  + getCookieOffsetNewsValue();
        }
    }
};

/* Main function wich get news and replace page with them */
let getNews = () => {
    let news_spinner = $('#news-spinner');

    ajax.setup(getUserIdFieldValue(), getUserTokenFieldValue());
    ajax.beforeSend = () => {
        news_spinner.fadeIn(100);
    };
    ajax.url = getAjaxUrl();
    ajax.success = (data) => {
            setUserTokenFieldValue(data[1]);
            news_spinner.fadeOut(100, () => {
                content.html(JSON.parse(data[0]));
                content.fadeIn(150);
                // Main news loaded
                newsLoaded = true;
                if(!getCookie(OFFSET_NEWS_COOKIE_NAME)) {
                    sS.setItem(NEWS_PER_PAGE, $('.article').length);
                }
                if (parseInt(sS.getItem(SCROLL_POSITION)) !== 0) {
                  if(sessionStorage.getItem(UPDATE_CREDENTIAL_NAME) == 1) {
                    $('html, body').animate({
                        scrollTop: sS.getItem(SCROLL_POSITION)
                    }, SCROLL_SPEED);
                    sessionStorage.setItem(UPDATE_CREDENTIAL_NAME, '0')
                  }
                }
            });
            sS.setItem(USER_TOKEN_FIELD_NAME, data[1]);
    };
    $.ajax(ajax);
};

/* Function wich get more news and add to content them */
let getMoreNews = () => {
    let spinner_image = $('#spinner_image');
    let offsetNews = getCookieOffsetNewsValue();

    ajax.setup(getUserIdFieldValue(), getUserTokenFieldValue());
    ajax.beforeSend = () => {
        spinner_image.fadeIn(100);
        onProcess = true;
    };
    ajax.url = getAjaxUrl(true);
    ajax.success = (data) => {
        if (data === 'null') {
            spinner_image.hide(300);
            noNews = true;
        } else {
            setUserTokenFieldValue(data[1]);
            content.append(JSON.parse(data[0]));
            spinner_image.fadeOut(300);
            sS.setItem(USER_TOKEN_FIELD_NAME, data[1]);

            offsetNews += parseInt(sS.getItem(NEWS_PER_PAGE));
            setCookie(OFFSET_NEWS_COOKIE_NAME, offsetNews, 1);
            noNews = false;
        }
        onProcess = false;
    };
    if(!noNews && !onProcess && newsLoaded) {
        $.ajax(ajax);
    }
};

let getNewsAmount = () => {
    return parseInt(getCookie(OFFSET_NEWS_COOKIE_NAME)) + parseInt(sS.getItem(NEWS_PER_PAGE));
};

/**
 *  Get news offset cookie offset value
 *  If no value presented return amount of news per page
 */
let getCookieOffsetNewsValue = () => {
    return parseInt(getCookie(OFFSET_NEWS_COOKIE_NAME) ? getCookie(OFFSET_NEWS_COOKIE_NAME) : sS.getItem(NEWS_PER_PAGE));
};

/* Update User side Credential after clicking back button in browser */
let updateUserSideCredentials = () => {
    if(sS.getItem(UPDATE_CREDENTIAL_NAME) === '1') {
        setUserTokenFieldValue(sS.getItem(USER_TOKEN_FIELD_NAME));
        sS.removeItem(UPDATE_CREDENTIAL_NAME);
    }
};

/* Set UserToken field on page */
let setUserTokenFieldValue = (value) => {
    $('input[name="' + USER_TOKEN_FIELD_NAME + '"]').val(value);
};

/* Get UserToken field on page */
let getUserTokenFieldValue = () => {
    return $('input[name="' + USER_TOKEN_FIELD_NAME + '"]').val();
};

let getUserIdFieldValue = () => {
  return $('input[name="' + USER_ID_FIELD_NAME + '"]').val();
};

/* Console log alias */
let cl = (value) => {
  console.log(value);
};
