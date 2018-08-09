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