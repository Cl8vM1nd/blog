let ajax = {
    setup: (ui, at) => {
        this.success = null;
        $.ajaxSetup({
            headers: {
                'Auth': ui + at
            }
        });
    },
    url: null,
    type: "GET",
    beforeSend: null,
    success: null,
};