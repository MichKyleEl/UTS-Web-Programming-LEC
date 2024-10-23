<script>
    for (let i = 1; i <= 20; i++) {
        new DataTable(`#table${i}`, {
            layout: {
                topStart: {
                    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
                }
            },
            scrollX: true
        });
    }
</script>