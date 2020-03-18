jQuery(document).ready(function () {
    jQuery('.btn-json-file').on('click', function (e) {
        e.preventDefault();
        jQuery.ajax({
            type: 'POST',
            url: custom_admin_url.custom_ajax_url,
            data: {
                action: 'ajax_generate_json_file',
                order_id: jQuery(this).data('order_id')
            },
            beforeSend: function () {
                jQuery('.response-json-file').html('processing...');
            },
            success: function (response) {
                jQuery('.response-json-file').html('Success');

                //Convert JSON string to BLOB.
                var json_blob = [response];
                var blob1 = new Blob(json_blob, {
                    type: 'application/json'
                });

                var a = document.createElement("a");
                document.body.appendChild(a);
                a.style = "display: none";
                //Check the Browser.
                var isIE = false || !!document.documentMode;
                if (isIE) {
                    window.navigator.msSaveBlob(blob1, "Customers.txt");
                } else {
                    var url = window.URL || window.webkitURL;
                    link = url.createObjectURL(blob1);
                    a.href = link;
                    a.download = 'download.json';
                    a.click();
                    window.URL.revokeObjectURL(link);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    })
});
