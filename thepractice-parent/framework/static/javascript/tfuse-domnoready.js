// Execute immediately, no DOM ready
// loading in header
(function($) {

    $.fn.serializeObject = function()
    {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = (this.value || '');
            }
        });
        return o;
    };

    $.fn.center = function () {
        this.css('position','absolute');
        this.css('top', (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + 'px');
        this.css('left', (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + 'px');
        return this;
    }

})(jQuery);

//function that shows that a field is mandatory

(function($) {
    $.fn.reddit=function() {
        if(this.is(':visible')) {
            curr=this;
        }
        else {
            curr=this.parent();
        }
        current_bg_color=curr.css('background-color');
        curr.css('background-color','red').animate({
            'background-color':current_bg_color
        },1000);
        return false;
    }
})(jQuery);

(function($) {
    $.fn.selectRange = function(start, end) {
        return this.each(function() {
            if(this.setSelectionRange) {
                this.focus();
                this.setSelectionRange(start, end);
            } else if(this.createTextRange) {
                var range = this.createTextRange();
                range.collapse(true);
                range.moveEnd('character', end);
                range.moveStart('character', start);
                range.select();
            }
        });
    }
})(jQuery);

function stripos (f_haystack, f_needle, f_offset) {
    var haystack = (f_haystack + '').toLowerCase();
    var needle = (f_needle + '').toLowerCase();
    var index = 0;
 
    if ((index = haystack.indexOf(needle, f_offset)) !== -1) {
        return index;
    }
    return false;
}

function uniqid() {
    if(typeof uniqid.id =='undefined')
        uniqid.id=0;
    else
        uniqid.id++;
    return uniqid.id;
}

/**
 * Removes [] from the end of the vars names
 */
function tf_clean_post_names(post_object, recursion) {
    if (recursion === undefined) recursion = false;
    if ( (typeof post_object) != 'object') return post_object;

    var result = (recursion ? [] : {});
    for (var id in post_object) {
        result[ jQuery.trim(id).replace(/\[\]$/, '') ] = ( (typeof post_object[id])=='object' ? tf_clean_post_names(post_object[id], true) : post_object[id] );
    }
    return result;
}

/**
 * Make form ajax submit
 */
function tf_form_bind_ajax_submit(form, data)
{
    var $       = jQuery;
    var Data    = data; // nu vede 'data' inauntru la submit()

    return $(form).submit(function(){
        showLoading();

        /**
         * Required data options:
         *
         * action:      'tf...'
         * tf_action:   '...'
         */
        var data = $.extend({
            options:     JSON.stringify( tf_clean_post_names($(this).serializeObject()) ),
            _ajax_nonce: tf_script.ajax_admin_save_options_nonce
        }, Data);

        $.ajax({
            type:       'POST',
            url:        tf_script.ajaxurl,
            data:       data,
            dataType:   "json",
            success: function(response){
                showFinishedLoading();

                if(response != null && response.reload_page == true) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                showFailLoading();
            }
        });

        return false;
    });
}

/**
 * Google maps input
 */
