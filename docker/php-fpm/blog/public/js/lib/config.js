/* Initial */
let d                                       = document;
let w                                       = window;

/* Cookies */
const OFFSET_NEWS_COOKIE_NAME               = 'offset';
const OFFSET_NEWS_COOKIE_TAG_NAME           = 'offset_tag_';
const UPDATE_CREDENTIAL_NAME                = 'update_crd';
const NEWS_PER_PAGE                         = 'news_per_page';
const SCROLL_POSITION                       = 'scroll';
const SCROLL_SPEED                          = 1000;

/* Appears on index page */
const USER_ID_FIELD_NAME                    = 'ui';
const USER_TOKEN_FIELD_NAME                 = 'at';

/* Ajax */
const moreNewsUrl                           = '/news/more/';
const moreTagsUrl                           = '/news/search/tag/more/';

/* Admin */
const TINY_UPLOAD_PATH                      = '/admin/news/upload';

let lS                                      = w.localStorage;
let sS                                      = w.sessionStorage;

let newsPerPage                             = 0;
let noNews                                  = false;
let onProcess                               = false;
let newsLoaded                              = false;


/* VARIABLES */
let content                                 = $('#content');
let article                                 = $('.article');