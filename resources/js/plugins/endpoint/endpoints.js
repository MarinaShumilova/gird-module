const Endpoints = {
    routes: {
       // "users.edit": { "uri":"/users/{user}/edit", "method": "get" [, domain]}
   /*     "my-home": {"uri": "/my-home", "method": "get"},
        "my-home-2": {"uri": "/my-home-2", "method": "get"},*/

        // guarantees
        // "guarantee":{"uri": "/guarantee", "method": "get"},
        // "causeWarranty":{"uri": "/causeWarranty","method": "get"},

        "complaints.create": {"uri": "/complaints/create", "method": "get"},
        "complaints.store": {"uri": "/complaints", "method": "post"}

    },
};

export {
    Endpoints
}
