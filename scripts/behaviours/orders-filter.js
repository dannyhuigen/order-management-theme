
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

    var totalAmount = 0;
    totalAmount += $parentCounter.find("div[data-orderstatus='on-hold']").length - 1;
    totalAmount += $parentCounter.find("div[data-orderstatus='processing']").length - 1;
    totalAmount += $parentCounter.find("div[data-orderstatus='pending']").length - 1;

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

    $parentCounter.find(".js-shop-title-wrapper h3").text("aantal orders: " + totalAmount);
}