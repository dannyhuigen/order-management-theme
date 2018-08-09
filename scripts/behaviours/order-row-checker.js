
function initOrderRowChecker() {
    $(".order-row-checker").click(function () {

        $(event.target).parents(".order-row").toggleClass("checked");

        updateSelectedManager();
    });

    $(".sm_deselect").click(function () {
        $(".order-row-checker").each(function () {
           $(this).parents(".order-row").removeClass("checked");
        });

        updateSelectedManager();
    });

    $(".sm_create_dpd").click(function () {

        var amountStickers = 0;
        var url = "http://localhost/samtiwp/pdfmerg/?allurls=";

        $(".order-row.checked").each(function () {
            amountStickers++;
            var dpdUrl = $(this).find(".order-colum-createdpd a").attr("href") + "?noDownload=true";
            window.open(dpdUrl,'_blank');
            // url+= dpdUrl +"?noDownload=true---";



        });

        // window.open(url,'_blank');
        updateSelectedManager();
    });
}

function updateSelectedManager() {

    $(".single-selected").each(function () {
       $(this).remove();
    });

    var amountSelected = 0;
    $(".order-row.checked").each(function () {
        var string = "";
        string += $(this).find(".order-colum-orderid").text();
        string += " - ";
        string += $(this).find(".order-colum-name").text();
        $(".selected-orders").append("<div class='single-selected'><p>"+string+"</p></div>")
        amountSelected++;
    });

    if (amountSelected === 0){
        $(".selected-manager").removeClass("active");
    }
    else{
        $(".selected-manager").addClass("active");
    }
}