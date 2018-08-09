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


function initExpander() {
    $(".js-expand-click").click(function () {

        $(event.target).siblings(".js-expander").slideToggle();

    });
}


function initGLS() {


    $(".js-dpd-clicker").click(function (e) {

        e.preventDefault();

        $(".gls-auto-grabber").addClass("available");

        $("#gls_name").text($(event.target).data("name"));
        $("#gls_adress").text($(event.target).data("adress"));
        $("#gls_city").text($(event.target).data("city"));
        $("#gls_postcode").text($(event.target).data("postcode"));
        $("#gls_country").text($(event.target).data("country"));
        $("#gls_telephone").text($(event.target).data("telephone"));
        $("#gls_email").text($(event.target).data("email"));
        $("#gls_id").text($(event.target).data("id"));

    });

}


function showGLSCopied(){

    $(".gls-auto-grabber").removeClass("available");

    $(".gls-confirmation-wrapper p").html("De order van <span style='color: green; font-weight: bold;'>"+$("#gls_name").text()+"</span> is gecopierd naar uw GLS klembord");

    $(".gls-confirmation-wrapper").slideDown();
    $(".gls-confirmation-wrapper").delay(1200).slideUp();

}
function initALL() {
    $( "*").unbind( "click" );
    initGLS();
    initExpander();
    initUtility();
    initSearchShop();
    initOrderFilters();
    initOrderRowChecker()
}

function initExpander() {
    $(".js-expand-click").click(function () {

        $(event.target).siblings(".js-expander").slideToggle();

    });
}



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

function initOrderFilters() {
    refreshAll();

    $(".js-checkbox").click(function () {
       $(this).toggleClass("active");
       refreshShop($(this).parents(".all-order-row"));
    });

    $(".js-orderfill-zip").keypress(function(e) {
        if(e.which == 13) {
            $ordersParentNode = $(this).parents(".all-order-row");
            $searchZipNode = $(this).parents(".all-order-row").find(".js-orderfill-zip");
            $searchIdNode = $(this).parents(".all-order-row").find(".js-orderfill-id");
            id = $searchIdNode.val();
            id = id.replace(/\D/g,'');
            id = $ordersParentNode.data("idprefix") + id;

            if($searchZipNode.val() === "paasmediegrap"){
                $searchZipNode.val("");
                ergeGrap();
            }

            if ($searchIdNode.val() === "" && $searchZipNode.val() === ""){
                refreshAll();
                console.log("refreshed all");
            }
            else if ($searchIdNode.val() != "") {
                searchOrderId(id  , $ordersParentNode);
                console.log("refreshed id");
            }
            else if ($searchZipNode.val() != "") {
                searchOrderZip($searchZipNode.val() , $ordersParentNode);
                console.log("refreshed zip");
            }
        }
    });

    $(".js-orderfill-id").keypress(function(e) {
        if(e.which == 13) {
            $ordersParentNode = $(this).parents(".all-order-row");
            $searchZipNode = $(this).parents(".all-order-row").find(".js-orderfill-zip");
            $searchIdNode = $(this).parents(".all-order-row").find(".js-orderfill-id");
            id = $searchIdNode.val();
            id = id.replace(/\D/g,'');
            id = $ordersParentNode.data("idprefix") + id;


            if ($searchIdNode.val() === "" && $searchZipNode.val() === ""){
                refreshAll();
                console.log("refreshed all");
            }
            else if ($searchIdNode.val() != "") {
                searchOrderId(id , $ordersParentNode);
                console.log("refreshed id");
            }
            else if ($searchZipNode.val() != "") {
                searchOrderZip($searchZipNode.val() , $ordersParentNode);
                console.log("refreshed zip");
            }
        }
    });

    $(".js-orderfill-reload").click(function () {
        $ordersParentNode = $(this).parents(".all-order-row");
        $searchZipNode = $(this).parents(".all-order-row").find(".js-orderfill-zip");
        $searchIdNode = $(this).parents(".all-order-row").find(".js-orderfill-id");

        $searchZipNode.val("");
        $searchIdNode.val("");

        refreshShop($ordersParentNode);
    });

    $(".js-orderfill-search").click(function () {

        $ordersParentNode = $(this).parents(".all-order-row");
        $searchZipNode = $(this).parents(".all-order-row").find(".js-orderfill-zip");
        $searchIdNode = $(this).parents(".all-order-row").find(".js-orderfill-id");
        id = $searchIdNode.val();
        id = id.replace(/\D/g,'');
        id = $ordersParentNode.data("idprefix") + id;


        if ($searchIdNode.val() === "" && $searchZipNode.val() === ""){
            refreshAll();
            console.log("refreshed all");
        }
        else if ($searchIdNode.val() != "") {
            searchOrderId(id , $ordersParentNode);
            console.log("refreshed id");
        }
        else if ($searchZipNode.val() != "") {
            searchOrderZip($searchZipNode.val() , $ordersParentNode);
            console.log("refreshed zip");
        }
    });

    $(".js-orderfill").bind("change paste keyup",function () {
        if ($(this).val() === ""){
            refreshAll();

        }
        else{
            searchOrder($(this).val() , $(this).parents(".all-order-row"));
        }
    });

    $(".all-order-row").each(function () {
        updateAmountText($(this));
    })

}

