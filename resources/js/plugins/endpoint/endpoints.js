const Endpoints = {
    routes: {

        "complaints.create": {"uri": "/complaints/create", "method": "get"},
        "complaints.store": {"uri": "/complaints", "method": "post"},
        "complaints.index": {"uri": "/complaints", "method": "get"},

        "complaints.edit": {"uri": "/complaints/{complaint}/edit","method": "get"},
        "complaints.update": {"uri": "/complaints/{complaint}", "method": "put"},
        "complaints.destroy":{"uri":"/complaints/{complaint}","method": "delete"},
        "complaints.show":{"uri":"/complaints/{complaint}","method": "get"},

        "complaints.contractors":{"uri":"/complaints/contractors", "method": "get"},
        "complaints.excel":{"uri":"/complaints/excel","method": "get"},


        "complaints.finish":{"uri":"/complaints/{complaint}/finish","method":"patch"},
        "complaints.return":{"uri":"/complaints/{complaint}/return", "method":"delete"},

        "complaints.expenses.index":{"uri":"/complaints/{complaint}/expenses","method":"get"},
        "complaints.expenses.store":{"uri":"/complaints/{complaint}/expenses","method":"post"},
        "complaints.expenses.destroy":{"uri":"expenses/{expense}","method":"delete"},
        "complaints.expenses.update":{"uri":"expenses/{expense}","method":"put"},


        "complaints.redress.index":{"uri":"/complaints/{complaint}/redress","method":"get"},
        "complaints.redress.store":{"uri":"/complaints/{complaint}/redress","method":"post"},
        "complaints.redress.destroy":{"uri":"/redress/{redress}","method":"delete"},
        "complaints.redress.update":{"uri":"/redress/{redress} ","method":"put"},


        "complaints.comment.index":{"uri":"/complaints/{complaint}/comments ","method":"get"},
        "complaints.comment.store":{"uri":"/complaints/{complaint}/comments ","method":"post"},


        "complaints.attachments.index":{"uri":"/complaints/{complaint}/attachments","method":"get"},

        "attachments.show":{"uri":"/attachments/{attachment}","method":"get"},

        "complaints.attachments.store":{"uri":"/complaints/{complaint}/attachments","method":"post"},
        "complaints.attachments.create":{"uri":"/complaints/{complaint}/attachments/create","method":"get"},
        "complaints.attachments.destroy":{"uri":"/complaints/{complaint}/attachments/{attachment}","method":"delete"},



        "complaints.transfer.store":{"uri":"/complaints/{complaint}/transfer","method":"post"},
        "complaints.transfer.index":{"uri":"/complaints/{complaint}/transfer","method":"get"},
        "complaints.transfer.create":{"uri":"/complaints/{complaint}/transfer/create","method":"get"},
        "complaints.transfer.destroy":{"uri":"/complaints/{complaint}/transfer/{transfer}","method":"delete"},

        "transfers.attachments.delete":{"uri":"/transfers/{transfer}/attachments/{attachment}","method":"delete"},

        "statuses":{"uri":"/statuses","method":"get"},


    },
};

export {
    Endpoints
}
