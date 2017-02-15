
$(document).ready(function(){

    $('.navbar-toggle').css('display', 'none');
    

    $('input#searchbar').on('focus', function(){
    	$('#welcome').css('display', 'none');
    });
    
    
    $('input#searchbar').on('blur', function(){
    	$('#welcome').css('display', 'block');
    });
    

    $(function() {
        
        $("#searchbar").autocomplete({
            minLength: 3,
            source: function( request, response ) {
                var name = encodeURIComponent(request.term);
                $.ajax({
                    dataType: "json",
                    type : 'Get',
                    url: '/home/search_establishment?q='+name,
                    success: function(data) {
                        $('input.suggest-user').removeClass('ui-autocomplete-loading');
                        response($.map(data, function(obj) {
                                                return {
                                                    label: obj.name+' - '+obj.city,
                                                    //value: obj.name+' - '+obj.city,
                                                    value: obj.name,
                                                    url: obj.url
                                                };
                                            }
                        ));
                        $('#results').css('border', 'solid 1px #66afe9');
                    },
                    error: function(data) {
                        $('input.suggest-user').removeClass('ui-autocomplete-loading');  
                    }
                });
            },
            appendTo: "#results",
            select: function(event, ui ) {
                location.href = '/'+ui.item.url;
                $(this).val('');
                return false;
            },
            close: function(event, ui ) {
                $('#results').css('border', 'none');
            },
            messages: {
                noResults: '',
                results: function() {
                    return '';
                }
            },
            focus: function(event, ui){
                event.preventDefault();
                $(this).val(ui.item.value);
            }
        });
    });
    
    
    
    //GEOLOC
    
    $('#submit_city').on('click', function(){
    	var city = $('#geoloc_city').val();
    	userLocationRequest(city);
    });
    
    
    function userLocationRequest(city){
            $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?address="+city+"&key=AIzaSyC00YMfe4e3PPHpUNs-Zvhw5GvIy-yY3qY", function( data ) {
                var status = data.status;
                var lat = 0;
                var lng = 0;
                
                if (status=='OK') {
                    lat = data.results[0].geometry.location.lat;
                    lng = data.results[0].geometry.location.lng;
                } else {
                    //Toulouse
                    lat = 43.599998;
                    lng = 1.43333;
                }
                displayMap(lat, lng);
            });
    }
    
    function displayMap(lat, lng) {
        //Create the map geolocalized
        map = new google.maps.Map(document.getElementById("map_canvas"), {
                zoom: 12,
                center: new google.maps.LatLng(lat, lng),
                mapTypeId: google.maps.MapTypeId.ROADMAP
              });
        
        //Insert the user marker
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng), 
            map: map,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                fillColor: 'gold',
                fillOpacity: 0.9,
                scale: 8,
                strokeColor: '#1995dc',
                strokeWeight: 4
            }
        });
        
        //Fetch geocoding for all establishments
        $.getJSON("/home/geocoder", function(data) {
            $.each( data, function( key, val ) {
                displayMarker(val);
            });
        });
        
        $("#map_canvas").height($("#map_canvas").outerWidth());
        $("#map_canvas").css('display', 'block');
    }
        
        
    var marker = new Array();
    var prev_infowindow = false;
    
    function displayMarker(obj) {
        marker[obj.url] = new google.maps.Marker({
            position: new google.maps.LatLng(obj.lat, obj.lng),
            map: map,
            title: obj.name,
            icon: '/assets/theme_home/img/map_marker.png'
        });
        
        marker[obj.url].addListener('click', function() {
            if(prev_infowindow) {
                prev_infowindow.close();
            }
            prev_infowindow = infowindow;
            infowindow.open(map, marker[obj.url]);
        });
        
        contentInfo = '<h4><a href="/'+obj.url+'">'+obj.name+'</a></h4>';
        if(obj.logo!=''){
            contentInfo += '<img src="/uploads/logos/thumbnails/thumb_'+obj.logo+'" /><br />';
        }
        contentInfo += obj.formatted_address;
        contentInfo += '<br />';
        contentInfo += '<h5><a href="/'+obj.url+'">Accèdez à notre carte</a></h5>';
        
        var infowindow = new google.maps.InfoWindow({
            content: contentInfo
        });
        
    }
    
});