function searchOrderId(idToFind , $orderWrapperToRefresh) {
    $orderWrapperToRefresh.find(".order-row").each(function () {
        $(this).hide();
        if ($(this).data("orderid") == idToFind){
            $(this).slideDown(300);
        }
    });
}

function searchOrderZip(zipToFind , $orderWrapperToRefresh) {
    $orderWrapperToRefresh.find(".order-row").each(function () {
        $(this).hide();
        if ($(this).data("orderzip") == zipToFind){
            $(this).slideDown(300);
        }
    });
}

function refreshShop($orderWrapperToRefresh) {
    console.log("refreshing shop...");

    $orderWrapperToRefresh.find(".order-row").each(function () {

        $targetCheckbox = $(this).parents(".all-order-row").find(".js-checkbox[data-orderstatus='"+$(this).data("orderstatus")+"']");

        if($targetCheckbox.hasClass("active")){
            $(this).show();
        }
        else{
            $(this).hide();
        }
    });
}

function ergeGrap(){
    var rand = grappenDieEigelijkNietGemaaktMogenWorden[Math.floor(Math.random() * grappenDieEigelijkNietGemaaktMogenWorden.length)];
    alert(rand[0]);
    if(rand[1] != null){
        alert(rand[1])
    }
}

var grappenDieEigelijkNietGemaaktMogenWorden = [
    ["Wat zegt een Duitser die de gaskamer opruimt?","De laatste joodjes wegen het zwaarst."],
    ["Wat zeg je tegen een vrouw die volledig is toegetakeld op haar gezicht, vol blauw plekke en een gebroken kaak?","Gaje nu luisteren?!?"],
    ["Wat is een Jood die van een berg af valt?","een vallende ster!"],
    ["Het is klein, blauw en de vrouwen worden er zot van...","Wiegendood."],
    ["‎Twee Marokanen in een bootje varen de haven van Antwerpen binnen. Komen er 2 agenten hen toegestapt.\n" +
    "\"Wat komen jullie hier doen?\"\n" +
    "\"Wij komen belgië overnemen\", zegt die ene Marokaan.\n" +
    "\"Hahaha, met jullie twee?\"\n" +
    "\"Neen, de rest is er al.\" "],
    ["Er was eens een werkende turk."],
    ["Wat zei Jezus toen de joden hem kwamen uitlachen?","Wacht maar tot Adolf komt."],
    ["Vrouwen zijn net als een vuilzak, als ze vol zit gooi je ze weg."],
    ["Waarom kunnen negers zo snel lopen?","Alle trage zitten in den bak."],
    ["'Ik zie iets verschrikkelijks,' fluistert de waarzegster, opkijkend van de kristallen bol. 'Uw man zal morgen om het leven komen.'\n" +
    "'Dat weet ik,' zegt de vrouwelijke klant. 'Maar ik wil graag weten of ik vrijgesproken zal worden.' "],
    ["De man kreeg levenslang omdat hij voor zijn vrouw de deur had opengehouden.\n" +
    "Maar zijn auto reed op dat ogenblik ook 240 km per uur. "],
];

function refreshAll() {
    $(".order-row.js-refreshable").each(function () {

        $targetCheckbox = $(this).parents(".all-order-row").find(".js-checkbox[data-orderstatus='"+$(this).data("orderstatus")+"']");

        if($targetCheckbox.hasClass("active")){
            $(this).show();
        }
        else{
            $(this).hide();
        }
    });
}


var text = [];
text["processing"] = "Processing";
text["on-hold"] = "On hold";
text["pending"] = "Pending";
text["completed"] = "Completed";

function updateAmountText($parentCounter){
    var orders =[];
    $parentCounter.find(".order-row").each(function () {
        var orderStatus = $(this).data("orderstatus");
        if (orders[orderStatus] == null){
            orders[orderStatus] = 1;
        }
        else{
            orders[orderStatus]++;
        }

        $parentCounter.find(".js-checkbox[data-orderstatus='"+orderStatus+"']").html(text[orderStatus] + "<br>(" + orders[orderStatus] + ")");
    });

    $parentCounter.find(".js-shop-title-wrapper h3").text("aantal orders: " + ( 50 - orders["completed"] ));
}
// function startPopup(){
//
//     $(".js-popup").addClass("js-active");
//     $(".js-popup").addClass("js-dark");
//
// }
//
// $(".js-redirect").click(function () {
//
//     console.log($(event.target).attr("data-url"));
//     response.sendRedirect($(event.target).attr("data-url"));
//
// });
initALL();

$( document ).ready(function () {




});

function getSearchResult(url , id , element) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(element);
            element.html("");
            element.append(this.responseText);
            initALL();
        }
    };
    xhttp.open("GET", url+"?orderId="+id, true);
    xhttp.send();
}

function load_search_requests(id){

    $(".js-to-search").each(function () {

        $(this).html("loading...     <div class='loader'></div>");

        getSearchResult($(this).data("geturl") , id , $(this));

    });

}

function initSearchShop() {

    $(".dark-background").click(function () {
        $(".search-results").toggleClass("active");
        $(".dark-background").toggleClass("active");
    });

    $(".search-button").click(function () {

        load_search_requests($(".js-search-input").val());

        $(".search-results").addClass("active");
        $(".dark-background").addClass("active");

    });

}





function initUtility() {

    $(".js-utility-click").click(function () {

        $(".js-utility-wrapper").toggleClass("on");

    });

}