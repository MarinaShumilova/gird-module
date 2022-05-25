const Endpoints = {
    routes: {

        "complaints.create": {"uri": "/complaints/create", "method": "get"},
        "complaints.store": {"uri": "/complaints", "method": "post"},
        "complaints.index": {"uri": "/complaints", "method": "get"},

        "complaints.edit": {"uri": "/complaints/{complaint}/edit","method": "get"},
        "complaints.update": {"uri": "/complaints/{complaint}", "method": "put"},
        "complaints.destroy":{"uri":"/complaints/{complaint}","method": "delete"},

        "complaints.finish":{"uri":"/complaints/{complaint}/finish","method":"patch"},
        "complaints.return":{"uri":"/complaints/{complaint}/return", "method":"delete"},

        "complaints.expenses.index":{"uri":"/complaints/{complaint}/expenses","method":"get"},
        "complaints.expenses.store":{"uri":"/complaints/{complaint}/expenses","method":"post"},
        "complaints.expenses.destroy":{"uri":"expenses/{expense}","method":"delete"},
        "complaints.expenses.update":{"uri":"expenses/{expense}","method":"put"},
    },
};

export {
    Endpoints
}