function tf_init_google_maps_input (_this)
{
    var $       = jQuery;
    var El      = ( _this !== undefined ? $(_this) : $(this) );
    var iD      = El.attr('id');
    var inputX  = $('input#' + iD + '_x');
    var inputY  = $('input#' + iD + '_y');
    var mapDiv  = $('#' + iD + '_map');

    new (function(){

        this.marker = null;
        this.map    = null;
        this.LatLng = null;
        this.isMoving = false; // if now user is moving the map (mouseDown+Drag?)

        this.__construct = function()
        {
            var x = inputX.val();
            x = (This.isFloat(x) ? parseFloat(x) : null );
            var y = inputY.val();
            y = (This.isFloat(y) ? parseFloat(y) : null );

            if(x !== null && y !== null){
                var mapCenter   = new google.maps.LatLng(x, y);
                var mapZoom     = 7;
                This.LatLng     = mapCenter;
            } else {
                var mapCenter   = new google.maps.LatLng(0, 0);
                var mapZoom     = 2;
                This.LatLng     = null;
            }

            This.map = new google.maps.Map(
                document.getElementById( mapDiv.attr('id') ),
                {
                    zoom:               mapZoom,
                    center:             mapCenter,
                    mapTypeId:          google.maps.MapTypeId.ROADMAP,
                    streetViewControl:  false
                }
            );

            This.setMarker(x, y);

            google.maps.event.addListener(This.map, 'click', function(event) {
                This.setMarker(event.latLng);
            });

            google.maps.event.addListener(This.map, 'mousedown', function(event) {
                This.isMoving = true;
            });
            google.maps.event.addListener(This.map, 'mouseup', function(event) {
                setTimeout(function(){
                    This.isMoving = false;
                }, 30);
            });
            google.maps.event.addListener(This.map, 'mouseout', function(event) {
                This.isMoving = false;
            });

            (function(){
                var changeFunction = function(){
                    var x = inputX.val();
                    x = (This.isFloat(x) ? parseFloat(x) : null );
                    var y = inputY.val();
                    y = (This.isFloat(y) ? parseFloat(y) : null );

                    if(x !== null && y !== null){
                        var tmp = new google.maps.LatLng(x, y);

                        El.val(tmp.lat() + ':' + tmp.lng());

                        This.setMarker(x, y, true);
                    } else {
                        El.val('');

                        if(This.marker !== null){
                            This.marker.setMap(null);
                        }
                    }
                };
                inputX.bind('blur change keyup', changeFunction);
                inputY.bind('blur change keyup', changeFunction);
            })();
        };

        this.setMarker = function(x ,y, iAmFromChange){
            var newPoint = null;

            if(typeof(x) == 'object'){
                newPoint = x; // assume google maps LatLng point
            } else {
                x = (This.isFloat(x) ? parseFloat(x) : null );
                y = (This.isFloat(y) ? parseFloat(y) : null );

                if(x !== null && y !== null){
                    newPoint = new google.maps.LatLng(x, y);
                }
            }

            if(newPoint !== null){
                if(This.marker === null){
                    This.marker = new google.maps.Marker({
                        position:   newPoint,
                        map:        This.map,
                        draggable:  true,
                        animation:  google.maps.Animation.DROP
                    });
                    google.maps.event.addListener(This.marker, 'dragend', function(event) {
                        This.setMarker(event.latLng);
                    });
                } else {
                    This.marker.setMap(This.map);
                    This.marker.setPosition(newPoint);
                }

                inputX.val( newPoint.lat() );
                inputY.val( newPoint.lng() );
                if(iAmFromChange !== undefined){
                    // This.map.setCenter(newPoint);
                } else {
                    inputX.trigger('change');
                }

                return true; // Return success
            } else {
                if(This.marker !== null){
                    This.marker.setMap(null);
                }
                return false; // Fail
            }
        };

        this.isFloat = function(value){
            if( $.trim(value) == '') return false;

            value = parseFloat(value);

            if(String(value) == 'NaN'){
                return false;
            }

            return true;
        };

        if(typeof(google) == 'undefined'){
            mapDiv.html('Error: goolge API cannot be loaded');
            return;
        }

        // __construct
        var This    = this;
        if(mapDiv.is(":visible")){
            This.__construct();
        }

        (function(){ // Fix map shift in hidden elements
            var resizeFunction  = function(){
                if (This.isMoving) return;

                google.maps.event.trigger(This.map, 'resize');

                if(This.marker !== null){
                    This.map.setCenter( This.marker.getPosition() );
                }
            };

            var mapDivState     = mapDiv.is(":visible");
            var click_function  = function(){
                if(This.map === null && mapDiv.is(":visible")){
                    This.__construct();
                }

                var newState = mapDiv.is(":visible");
                if(mapDivState != newState){
                    mapDivState = newState;
                    if(newState){
                        resizeFunction();
                    }
                }
            };

            $(document.body).click(click_function);

            var interval = setInterval(function(){ // wait until tabs are loaded (links in tabs have events with preventDefault()..)
                var tabs = $('.ui-tabs-nav', mapDiv.closest('.tf_meta_tabs'));
                mapDivState = false;
                if( tabs.length ){
                    $('a', tabs).click(click_function);
                    click_function();
                    clearInterval(interval);
                }
            }, 1000);
        })();
    })();
};
