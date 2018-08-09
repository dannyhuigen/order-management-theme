initALL();

$( document ).ready(function () {

    function loadShop(url , injectId) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(injectId);
                document.getElementById(injectId).innerHTML = this.responseText;
                initALL();
            }
        };
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    $(".js-single-shop").each(function () {

        loadShop($(this).data("geturl") , $(this).attr('id'));

    });

});

