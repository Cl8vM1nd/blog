let ajax = {
    clean: (test = null) => {
        this.success = null;
        this.url = null;
        this.type = "GET";
        this.beforeSend = null;
    },
    url: null,
    type: "GET",
    data: null,
    processData: true,
    beforeSend: null,
    success: null,
    setup: (ui, at) => {
        ajax.clean();
        $.ajaxSetup({
            headers: {
                'Auth': ui + at
            }
        });
    }
};