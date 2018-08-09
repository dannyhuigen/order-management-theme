function initExpander() {
    $(".js-expand-click").click(function () {

        $(event.target).siblings(".js-expander").slideToggle();

    });
}

