$(document).ready(function () {
    $('.printButton').click(function (e) {
        let url = $('input[name=url_group]').val()
        var id = this.getAttribute("data-id");
        $.ajax({
            url: url, type: 'GET', data: {id: id}, success: function (result) {
                let data = result.message
                $('#table').html(data)
                e.preventDefault()
                w = window.open();
                w.document.write($('#table').html());
                w.print($('#table').html());
                w.close();
            }
        })


    })
})