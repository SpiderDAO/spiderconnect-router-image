function ConfirmFactoryReset(){
    return confirm('Are you sure you want to reset your router to Factory Default Settings?');
}

jQuery(document).ready(function () {

    jQuery('[data-toggle="tooltip"]').tooltip();
    jQuery('[data-toggle="popover"]').popover();


    jQuery('.openloc').click(function () {
        jQuery('.home-screen-select').addClass('on');
        jQuery('.moverlay').show();
		jQuery('.dropdown-menu').show();
    });


    jQuery('#viewopen , .moverlay').click(function () {
        jQuery('.home-screen-select').removeClass('on');
        jQuery('.moverlay').hide();
    });


    jQuery('.view-screen-select .dropdown-menu li a').click(function () {
        var server_id = $(this).attr('data-server_id');
        jQuery('#third-connect').hide();
        jQuery('#second-connect img').attr('title', 'Connecting...');
        jQuery('#second-connect .turn_connect').html('Connecting...');

        jQuery('.home-screen-select').removeClass('on');
        jQuery('.moverlay').hide();
        jQuery('#first-screen').hide();
        jQuery('#second-connect').show();
        jQuery('.spinner-overlay').show();
        
		
		jQuery('#logooff').hide();
		jQuery('#logoon').hide();
        hidelogos = 1;

        $.ajax({
            method: 'post',
            url: '/api/connect.php',
            timeout: 20000, // sets timeout to 20 seconds
            data: {server_id: server_id}
        }).done(function (e) {
            e=JSON.parse(e);

            //jQuery('#servername').html(e.name);
            //jQuery('.con-sprites').attr('style',"background-image: url('/assets/flags/"+e.flag+".png');");
            //jQuery('#second-connect').hide();
            //jQuery('.spinner-overlay').hide();
            //jQuery('#third-connect').show();
            
            waitpagereload = 1;
            
        }).fail(function () {
            
            waitpagereload = 1;
            
        });


    });


    jQuery('.turn_finish').click(function () {
        jQuery('#third-connect').hide();
        jQuery('.spinner-overlay').show();
        jQuery('#second-connect').show();
        jQuery('#second-connect img').attr('title', 'Disconnecting...');
        jQuery('#second-connect .turn_connect').html('Disconnecting...');
        
		jQuery('#logooff').hide();
		jQuery('#logoon').hide();
        hidelogos = 1;

        $.ajax({
            url: '/api/disconnect.php',
            timeout: 20000 // sets timeout to 20 seconds
        }).done(function (e) {
            
            if (e == 1) {
                //jQuery('.spinner-overlay').hide();
                //jQuery('#first-screen').show();
                //jQuery('#second-connect').hide();
            }
			
			waitpagereload = 1;
			
        }).fail(function () {
			
			waitpagereload = 1;
			
        });


    });


    jQuery('.menu-left li.child-menu > a').prepend('<span class="opensub"><i class="fa fa-angle-down" aria-hidden="true"></i></span>');

    jQuery('.opensub , .menu-left li.child-menu >  a').click(function (ev) {
        ev.preventDefault();
        jQuery(this).siblings('.sub-menu').toggle('slow');
        jQuery(this).find('.opensub i.fa').toggleClass("fa-angle-up fa-angle-down");

    });


    jQuery('#menuopen').click(function () {

        jQuery('.menu-overlay').addClass('mopen');
        jQuery('.menu-left').addClass('open');

    });
	
    jQuery('.menu-icon').click(function () {

        jQuery('.menu-overlay').removeClass('mopen');
        jQuery('.menu-left').removeClass('open');

    });

    jQuery('.connection').click(function () {
        window.open(ipinfo, '_blank').focus();
    });

});


function refresh() {
    document.location.reload(true);
}