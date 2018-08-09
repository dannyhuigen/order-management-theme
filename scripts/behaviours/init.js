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

